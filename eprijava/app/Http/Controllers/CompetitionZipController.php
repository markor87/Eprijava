<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Competition;
use App\Models\ForeignLanguageSkillSet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ZipArchive;

class CompetitionZipController extends Controller
{
    public function generate(Competition $competition)
    {
        $user = Auth::user();
        abort_unless(
            $user && ($user->hasRole('super_admin') || $user->can('View:DownloadApplications')),
            403
        );
        if (!$user->hasRole('super_admin')) {
            abort_unless($competition->government_body_id === $user->government_body_id, 403);
        }

        $competition->loadMissing('governmentBody');

        $cancelKey = Str::uuid()->toString();
        session()->save();

        return response()->stream(function () use ($competition, $cancelKey) {
            set_time_limit(0);
            ini_set('memory_limit', '-1');
            ini_set('zlib.output_compression', false);
            ignore_user_abort(true);

            $total = Application::where('competition_id', $competition->id)->count();
            $this->sse(['cancelKey' => $cancelKey, 'current' => 0, 'total' => $total]);

            $tmp = tempnam(sys_get_temp_dir(), 'prijave_');
            $zip = new ZipArchive();
            $zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            $current = 0;
            foreach (Application::where('competition_id', $competition->id)->cursor() as $app) {
                if (Cache::pull("zip_cancel_{$cancelKey}")) {
                    $zip->close();
                    @unlink($tmp);
                    $this->sse(['cancelled' => true]);
                    return;
                }

                $profileData = $this->buildProfileData($app);

                $pdf = Pdf::loadView('pdf.application', array_merge(
                    [
                        'record'        => $app->load(['jobPosition', 'competition', 'governmentBody']),
                        'showSignature' => true,
                    ],
                    $profileData
                ))->setPaper('a4', 'portrait');

                $filename = implode('_', array_filter([
                    $app->first_name,
                    $app->last_name,
                    $app->national_id,
                    $app->candidate_code,
                ])) . '.pdf';

                $zip->addFromString($filename, $pdf->output());
                unset($pdf);
                $current++;
                $this->sse(['current' => $current, 'total' => $total]);
            }

            $zip->close();

            $token   = Str::uuid()->toString();
            $destDir = storage_path('app/downloads');
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            $dest = $destDir . '/' . $token . '.zip';
            if (!rename($tmp, $dest)) {
                copy($tmp, $dest);
                unlink($tmp);
            }

            $organName = preg_replace('/[^\p{L}\p{N}]+/u', '_', $competition->governmentBody?->name ?? 'organ');
            $date      = $competition->datum_od?->format('d.m.Y.') ?? 'datum';
            $zipName   = "prijave_{$organName}_{$date}.zip";

            Cache::put("zip_token_{$token}", ['path' => $dest, 'filename' => $zipName], 86400);
            Cache::put("zip_ready_{$competition->id}", ['token' => $token, 'filename' => $zipName], 86400);

            $this->sse(['done' => true, 'token' => $token, 'filename' => $zipName]);

            for ($i = 0; $i < 5; $i++) {
                ob_flush();
                flush();
                usleep(200000);
            }

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-store',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ]);
    }

    public function cancel(string $cancelKey)
    {
        Cache::put("zip_cancel_{$cancelKey}", true, 300);
        return response()->noContent();
    }

    public function download(string $token)
    {
        $user = Auth::user();
        abort_unless(
            $user && ($user->hasRole('super_admin') || $user->can('View:DownloadApplications')),
            403
        );

        $data = Cache::pull("zip_token_{$token}");
        abort_unless($data && file_exists($data['path']), 404);

        return response()->download($data['path'], $data['filename'])->deleteFileAfterSend(true);
    }

    private function sse(array $data): void
    {
        echo 'data: ' . json_encode($data) . "\n\n";
        ob_flush();
        flush();
    }

    private function buildProfileData(Application $app): array
    {
        if ($app->profile_snapshot !== null) {
            return $app->hydrateSnapshotForPdf();
        }

        $user = $app->user;
        return [
            'candidate'           => $user->candidate?->load(['placeOfBirth', 'addressCity', 'deliveryCity']),
            'highSchoolEducation' => $user->highSchoolEducations()->first(),
            'higherEducations'    => $user->higherEducations()->with(['academicTitle', 'institutionLocation'])->get(),
            'workExperiences'     => $user->workExperiences()->orderByDesc('period_from')->get(),
            'trainings'           => $user->trainingSet?->trainings()->with('examType')->orderBy('exam_date')->get() ?? collect(),
            'foreignSkillSet'     => ForeignLanguageSkillSet::where('user_id', $user->id)
                                        ->with('foreignLanguageSkills.foreignLanguage')
                                        ->first(),
            'computerSkill'       => $user->computerSkill,
            'additionalTrainings' => $user->additionalTrainings()->orderBy('year')->get(),
            'declaration'         => $user->declaration?->load([
                                        'declarationProofs.requiredProof',
                                        'declarationMinorities.nationalMinority',
                                    ]),
            'vacancySource'       => $user->vacancySource,
        ];
    }
}
