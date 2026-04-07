<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AcademicTitle;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicTitlePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AcademicTitle');
    }

    public function view(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('View:AcademicTitle');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AcademicTitle');
    }

    public function update(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('Update:AcademicTitle');
    }

    public function delete(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('Delete:AcademicTitle');
    }

    public function restore(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('Restore:AcademicTitle');
    }

    public function forceDelete(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('ForceDelete:AcademicTitle');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AcademicTitle');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AcademicTitle');
    }

    public function replicate(AuthUser $authUser, AcademicTitle $academicTitle): bool
    {
        return $authUser->can('Replicate:AcademicTitle');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AcademicTitle');
    }

}