<?php

namespace App\Traits;

/**
 * Trait Uuids
 *
 * @package Modules\Core\Traits
 */
trait Uuids
{
    /**
     * Boot function from laravel.
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            if (!$obj->id) {
                $obj->id = \Ramsey\Uuid\Uuid::uuid4();
            }
        });
    }
}