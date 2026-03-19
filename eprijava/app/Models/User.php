<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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

    public function computerSkill(): HasOne
    {
        return $this->hasOne(ComputerSkill::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
