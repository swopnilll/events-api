<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_date',
    ];

    /**
     * Relationship: A transaction belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A transaction belongs to an event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
