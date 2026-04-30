<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\NationalMinority;
use Illuminate\Auth\Access\HandlesAuthorization;

class NationalMinorityPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:NationalMinority');
    }

    public function view(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('View:NationalMinority');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:NationalMinority');
    }

    public function update(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('Update:NationalMinority');
    }

    public function delete(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('Delete:NationalMinority');
    }

    public function restore(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('Restore:NationalMinority');
    }

    public function forceDelete(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('ForceDelete:NationalMinority');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:NationalMinority');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:NationalMinority');
    }

    public function replicate(AuthUser $authUser, NationalMinority $nationalMinority): bool
    {
        return $authUser->can('Replicate:NationalMinority');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:NationalMinority');
    }

}