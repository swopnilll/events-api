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
}
