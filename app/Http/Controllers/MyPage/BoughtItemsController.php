<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoughtItemsController extends Controller
{
    public function showBoughtItems()
    {
        $user = Auth::user();//Auth::user() は、現在ログインしているユーザーの情報を取得

        // boughtItems() はそのユーザーが購入した商品の関連を返すEloquentリレーションのことです。これにより、購入した商品のクエリを簡単に取得
        $items = $user->boughtItems()->orderBy('id', 'DESC')->get();
// orderBy() メソッドは、取得した商品のコレクションを id カラムで降順に並び替えています。つまり、最も新しい購入商品が一番上に来るようにしています
        return view('mypage.bought_items')
            ->with('items', $items);
    }
}
