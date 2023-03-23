<?php

namespace App\Models\Scopes;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Str;

class EmployerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $class = Str::camel(class_basename(Employer::class));

        if (auth()->user() && auth()->user()->hasRole(ROLE_BUSINESS_USER)) {
            if (auth()->user()->hasPermissionTo("view:branch-level:{$class}")) {
                $builder->whereHas('teams', function ($query) {
                    $query->whereIn('id', auth()->user()->teams()->select('id'));
                });
            }
        }
    }
}
