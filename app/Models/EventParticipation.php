<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipation extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'role_id',
        'payment_status',
        'ticket_id',
    ];

    /**
     * Relationship: An event participation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: An event participation belongs to an event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relationship: An event participation has a role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship: An event participation may be associated with one ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
