<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'customer_id',
        'status',
        'discount',
        'total',
        'order_date',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($order) { // before delete() method call this
             $order->items()->delete();
        });
    }

    /**
     * Eloquent: Relationships
     */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
