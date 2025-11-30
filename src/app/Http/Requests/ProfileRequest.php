<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:20',
            'profile_img' => 'nullable|image|mimes:jpeg,png',
            'post_number' => 'required|string|size:8',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',
            'profile_img.image' => 'プロフィール画像は画像ファイルを指定してください。',
            'profile_img.mimes' => 'プロフィール画像はjpegかpng形式でアップロードしてください。',
            'post_number.required' => '郵便番号を入力してください。',
            'post_number.size' => '郵便番号はハイフンを含めて8文字で入力してください。',
            'address.required' => '住所を入力してください。',
        ];
    }
}
