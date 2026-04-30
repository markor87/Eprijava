<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\RequiredProof;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequiredProofPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:RequiredProof');
    }

    public function view(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('View:RequiredProof');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:RequiredProof');
    }

    public function update(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('Update:RequiredProof');
    }

    public function delete(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('Delete:RequiredProof');
    }

    public function restore(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('Restore:RequiredProof');
    }

    public function forceDelete(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('ForceDelete:RequiredProof');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:RequiredProof');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:RequiredProof');
    }

    public function replicate(AuthUser $authUser, RequiredProof $requiredProof): bool
    {
        return $authUser->can('Replicate:RequiredProof');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:RequiredProof');
    }

}