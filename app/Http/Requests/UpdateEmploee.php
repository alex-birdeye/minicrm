<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmploee extends FormRequest
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
            'first_name' => 'filled|string|max:255',
            'last_name' => 'filled|string|max:255',
            'company_id' => 'filled|integer|min:1',
            'email' => 'email:rfc,dns',
            'phone' => 'string|max:255',
        ];
    }
}
