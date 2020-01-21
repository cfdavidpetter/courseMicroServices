<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'order_id',
        'payment_type',
        'description',
        'amount',
        'payment_date',
    ];

    /**
     * Eloquent: Relationships
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
