<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TrainingSet;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingSetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TrainingSet');
    }

    public function view(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('View:TrainingSet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TrainingSet');
    }

    public function update(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('Update:TrainingSet');
    }

    public function delete(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('Delete:TrainingSet');
    }

    public function restore(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('Restore:TrainingSet');
    }

    public function forceDelete(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('ForceDelete:TrainingSet');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TrainingSet');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TrainingSet');
    }

    public function replicate(AuthUser $authUser, TrainingSet $trainingSet): bool
    {
        return $authUser->can('Replicate:TrainingSet');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TrainingSet');
    }

}