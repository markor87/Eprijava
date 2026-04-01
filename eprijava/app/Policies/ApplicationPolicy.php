<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Application;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Application');
    }

    public function view(AuthUser $authUser, Application $record): bool
    {
        return $authUser->can('View:Application');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Application');
    }

    public function update(AuthUser $authUser, Application $record): bool
    {
        return $authUser->can('Update:Application');
    }

    public function delete(AuthUser $authUser, Application $record): bool
    {
        return $authUser->can('Delete:Application');
    }
}
