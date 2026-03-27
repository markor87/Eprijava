<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HighSchoolEducation;
use Illuminate\Auth\Access\HandlesAuthorization;

class HighSchoolEducationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HighSchoolEducation');
    }

    public function view(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('View:HighSchoolEducation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HighSchoolEducation');
    }

    public function update(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('Update:HighSchoolEducation');
    }

    public function delete(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('Delete:HighSchoolEducation');
    }

    public function restore(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('Restore:HighSchoolEducation');
    }

    public function forceDelete(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('ForceDelete:HighSchoolEducation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HighSchoolEducation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HighSchoolEducation');
    }

    public function replicate(AuthUser $authUser, HighSchoolEducation $highSchoolEducation): bool
    {
        return $authUser->can('Replicate:HighSchoolEducation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HighSchoolEducation');
    }

}