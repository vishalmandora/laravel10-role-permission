<?php

namespace App\Policies;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Str;

class EmployerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        $user->loadMissing('permissions');

        $class = Str::camel(class_basename(Employer::class));

        if ($user->hasPermissionTo("view:branch-level:{$class}")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employer $employer): bool
    {
        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        $user->loadMissing('permissions');

        $class = Str::camel(class_basename(Employer::class));

        if ($user->hasPermissionTo("view:branch-level:{$class}")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employer $employer): bool
    {
        $class = Str::camel(class_basename($employer));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        $user->loadMissing('permissions');

        if ($user->hasPermissionTo("edit:branch-level:{$class}")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employer $employer): bool
    {
        $class = Str::camel(class_basename($employer));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        $user->loadMissing('permissions');

        if ($user->hasPermissionTo("edit:branch-level:{$class}")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employer $employer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employer $employer): bool
    {
        return true;
    }
}
