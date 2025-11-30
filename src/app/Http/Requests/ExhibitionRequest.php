<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name'     => 'required|string',
            'description'   => 'required|string|max:255',
            'item_img'      => 'required|image|mimes:jpg,png',
            'category' => 'required', 'array',
            'category.*' => 'integer', 'exists:categories,id',
            'condition'     => 'required',
            'price'         => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => '商品名を入力してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'item_img.required' => '商品画像をアップロードしてください。',
            'item_img.mimes' => '商品画像は.jpg または .png の形式でアップロードしてください。',
            'category.required' => 'カテゴリーを選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'price.required' => '価格を入力してください。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
        ];
    }
}
