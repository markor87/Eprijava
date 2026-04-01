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

    public function view(AuthUser $authUser, ForeignLanguageSkillSet $record): bool
    {
        return $authUser->can('View:ForeignLanguageSkillSet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForeignLanguageSkillSet');
    }

    public function update(AuthUser $authUser, ForeignLanguageSkillSet $record): bool
    {
        return $authUser->can('Update:ForeignLanguageSkillSet');
    }

    public function delete(AuthUser $authUser, ForeignLanguageSkillSet $record): bool
    {
        return $authUser->can('Delete:ForeignLanguageSkillSet');
    }
}
