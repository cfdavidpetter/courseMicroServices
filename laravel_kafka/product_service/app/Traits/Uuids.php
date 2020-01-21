<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

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
    public static function bootUuids ()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findU ($uuid)
    {
        return static::where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findUOrFail($uuid)
    {
        $post = static::where('uuid', '=', $uuid)->first();

        if( is_null($post) ) {
            return abort(404);
        } else {
            return $post;
        }
    }

}