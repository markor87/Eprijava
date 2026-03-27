<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ComputerSkill;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComputerSkillPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ComputerSkill');
    }

    public function view(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('View:ComputerSkill');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ComputerSkill');
    }

    public function update(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('Update:ComputerSkill');
    }

    public function delete(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('Delete:ComputerSkill');
    }

    public function restore(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('Restore:ComputerSkill');
    }

    public function forceDelete(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('ForceDelete:ComputerSkill');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ComputerSkill');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ComputerSkill');
    }

    public function replicate(AuthUser $authUser, ComputerSkill $computerSkill): bool
    {
        return $authUser->can('Replicate:ComputerSkill');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ComputerSkill');
    }

}