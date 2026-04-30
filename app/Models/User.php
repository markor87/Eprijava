<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Auth\MultiFactor\Email\Concerns\InteractsWithEmailAuthentication;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasEmailAuthentication, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithEmailAuthentication;

    public function getFilamentName(): string
    {
        return $this->name ?? $this->email;
    }

    public function candidate(): HasOne
    {
        return $this->hasOne(Candidate::class);
    }

    public function highSchoolEducations(): HasMany
    {
        return $this->hasMany(HighSchoolEducation::class);
    }

    public function higherEducations(): HasMany
    {
        return $this->hasMany(HigherEducation::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function additionalTrainings(): HasMany
    {
        return $this->hasMany(AdditionalTraining::class);
    }

    public function foreignLanguageSkills(): HasMany
    {
        return $this->hasMany(ForeignLanguageSkill::class);
    }

    public function foreignLanguageSkillSet(): HasOne
    {
        return $this->hasOne(ForeignLanguageSkillSet::class);
    }

    public function computerSkill(): HasOne
    {
        return $this->hasOne(ComputerSkill::class);
    }

    public function vacancySource(): HasOne
    {
        return $this->hasOne(VacancySource::class);
    }

    public function declaration(): HasOne
    {
        return $this->hasOne(Declaration::class);
    }

    public function trainingSet(): HasOne
    {
        return $this->hasOne(TrainingSet::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'government_body_id',
        'email',
        'password',
        'has_email_authentication',
    ];

    public function governmentBody(): BelongsTo
    {
        return $this->belongsTo(GovernmentBody::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
