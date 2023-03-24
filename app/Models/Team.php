<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

//    public function sub_team()
//    {
//        return $this->belongsTo(self::class, 'id', 'parent_id');
//    }
//
//    public function parent_team()
//    {
//        return $this->belongsTo(self::class, 'parent_id', 'id');
//    }
}
