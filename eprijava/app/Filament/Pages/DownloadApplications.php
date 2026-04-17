<?php

namespace App\Filament\Pages;

use App\Models\Application;
use App\Models\Competition;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use UnitEnum;

class DownloadApplications extends Page implements HasTable
{
    use HasPageShield;
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;
    protected static string|UnitEnum|null   $navigationGroup = 'Конкурси';
    protected static ?int                   $navigationSort  = 5;
    protected static ?string                $slug = 'download-applications';
    protected string                        $view = 'filament.pages.download-applications';

    public bool $isGenerating = false;

    public static function getNavigationLabel(): string
    {
        return 'Преузимање пријава';
    }

    public function table(Table $table): Table
    {
        $user  = Auth::user();
        $query = Competition::query()->with('governmentBody');

        if (!$user->hasRole('super_admin')) {
            $query->where('government_body_id', $user->government_body_id);
        }

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('governmentBody.name')
                    ->label('Државни орган')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('datum_od')
                    ->label('Датум објаве')
                    ->date('d.m.Y.')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                Action::make('download_applications')
                    ->label('Преузми пријаве')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->hidden(fn(Competition $record) => Application::where('competition_id', $record->id)->doesntExist())
                    ->disabled(fn() => $this->isGenerating)
                    ->action(function (Competition $record) {
                        $this->isGenerating = true;
                        $this->dispatch('start-zip-generation', competitionId: $record->id);
                    }),
            ])
            ->toolbarActions([]);
    }

    /** Called by Alpine when the SSE stream finishes (success or error). */
    public function finishDownload(): void
    {
        $this->isGenerating = false;
    }

    /** Called by Alpine when SSE drops — checks if ZIP finished anyway. */
    public function checkZipReady(int $competitionId): void
    {
        $data = Cache::get("zip_ready_{$competitionId}");
        if ($data) {
            $this->dispatch('zip-ready', token: $data['token'], filename: $data['filename']);
        } else {
            $this->isGenerating = false;
        }
    }
}
