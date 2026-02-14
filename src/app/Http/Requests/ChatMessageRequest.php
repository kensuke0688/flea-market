<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatMessageRequest extends FormRequest
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

    public function rules()
    {
        return [
            'message_text' => 'required|string|max:400',
            'image' => 'nullable|mimes:png,jpeg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'message_text.required' => '本文を入力してください',
            'message_text.max' => '本文は400文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
