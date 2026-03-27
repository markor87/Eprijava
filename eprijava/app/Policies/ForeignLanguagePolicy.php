<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForeignLanguage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForeignLanguagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForeignLanguage');
    }

    public function view(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('View:ForeignLanguage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForeignLanguage');
    }

    public function update(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('Update:ForeignLanguage');
    }

    public function delete(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('Delete:ForeignLanguage');
    }

    public function restore(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('Restore:ForeignLanguage');
    }

    public function forceDelete(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('ForceDelete:ForeignLanguage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForeignLanguage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForeignLanguage');
    }

    public function replicate(AuthUser $authUser, ForeignLanguage $foreignLanguage): bool
    {
        return $authUser->can('Replicate:ForeignLanguage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForeignLanguage');
    }

}