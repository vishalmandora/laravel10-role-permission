<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnlockedContact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employer() //optional
    {
        return $this->belongsTo(Employer::class);
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
