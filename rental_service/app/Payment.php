<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Payment extends Model
{
    use Uuids;
    
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
