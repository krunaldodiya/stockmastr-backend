<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessOrder extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'amount' => 'required',
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID is required.',
            'amount.required' => 'Amount is required.',
            'mobile.required' => 'Mobile is required.',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}
