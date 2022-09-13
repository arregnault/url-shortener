<?php

namespace App\Http\Requests\Links;

use App\Http\Requests\FormRequest;
use App\Shared\Consts\Entities\LinkConsts;

class StoreLinkRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            LinkConsts::URL => [
                "required",
                "string",
                "url",
            ],
        ];

    }//end rules()


}//end class
