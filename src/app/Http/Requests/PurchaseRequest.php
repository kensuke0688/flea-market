<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = auth()->user();

        return [
            'payment_method' => 'required|string',
            'address' => $user->address ? 'nullable' : 'required|string',
            'post_number' => $user->post_number ? 'nullable' : 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'address.required' => '配送先住所を登録してください。',
            'post_number.required' => '郵便番号を登録してください。',
        ];
    }
}
