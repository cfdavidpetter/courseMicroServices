<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Customer extends Model
{
    use Uuids;
    
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zipcode',
    ];

    /**
     * Eloquent: Relationships
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
