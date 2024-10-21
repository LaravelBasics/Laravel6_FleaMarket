<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/ini', function() {
//     phpinfo();
// });
//laravel　6
Route::get('/', 'ItemsController@showItems')->name('top');

Auth::routes(); //ヘルパーメソッド,認証機能に必要なすべてのルートを自動的に定義,App\Http\Controllers\Auth ディレクトリに配置
// コマンドにより生成、認証関連のルートを一括で定義する

// Route::get('/home', 'HomeController@index')->name('home'); //コマンドにより生成、ユーザーがログイン後にリダイレクトされるホーム画面を定義する

Route::get('items/{item}', 'ItemsController@showItemDetail')->name('item');

Route::middleware('auth')//authミドルウェアで、グループ内のすべてのルートは、ユーザーが認証されている場合にのみアクセスできる
    ->group(function () {//auth ミドルウェアは、ユーザーが認証されていない場合、ログインページにリダイレクトします。
        // これにより、認証されていないユーザーがこれらのルートにアクセスすることを防ぎます。
        Route::get('items/{item}/buy', 'ItemsController@showBuyItemForm')->name('item.buy');
        Route::post('items/{item}/buy', 'ItemsController@buyItem')->name('item.buy');

        Route::get('sell', 'SellController@showSellForm')->name('sell');
        Route::post('sell', 'SellController@sellItem')->name('sell');
    }); 

Route::prefix('mypage') //すべてのルートに「mypage」というプレフィックスが追加されます。
// これにより、ルートは /mypage/edit-profile のようになります。
    ->namespace('MyPage')//すべてのコントローラは App\Http\Controllers\MyPage 名前空間内にあると仮定されます
    ->middleware('auth')//すべてのルートに auth ミドルウェアが適用され、認証されたユーザーのみがこれらのルートにアクセスできるようになります
    ->group(function () {
        Route::get('edit-profile', 'ProfileController@showProfileEditForm')->name('mypage.edit-profile');
        Route::post('edit-profile', 'ProfileController@editProfile')->name('mypage.edit-profile');
        Route::get('bought-items', 'BoughtItemsController@showBoughtItems')->name('mypage.bought-items');
        Route::get('sold-items', 'SoldItemsController@showSoldItems')->name('mypage.sold-items'); //場所移動して、名前空間を変更する
    });

// Route Prefix: mypage プレフィックスを持つURLが定義されます。例えば、/mypage/edit-profile のようなURLが生成されます。
// Namespace: MyPage 名前空間に属するコントローラーが使用されます。これにより、ProfileController は 
// App\Http\Controllers\MyPage 名前空間内の ProfileController として解決されます。
// Middleware: auth ミドルウェアが適用されています。これにより、ユーザーが認証されていない場合は
// ログインページにリダイレクトされます。認証済みのユーザーのみがアクセスできるページを定義するのに便利です。
// ルートグループ内のルート: edit-profile ルートは、ProfileController の showProfileEditForm アクションを処理し、
// mypage.edit-profile という名前で名前付きルートが付けられています。
