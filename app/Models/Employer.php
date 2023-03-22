<?php

namespace App\Models;

use App\Models\Scopes\EmployerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EmployerScope());
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function messageTemplates()
    {
        return $this->hasMany(MessageTemplate::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
