<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_type',
        'ticket_status',
        'purchase_date',
        'price',
        'generated_code',
        'entry_password',
    ];

    /**
     * Relationship: A ticket belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A ticket belongs to an event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relationship: A ticket may be associated with one event participation.
     */
    public function eventParticipation()
    {
        return $this->hasOne(EventParticipation::class);
    }
}
