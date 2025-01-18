<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
