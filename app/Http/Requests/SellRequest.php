<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            // 'item-image'  => ['required', 'file', 'image'],//必須であり、ファイルであること、画像ファイルであることを指定しています
            'name'        => ['required', 'string', 'max:255'],//必須であり、文字列であり、最大255文字までの制限があります
            'description' => ['required', 'string', 'max:2000'],//必須であり、文字列であり、最大2000文字までの制限があります
            'category'    => ['required', 'integer'],//必須であり、整数であることを指定しています
            'condition'   => ['required', 'integer'],//必須であり、整数であることを指定しています
            'price'       => ['required', 'integer', 'min:100', 'max:9999999'],//必須であり、整数であり、最小値が100、最大値が9999999であることを指定しています
            // 'item-image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // ここで画像のバリデーションをまとめます
            'item-image' => ['nullable', 'string', 'in:test0.jpg,test1.jpg,test2.jpg,test3.jpg'],
        ];
    }

    // public function getImageBinaryData($file)
    // {
    //     // アップロードされた画像をバイナリ形式で取得
    //     return file_get_contents($file->getRealPath());
    // }

    public function attributes()//各項目の属性名（ラベル名）をカスタマイズしています
    {//バリデーションエラーが発生した際に、そのエラーの内容をユーザーにわかりやすく表示するために使われます
        return [
            'item-image'  => '商品画像',
            'name'        => '商品名',
            'description' => '商品の説明',
            'category'    => 'カテゴリ',
            'condition'   => '商品の状態',
            'price'       => '販売価格',
        ];
    }
}
