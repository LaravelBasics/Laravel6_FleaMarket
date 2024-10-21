<?php
// 名前空間は通常 App から始まります
namespace App\Http\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
// use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\Request;

// class Header extends Component
class HeaderComposer
{
    // public function __construct()
    // {

    // }
    public function compose(View $view)
    {
        // $view->with('user', Auth::user());
        $user = Auth::user();//現在ログインしているユーザーの情報を取得するためのコード

        // PrimaryCategory モデルのクエリビルダを開始する方法です。このクエリビルダを使用することで、
        // データベースから PrimaryCategory のレコードを取得する準備が整います
        $categories = PrimaryCategory::query()
            ->with([//secondaryCategories はテーブル名ではなく、Eloquent モデルのメソッドやリレーションの名前を指しています
                'secondaryCategories' => function ($query) {
                    $query->orderBy('sort_no');// 関連する secondaryCategories を sort_no の昇順で取得
                }
            ])
            ->orderBy('sort_no')// PrimaryCategory を sort_no の昇順で取得
            ->get();//実際のデータベースからの取得は、get() メソッドが呼ばれた時点で行われます
            $defaults = [
                'category' => Request::input('category', ''),
                //リクエストから 'category' というパラメータを取得し、その値を$defaults['category'] に設定します。
                // もし 'category' パラメータが存在しない場合、デフォルト値として空文字列 '' を設定します
                'keyword'  => Request::input('keyword', ''),
            ];
// このようにすることで、リクエストに 'category' や 'keyword' が含まれていない場合でも、変数 $defaults にはそれぞれ空文字列が設定されています

        $view->with('user', $user)//user' => $user: 現在認証されているユーザーの情報をビューに渡します
            ->with('categories', $categories)//PrimaryCategory モデルのクエリ結果をビューに渡します。$categories は、各主カテゴリに関連するセカンダリカテゴリのリストを含む配列です
            ->with('defaults', $defaults);//リクエストから取得した 'category' と 'keyword' のデフォルト値をビューに渡します。これにより、検索フォームなどで使用するデフォルトのカテゴリとキーワードが設定されます
    }
// ビューでこれらの変数を利用することで、ユーザー情報、カテゴリリスト、検索フォームのデフォルト値などを表示や処理に使用することができます

}
    // public function render()
    // {
        // $user = Auth::user();
        // Log::info("app/View/Components/Header.php");
        // return view('components.header')
        //      ->with('user', $user);
    // }
