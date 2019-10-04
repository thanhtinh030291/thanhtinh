<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class formClaimRequest extends FormRequest
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
        $rules = [
            '_column.*' => 'required_with_all:content',
            'code_claim'      => 'required|unique:claim',
            'file'          => ' required |max:1999',
        ];
        return $rules;
    }
}
