<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ForeignLanguageSkill extends Model
{
    protected static function booted(): void
    {
        static::updating(function (self $record) {
            if ($record->isDirty('certificate_attachment') && $record->getOriginal('certificate_attachment')) {
                Storage::disk('public')->delete($record->getOriginal('certificate_attachment'));
            }
        });

        static::deleting(function (self $record) {
            if ($record->certificate_attachment) {
                Storage::disk('public')->delete($record->certificate_attachment);
            }
        });
    }

    protected $table = 'foreign_language_skills';

    protected $fillable = [
        'user_id',
        'language',
        'level',
        'has_certificate',
        'year_of_examination',
        'exemption_requested',
        'certificate_attachment',
    ];

    protected $casts = [
        'has_certificate'    => 'boolean',
        'exemption_requested' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
