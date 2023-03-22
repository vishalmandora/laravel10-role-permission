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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employer $employer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $class = Str::camel(class_basename(Employer::class));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        if ($user->hasRole('Business-User')) {
            $user->loadMissing('permissions');

            if ($user->hasPermissionTo("create:everything:{$class}")) {
                return true;
            }

//            if ($user->hasPermissionTo("create:owned:{$class}") && $user->id === $employer->owner_id) {
//                return true;
//            }

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
    public function update(User $user, Employer $employer): bool
    {
        $class = Str::camel(class_basename($employer));

        if ($user->hasRole('Business-Owner')) {
            return true;
        }

        if ($user->hasRole('Business-User')) {
            //get the permission of the user.
            $user->loadMissing('permissions');

            //        edit:everything:employer return true
            if ($user->hasPermissionTo("edit:everything:{$class}")) {
                return true;
            }

            //    edit:owned:employer
            //    $employer->owner_id == $user->id > return true
            if ($user->hasPermissionTo("edit:owned:{$class}") && $user->id === $employer->owner_id) {
                return true;
            }

            //    edit:ownedByTeamMember:employer
            if ($user->hasPermissionTo("edit:ownedByTeamMember:{$class}")) {
                //   get the teams of the user.
                $user->loadMissing('teams');

                //   GetTeamMemberIdsOfAllRelatingTeamsOfUser = [....]
                $teams = $user->teams->pluck('name');

                //        if in_array($user->id, )
                return true;
            }
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

        if ($user->hasRole('Business-User')) {
            $user->loadMissing('permissions');

            if ($user->hasPermissionTo("delete:everything:{$class}")) {
                return true;
            }

            if ($user->hasPermissionTo("delete:owned:{$class}") && $user->id === $employer->owner_id) {
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
