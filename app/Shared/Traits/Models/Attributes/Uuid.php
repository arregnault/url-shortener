<?php

namespace App\Shared\Traits\Models\Attributes;

use App\Shared\Helpers\UuidHelper;

trait Uuid
{


    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Sets the primary key to an UUID on creating
        static::creating(
            function ($model) {
                if ($model->getKey() === null) {
                    $model->setAttribute($model->getKeyName(), UuidHelper::generateUuidV4());
                }
            }
        );

    }//end boot()


    /**
     *  Get the value indicating whether the primary key is incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;

    }//end getIncrementing()


    /**
     * Get primary key data type
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';

    }//end getKeyType()


}
