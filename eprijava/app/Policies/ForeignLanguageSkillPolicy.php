<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForeignLanguageSkill;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForeignLanguageSkillPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForeignLanguageSkill');
    }

    public function view(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('View:ForeignLanguageSkill');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForeignLanguageSkill');
    }

    public function update(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('Update:ForeignLanguageSkill');
    }

    public function delete(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('Delete:ForeignLanguageSkill');
    }

    public function restore(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('Restore:ForeignLanguageSkill');
    }

    public function forceDelete(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('ForceDelete:ForeignLanguageSkill');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForeignLanguageSkill');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForeignLanguageSkill');
    }

    public function replicate(AuthUser $authUser, ForeignLanguageSkill $foreignLanguageSkill): bool
    {
        return $authUser->can('Replicate:ForeignLanguageSkill');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForeignLanguageSkill');
    }

}