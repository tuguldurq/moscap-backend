<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreArtistRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.email' => 'required|email|unique:users,email',
            'user.register_number'=> 'required',
            'user.phone' => 'required',
            'user.citizen' => 'required',
            'user.sex' => 'required',
            'user.role' => 'required',
            'user.password' => 'required',
            'user.bank.name' => 'required',
            'user.bank.account' => 'required',
        ];
    }

    public function messages(){
        return [
            'user.first_name.required' => 'required aaa',
            'user.last_name.required' => 'required',
            'user.email.required' => 'required',
            'user.email.unique' => 'unique bn',
            'user.register_number.required'=> 'required',
            'user.phone.required' => 'required',
            'user.password.required' => 'required',
            'user.citizen.required' => 'required',
            'user.sex.required' => 'required',
            'user.role.required' => 'required',
            'user.bank.name.required' => 'required',
            'user.bank.account.required' => 'required',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @param  Illuminate\Contracts\Validation\Validator $validator
     * @return HttpResponseException
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = [
            'status' => 'error',
            'message' => 'Validation error',
            'result' => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }

}
