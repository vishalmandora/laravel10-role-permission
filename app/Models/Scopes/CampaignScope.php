<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Str;

class CampaignScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $class = Str::camel(class_basename(Campaign::class));

        if (auth()->user() && auth()->user()->hasRole(ROLE_BUSINESS_USER)) {
            if (auth()->user()->hasPermissionTo("view:branch-level:{$class}")) {
                $builder->whereHas('employer', function ($builder) {
                    $builder->whereHas('teams', function ($query) {
                        $query->whereIn('id', auth()->user()->teams()->select('id'));
                    });
                });
            }

            if (auth()->user()->hasPermissionTo("view:team-level:{$class}")) {
//                $builder->whereHas('employer', function ($builder) use ($model) {
//                    $builder->whereHas('teams', function ($query) use ($model) {
//                        $query->where('id', $model->owner_id); // get campaign's owner here
//                    });
//                });
            }

            if (auth()->user()->hasPermissionTo("view:user-level:{$class}")) {
                $builder->where('owner_id', auth()->id());
            }
        }
    }
}
