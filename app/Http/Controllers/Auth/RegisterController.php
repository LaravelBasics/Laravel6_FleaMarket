<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;//アプリケーションのルートの定義や、ルートに基づく各種設定を管理するクラスです。通常、このクラスではルートのグループ化、ミドルウェアの適用、エイリアスの定義などが行われます
/*use App\User;*/
use App\Models\User; //を参照するように修正←これはエラーになった。再び修正で可能
// ↑この説明
// 名前空間の整理と明確化: App\Models\Userという名前空間を使うことで、UserモデルがModelsディレクトリ内にあることが明確になります。
// これにより、コードの読みやすさが向上します。名前空間を使うことで、クラスがどこに属しているかが直感的に分かります。
// 名前の衝突を避ける: LaravelのデフォルトのUserモデルと他のモデル名が同じ場合、名前空間を使うことで衝突を避けることができます。
// たとえば、App\UserとApp\Models\Userのように名前空間を使うことで、どちらのUserクラスを参照しているのかが明確になります。
// ディレクトリ構造の整理: Modelsというサブディレクトリを使うことで、
// appディレクトリ内のファイル数が増えても見通しを良くすることができます。特に大規模なプロジェクトでは、
// ディレクトリ構造の整理が重要です

use Illuminate\Foundation\Auth\RegistersUsers;//ゆーザー登録に関連する機能を提供するトレイトです。具体的には、ユーザー登録時のバリデーションや登録処理を効率的に実装するためのメソッドが含まれています
use Illuminate\Support\Facades\Hash;//パスワードのハッシュ化やハッシュの比較を行うためのファサードです。Hash::make() メソッドを使用してパスワードを安全にハッシュ化することができます
use Illuminate\Support\Facades\Validator;//バリデーションのルールを定義し、データのバリデーションを行うためのファサードです。Validator::make() メソッドを使用して、データに対するバリデーションインスタンスを作成し、ルールを定義できます

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) //ユーザー登録時のデータバリデーションを行うためのメソッド
    { //メソッドの目的: ユーザーが提供したデータが、指定されたルールに合致しているかを検証するために使用されます。
        return Validator::make($data, [ //引数: $data はバリデーション対象のデータを配列として受け取ります。通常は、ユーザーがフォームから送信したデータが渡されます
            'name' => ['required', 'string', 'max:255'], //name フィールドは必須であり、文字列であり、最大255文字まで許容されます。
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], //email フィールドは必須であり、文字列であり、有効なメールアドレスであり、最大255文字まで許容され、users テーブルの中でユニークである必要があります
            'password' => ['required', 'string', 'min:8'], //password フィールドは必須であり、文字列であり、少なくとも8文字以上である必要があります
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) //ユーザー登録時に新しいユーザーをデータベースに登録するためのメソッド
    { //メソッドの目的: ユーザーが提供したデータを使用して、新しい User モデルのインスタンスを作成し、データベースに保存します
        // 引数: $data は、ユーザーがフォームから送信したデータを含む連想配列です。通常は、'name'、'email'、'password' などのキーを持ちます
        return User::create([//Eloquent モデルの create メソッドを使用して新しいユーザーレコードをデータベースに挿入します。このメソッドは、登録に成功した場合には新しいユーザーモデルのインスタンスを返します
            'name' => $data['name'],//提供された名前をデータベースの name カラムに設定します。
            'email' => $data['email'],//提供されたメールアドレスをデータベースの email カラムに設定します
            'password' => Hash::make($data['password']),
            // 提供されたパスワードを、Laravel の Hash::make メソッドを使ってハッシュ化し、データベースの password カラムに保存します。これにより、パスワードが安全に保護されます
        ]);
    }
}
