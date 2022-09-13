<?php

namespace App\Shared\Helpers;

use Illuminate\Support\Str;

class LinkHelper
{


    public static function generateCode(): string
    {
        return Str::random(6);

    }//end generateCode()


    public static function redirectTo(?object $link)
    {
        return redirect(($link->url ?? "/"));

    }//end redirectTo()


}//end class
