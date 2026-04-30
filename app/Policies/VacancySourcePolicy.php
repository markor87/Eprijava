<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\VacancySource;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancySourcePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VacancySource');
    }

    public function view(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('View:VacancySource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VacancySource');
    }

    public function update(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('Update:VacancySource');
    }

    public function delete(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('Delete:VacancySource');
    }

    public function restore(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('Restore:VacancySource');
    }

    public function forceDelete(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('ForceDelete:VacancySource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VacancySource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VacancySource');
    }

    public function replicate(AuthUser $authUser, VacancySource $vacancySource): bool
    {
        return $authUser->can('Replicate:VacancySource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VacancySource');
    }

}