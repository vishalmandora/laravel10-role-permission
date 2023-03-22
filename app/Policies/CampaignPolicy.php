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
        return true;
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

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        if ($user->hasRole('Business-User')) {
            $user->loadMissing('permissions');

            if ($user->hasPermissionTo("create:everything:{$class}")) {
                return true;
            }

            if ($user->hasPermissionTo("create:ownedByTeamMember:{$class}")) {
                $user->loadMissing('teams');

                $teams = $user->teams->pluck('name');

                //        if in_array($user->id, )
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        $class = Str::camel(class_basename($campaign));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        if ($user->hasRole('Business-User')) {
            $user->loadMissing('permissions');

            if ($user->hasPermissionTo("edit:everything:{$class}")) {
                return true;
            }

            if ($user->hasPermissionTo("edit:owned:{$class}") && $user->id === $campaign->owner_id) {
                return true;
            }

            if ($user->hasPermissionTo("edit:ownedByTeamMember:{$class}")) {
                $user->loadMissing('teams');

                $teams = $user->teams->pluck('name');

                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        $class = Str::camel(class_basename($campaign));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        if ($user->hasRole('Business-User')) {
            $user->loadMissing('permissions');

            if ($user->hasPermissionTo("delete:everything:{$class}")) {
                return true;
            }

            if ($user->hasPermissionTo("delete:owned:{$class}") && $user->id === $campaign->owner_id) {
                return true;
            }

            if ($user->hasPermissionTo("delete:ownedByTeamMember:{$class}")) {
                $user->loadMissing('teams');

                $teams = $user->teams->pluck('name');

                //        if in_array($user->id, )
                return true;
            }
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
