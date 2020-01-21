<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
    ];

    /**
     * Eloquent: Relationships
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
