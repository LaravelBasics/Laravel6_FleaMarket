<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller//パスワードリセットに関する処理を担当するコントローラー
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
      * Get the password reset validation rules.
      *
      * @return array
      */
      protected function rules()//rules() メソッドをオーバーライドして、パスワードリセット時のバリデーションルールをカスタマイズ
      {
          return [
              'token' => 'required',// 必須
              'email' => 'required|email',//必須、かつ有効なメールアドレス形式
              'password' => 'required|min:8',//必須、最小8文字
          ];
      }
}
