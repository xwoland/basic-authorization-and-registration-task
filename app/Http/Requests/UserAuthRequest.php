<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'access_token' => ['required'],
            'id'           => ['required'],
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'country'      => ['required'],
            'city'         => ['required'],
            'sig'          => ['required']
        ];
    }
}
