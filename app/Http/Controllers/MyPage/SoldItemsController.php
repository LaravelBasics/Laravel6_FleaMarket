<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SoldItemsController extends Controller
{//ログインしているユーザーが自分が販売した商品の一覧を確認できる機能を実装
    public function showSoldItems()
    {
        $user = Auth::user();//Auth::user() を呼び出す前に、ユーザーが認証されている必要があります。つまり、ログインしていない場合は null が返されます

        // hasMany もしくは morphMany リレーションを使って、ユーザーが販売した商品を取得するためのクエリを返します
        $items = $user->soldItems()->orderBy('id', 'DESC')->get();//$user ユーザーが販売した商品を取得するための処理
        // orderBy('id', 'DESC') は、取得した商品を id カラムの降順で並び替えています。これにより、最も新しい商品が最初に取得されます
        return view('mypage.sold_items')
            ->with('items', $items);
    }
}
