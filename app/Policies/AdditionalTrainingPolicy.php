<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AdditionalTraining;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdditionalTrainingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AdditionalTraining');
    }

    public function view(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('View:AdditionalTraining');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AdditionalTraining');
    }

    public function update(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('Update:AdditionalTraining');
    }

    public function delete(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('Delete:AdditionalTraining');
    }

    public function restore(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('Restore:AdditionalTraining');
    }

    public function forceDelete(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('ForceDelete:AdditionalTraining');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AdditionalTraining');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AdditionalTraining');
    }

    public function replicate(AuthUser $authUser, AdditionalTraining $additionalTraining): bool
    {
        return $authUser->can('Replicate:AdditionalTraining');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AdditionalTraining');
    }

}