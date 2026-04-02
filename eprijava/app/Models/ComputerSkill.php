<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ComputerSkill extends Model
{
    protected $table = 'computer_skills';

    protected $fillable = [
        'user_id',
        'word_has_certificate',
        'word_certificate_year',
        'word_certificate_attachment',
        'excel_has_certificate',
        'excel_certificate_year',
        'excel_certificate_attachment',
        'internet_has_certificate',
        'internet_certificate_year',
        'internet_certificate_attachment',
        'word_exemption_requested',
        'excel_exemption_requested',
        'internet_exemption_requested',
    ];

    protected $casts = [
        'word_has_certificate'        => 'boolean',
        'excel_has_certificate'       => 'boolean',
        'internet_has_certificate'    => 'boolean',
        'word_exemption_requested'    => 'boolean',
        'excel_exemption_requested'   => 'boolean',
        'internet_exemption_requested' => 'boolean',
    ];

    protected static function booted(): void
    {
        $attachmentColumns = [
            'word_certificate_attachment',
            'excel_certificate_attachment',
            'internet_certificate_attachment',
        ];

        static::updating(function (self $record) use ($attachmentColumns) {
            foreach ($attachmentColumns as $col) {
                if ($record->isDirty($col) && $record->getOriginal($col)) {
                    Storage::disk('local')->delete($record->getOriginal($col));
                }
            }
        });

        static::deleting(function (self $record) use ($attachmentColumns) {
            foreach ($attachmentColumns as $col) {
                if ($record->$col) {
                    Storage::disk('local')->delete($record->$col);
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
