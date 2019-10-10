<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\validSelectField;
use App\Http\Traits\SanitizesInput;

class formClaimRequest extends FormRequest
{
    use SanitizesInput;
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
            '_column.*' => 'distinct|nullable',
            '_column' => [ new validSelectField()],
            'code_claim'      => 'required|unique:claim',
            'file'          => ' required |max:5999',
        ];
        return $rules;
    }
}
