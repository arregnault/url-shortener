<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class FormRequest extends HttpFormRequest
{
    /*
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

    }//end authorize()


    /**
     * Throw failed validation message
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator Validator
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $validator = (new ValidationException($validator))->validator;

        throw new HttpResponseException(
            response()->json(
                [
                    "status"  => "error",
                    "code"    => 422,
                    "error"   => $validator->errors(),
                    "message" => $validator->errors()->all(),
                ],
                422
            )
        );

    }//end failedValidation()


}//end class
