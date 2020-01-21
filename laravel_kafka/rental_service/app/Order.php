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
        'downpayment',
        'delivery_fee',
        'late_fee',
        'total',
        'balance',
        'order_date',
        'return_date',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Model: Business logic
     */

    public function getTotal()
    {
        return $this->itemsTotal() + $this->late_fee + $this->delivery_fee - $this->discount;
    }

    public function itemsTotal()
    {
        $totalItems = 0;
        foreach ($this->items as $item) {
            $totalItems += $item->product->price * $item->qtd;
        }
        return $totalItems;
    }

    public function totalPayments()
    {
        $total = 0;
        foreach ($this->payments as $payment) {
            $total += $payment->amount;
        }
        return $total;
    }

    public function adjustBalance()
    {
        if ($this->balance != $this->getTotal() - $this->totalPayments()) {
            $this->balance = $this->getTotal() - $this->totalPayments();
            $this->save();
        }
    }

    public function adjustTotal()
    {
        if ($this->total != $this->getTotal()) {
            $this->total = $this->getTotal();
            $this->save();
        }
    }
}
