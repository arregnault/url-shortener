<?php

namespace App\Shared\Helpers;

use Illuminate\Support\Str;

class UuidHelper
{


    public static function generateUuidV4(): string
    {
        return Str::uuid()->toString();

    }//end generateUuidV4()


}//end class
