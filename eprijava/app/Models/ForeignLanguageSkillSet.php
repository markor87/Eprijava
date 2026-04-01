<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ForeignLanguageSkillSet extends Model
{
    protected static function booted(): void
    {
        static::updating(function (self $record) {
            if ($record->isDirty('certificate_attachment')) {
                $removed = array_diff(
                    (array) $record->getOriginal('certificate_attachment'),
                    (array) $record->certificate_attachment
                );
                foreach ($removed as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });

        static::deleting(function (self $record) {
            foreach ((array) $record->certificate_attachment as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }

    protected $fillable = ['user_id', 'certificate_attachment'];

    protected $casts = [
        'certificate_attachment' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foreignLanguageSkills(): HasMany
    {
        return $this->hasMany(ForeignLanguageSkill::class);
    }
}
