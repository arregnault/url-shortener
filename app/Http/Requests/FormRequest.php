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
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                    "status" => "error",
                    "code"   => 422,
                    "errors" => $errors,
                ],
                422
            )
        );

    }//end failedValidation()


}//end class
