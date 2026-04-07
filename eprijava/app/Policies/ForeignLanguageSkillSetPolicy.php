<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForeignLanguageSkillSet;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForeignLanguageSkillSetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForeignLanguageSkillSet');
    }

    public function view(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('View:ForeignLanguageSkillSet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForeignLanguageSkillSet');
    }

    public function update(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('Update:ForeignLanguageSkillSet');
    }

    public function delete(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('Delete:ForeignLanguageSkillSet');
    }

    public function restore(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('Restore:ForeignLanguageSkillSet');
    }

    public function forceDelete(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('ForceDelete:ForeignLanguageSkillSet');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForeignLanguageSkillSet');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForeignLanguageSkillSet');
    }

    public function replicate(AuthUser $authUser, ForeignLanguageSkillSet $foreignLanguageSkillSet): bool
    {
        return $authUser->can('Replicate:ForeignLanguageSkillSet');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForeignLanguageSkillSet');
    }

}