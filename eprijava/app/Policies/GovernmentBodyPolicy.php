<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GovernmentBody;
use Illuminate\Auth\Access\HandlesAuthorization;

class GovernmentBodyPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GovernmentBody');
    }

    public function view(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('View:GovernmentBody');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GovernmentBody');
    }

    public function update(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('Update:GovernmentBody');
    }

    public function delete(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('Delete:GovernmentBody');
    }

    public function restore(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('Restore:GovernmentBody');
    }

    public function forceDelete(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('ForceDelete:GovernmentBody');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GovernmentBody');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GovernmentBody');
    }

    public function replicate(AuthUser $authUser, GovernmentBody $governmentBody): bool
    {
        return $authUser->can('Replicate:GovernmentBody');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GovernmentBody');
    }

}