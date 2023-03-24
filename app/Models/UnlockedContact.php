<?php

namespace App\Models;

use App\Models\Scopes\UnlockedContactScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnlockedContact extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UnlockedContactScope());
    }

    public function campaign(): BelongsTo //optional
    {
        return $this->belongsTo(Campaign::class);
    }

    public function employer(): BelongsTo //optional
    {
        return $this->belongsTo(Employer::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
