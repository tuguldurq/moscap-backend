<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreArtistManagerRequest extends FormRequest
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
            'name' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Нэрээ оруулна уу!',
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
