<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pricing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'duration',
    ];

    // public function transaction(): HasMany
    // {
    //     return $this->hasMany(Transaction::class);
    // }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'pricing_id');
    }

    public function isSubscribedByUser($userId)
    {
        return $this->transactions()
            ->where('user_id', $userId)
            ->where('is_paid', true) // Only consider paid subscriptions
            ->where('ended_at', '>=', now()) // Check if the subscription is still active
            ->exists();
    }
}
