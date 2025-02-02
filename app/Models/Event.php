<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'category_id',
        'language',
        'event_type',
        'location',
        'online_link',
        'is_paid',
        'max_capacity',
        'current_capacity',
        'created_by',
        'price',
    ];

    /**
     * Relationship: An event belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participations()
    {
        return $this->hasMany(EventParticipation::class);
    }

    /**
     * Relationship: An event can have many tickets.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Relationship: An event can have many transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // An event has many images (EventImage model)
    public function eventImages()
    {
        return $this->hasMany(EventImage::class);
    }
}
