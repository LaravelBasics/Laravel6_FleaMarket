<?php

namespace App\Http\Requests\Mypage\Profile;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()//リクエストを処理するユーザーが認可されているかどうかを判定するためのメソッド
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {//avatar: ファイルであることを示す file ルールと、画像ファイルであることを示す image ルールが適用されています
        return [
            'avatar' => ['file', 'image'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }//name: 必須項目であり、文字列であり、最大255文字までの文字列であることを示すバリデーションルールが適用されています
}
