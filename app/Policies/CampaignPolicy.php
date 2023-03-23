<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Str;

class CampaignPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole(ROLE_BUSINESS_OWNER)) {
            return true;
        }

        $user->loadMissing('permissions');

        $class = Str::camel(class_basename(Campaign::class));

        if ($user->hasPermissionTo("view:branch-level:{$class}") || $user->hasPermissionTo("view:team-level:{$class}") || $user->hasPermissionTo("view:user-level:{$class}")) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $class = Str::camel(class_basename(Campaign::class));

        if ($user->hasRole(ROLE_BUSINESS_OWNER)) {
            return true;
        }

        $user->loadMissing('permissions');

        if ($user->hasPermissionTo("edit:branch-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:team-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:user-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:none:{$class}")) {
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        $class = Str::camel(class_basename(Campaign::class));

        if ($user->hasRole(ROLE_BUSINESS_OWNER)) {
            return true;
        }

        $user->loadMissing('permissions');

        if ($user->hasPermissionTo("edit:branch-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:team-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:user-level:{$class}")) {
            return $user->id === $campaign->owner_id;
        }

        if ($user->hasPermissionTo("edit:none:{$class}")) {
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        $class = Str::camel(class_basename(Campaign::class));

        if ($user->hasRole(ROLE_BUSINESS_OWNER)) {
            return true;
        }

        $user->loadMissing('permissions');

        if ($user->hasPermissionTo("edit:branch-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:team-level:{$class}")) {
            return true;
        }

        if ($user->hasPermissionTo("edit:user-level:{$class}")) {
            return $user->id === $campaign->owner_id;
        }

        if ($user->hasPermissionTo("edit:none:{$class}")) {
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return true;
    }
}
