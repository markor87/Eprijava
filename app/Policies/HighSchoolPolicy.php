<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HighSchool;
use Illuminate\Auth\Access\HandlesAuthorization;

class HighSchoolPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HighSchool');
    }

    public function view(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('View:HighSchool');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HighSchool');
    }

    public function update(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('Update:HighSchool');
    }

    public function delete(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('Delete:HighSchool');
    }

    public function restore(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('Restore:HighSchool');
    }

    public function forceDelete(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('ForceDelete:HighSchool');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HighSchool');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HighSchool');
    }

    public function replicate(AuthUser $authUser, HighSchool $highSchool): bool
    {
        return $authUser->can('Replicate:HighSchool');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HighSchool');
    }

}