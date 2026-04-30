<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForeignLanguageSkillSet extends Model
{
    protected $fillable = ['user_id', 'certificate_attachment'];

    protected $casts = [
        'certificate_attachment' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function ($model) {
            foreach ($model->certificate_attachment ?? [] as $path) {
                if ($path) {
                    Attachment::firstOrCreate(
                        ['path'    => $path],
                        ['user_id' => $model->user_id],
                    );
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foreignLanguageSkills(): HasMany
    {
        return $this->hasMany(ForeignLanguageSkill::class);
    }
}
