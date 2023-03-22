<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function sub_team()
    {
        return $this->belongsTo(self::class, 'id', 'parent_id');
    }

    public function parent_team()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
