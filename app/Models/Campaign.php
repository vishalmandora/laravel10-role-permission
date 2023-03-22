<?php

namespace App\Models;

use App\Models\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CampaignScope());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
