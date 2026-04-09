<?php

namespace App\Filament\Pages;

use App\Models\Application;
use App\Models\Competition;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use UnitEnum;
use ZipArchive;

class Sertifikati extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;
    protected static string|UnitEnum|null   $navigationGroup = 'Конкурси';
    protected static ?int                   $navigationSort  = 10;
    protected string                        $view = 'filament.pages.sertifikati';

    public static function getNavigationLabel(): string
    {
        return 'Сертификати';
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('view_sertifikati'));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Application::query()->with(['competition.governmentBody']))
            ->columns([
                TextColumn::make('competition_display')
                    ->label('Конкурс')
                    ->getStateUsing(fn(Application $record) => implode(' ', array_filter([
                        $record->competition?->governmentBody?->name,
                        $record->competition?->datum_od?->format('d.m.Y.'),
                    ])))
                    ->placeholder('—'),

                TextColumn::make('user_id')
                    ->label('ID корисника')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label('Ime')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label('Презиме')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('national_id')
                    ->label('ЈМБГ')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('competition_id')
                    ->label('Конкурс')
                    ->options(
                        Competition::with('governmentBody')->get()->mapWithKeys(fn($c) => [
                            $c->id => implode(' ', array_filter([
                                $c->governmentBody?->name,
                                $c->datum_od?->format('d.m.Y.'),
                            ])),
                        ])
                    ),
            ])
            ->recordActions([
                Action::make('download_foreign_lang')
                    ->label('Страни језик')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(fn(Application $record) => $this->downloadForeignLang($record))
                    ->hidden(fn(Application $record) =>
                        empty(array_filter((array) ($record->profile_snapshot['foreignSkillSet']['certificate_attachment'] ?? [])))
                    ),

                Action::make('download_computer')
                    ->label('Рачунар')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(fn(Application $record) => $this->downloadComputer($record))
                    ->hidden(fn(Application $record) => empty(array_filter([
                        $record->profile_snapshot['computerSkill']['word_certificate_attachment']     ?? null,
                        $record->profile_snapshot['computerSkill']['excel_certificate_attachment']    ?? null,
                        $record->profile_snapshot['computerSkill']['internet_certificate_attachment'] ?? null,
                    ]))),
            ])
            ->headerActions([
                Action::make('download_all_foreign')
                    ->label('Преузми све (страни језици)')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(fn() => $this->downloadAllForeignLang()),

                Action::make('download_all_computer')
                    ->label('Преузми све (рачунар)')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(fn() => $this->downloadAllComputer()),
            ]);
    }

    private function baseName(Application $record): string
    {
        return implode('_', array_filter([
            $record->user_id,
            $record->first_name,
            $record->last_name,
            $record->national_id,
        ]));
    }

    private function downloadForeignLang(Application $record): mixed
    {
        $files = array_values(array_filter(
            (array) ($record->profile_snapshot['foreignSkillSet']['certificate_attachment'] ?? [])
        ));
        $base = $this->baseName($record);

        if (count($files) === 1) {
            $path = $files[0];
            return response()->streamDownload(
                fn() => print(Storage::disk('local')->get($path)),
                $base . '.' . pathinfo($path, PATHINFO_EXTENSION)
            );
        }

        return $this->zipFiles(
            collect($files)->mapWithKeys(fn($path, $i) =>
                [$base . '_' . ($i + 1) . '.' . pathinfo($path, PATHINFO_EXTENSION) => $path]
            )->all(),
            $base . '_strani_jezici.zip'
        );
    }

    private function downloadComputer(Application $record): mixed
    {
        $snap = $record->profile_snapshot['computerSkill'] ?? [];
        $base = $this->baseName($record);
        $attachments = array_filter([
            'word'     => $snap['word_certificate_attachment']     ?? null,
            'excel'    => $snap['excel_certificate_attachment']    ?? null,
            'internet' => $snap['internet_certificate_attachment'] ?? null,
        ]);

        if (count($attachments) === 1) {
            $type = key($attachments);
            $path = current($attachments);
            return response()->streamDownload(
                fn() => print(Storage::disk('local')->get($path)),
                "{$base}_{$type}." . pathinfo($path, PATHINFO_EXTENSION)
            );
        }

        return $this->zipFiles(
            collect($attachments)->mapWithKeys(fn($path, $type) =>
                ["{$base}_{$type}." . pathinfo($path, PATHINFO_EXTENSION) => $path]
            )->all(),
            $base . '_racunar.zip'
        );
    }

    private function downloadAllForeignLang(): mixed
    {
        $entries = [];
        foreach (Application::all() as $app) {
            $files = array_values(array_filter(
                (array) ($app->profile_snapshot['foreignSkillSet']['certificate_attachment'] ?? [])
            ));
            if (empty($files)) continue;
            $base = $this->baseName($app);
            foreach ($files as $i => $path) {
                $ext  = pathinfo($path, PATHINFO_EXTENSION);
                $name = count($files) > 1 ? "{$base}_" . ($i + 1) . ".{$ext}" : "{$base}.{$ext}";
                $entries[$name] = $path;
            }
        }
        return $this->zipFiles($entries, 'sertifikati_strani_jezici.zip');
    }

    private function downloadAllComputer(): mixed
    {
        $entries = [];
        foreach (Application::all() as $app) {
            $snap = $app->profile_snapshot['computerSkill'] ?? [];
            $base = $this->baseName($app);
            foreach (array_filter([
                'word'     => $snap['word_certificate_attachment']     ?? null,
                'excel'    => $snap['excel_certificate_attachment']    ?? null,
                'internet' => $snap['internet_certificate_attachment'] ?? null,
            ]) as $type => $path) {
                $entries["{$base}_{$type}." . pathinfo($path, PATHINFO_EXTENSION)] = $path;
            }
        }
        return $this->zipFiles($entries, 'sertifikati_racunar.zip');
    }

    /** @param array<string, string> $entries  filename => storage path */
    private function zipFiles(array $entries, string $zipName): mixed
    {
        if (empty($entries)) {
            Notification::make()->warning()->title('Нема сертификата')->send();
            return null;
        }
        $tmp = tempnam(sys_get_temp_dir(), 'cert_');
        $zip = new ZipArchive();
        $zip->open($tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($entries as $name => $path) {
            if (Storage::disk('local')->exists($path)) {
                $zip->addFromString($name, Storage::disk('local')->get($path));
            }
        }
        $zip->close();
        return response()->download($tmp, $zipName)->deleteFileAfterSend(true);
    }
}
