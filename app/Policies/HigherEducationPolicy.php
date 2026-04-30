<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HigherEducation;
use Illuminate\Auth\Access\HandlesAuthorization;

class HigherEducationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HigherEducation');
    }

    public function view(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('View:HigherEducation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HigherEducation');
    }

    public function update(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('Update:HigherEducation');
    }

    public function delete(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('Delete:HigherEducation');
    }

    public function restore(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('Restore:HigherEducation');
    }

    public function forceDelete(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('ForceDelete:HigherEducation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HigherEducation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HigherEducation');
    }

    public function replicate(AuthUser $authUser, HigherEducation $higherEducation): bool
    {
        return $authUser->can('Replicate:HigherEducation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HigherEducation');
    }

}