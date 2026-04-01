<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AcademicTitle;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

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
}
