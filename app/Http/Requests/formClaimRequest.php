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
           // 'id_claim'      => 'required|unique:medical_expense_report',
            'file'          => ' required |max:1999',
        ];
        return $rules;
    }
}
