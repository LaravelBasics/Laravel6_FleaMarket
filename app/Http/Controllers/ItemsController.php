<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;//Laravelの認証機能を利用するためのファサード
use App\Models\User;
use Carbon\Carbon;//PHPの日時操作を強化したライブラリで、日付や時間の操作を行うために使用されます
use Illuminate\Support\Facades\DB;//Laravelのデータベースクエリビルダを利用するためのファサード
use Payjp\Charge;//クレジットカードの決済処理を行うためのクラス

class ItemsController extends Controller
{
    public function showItems(Request $request) //topページ
    {
        $query = Item::query();//データベースから特定の条件に合ったレコードを効率的に取得できます

        // カテゴリで絞り込み
        if ($request->filled('category')) { //カテゴリー検索の値が空（nullまたは空文字列）でないかどうかを調べています
// $request->input('category') から取得した文字列を : を区切り文字として分割し、
// その結果を $categoryType と $categoryID に代入
            list($categoryType, $categoryID) = explode(':', $request->input('category'));//レディース：トップスや、メンズ：トップスなど切り分け

            if ($categoryType === 'primary') {//list 関数で分割した結果の $categoryType を確認
                // whereHas メソッドは、指定したリレーションが特定の条件を満たすレコードを持っているかどうかをチェック
                $query->whereHas('secondaryCategory', function ($query) use ($categoryID) {//第一引数は、関連するリレーション名、第二引数は、指定したリレーションに対する追加の条件を設定するためのクロージャ関数です。
                    // このクロージャ内では、$query パラメータを使用してリレーションのクエリビルダを操作し、条件を追加します。
                    // use ($categoryID) により、外部の変数 $categoryID をクロージャ内で使用することができます
                    $query->where('primary_category_id', $categoryID);//secondaryCategory リレーションの中で primary_category_id カラムが $categoryID と一致するレコードを絞り込んでいます。
                });
            } else if ($categoryType === 'secondary') {//$categoryType の値が 'secondary' の場合に実行される処理を示しています。
                // elseif を使用することで、条件分岐を連続していることが明確になり、コードの可読性が向上します。
                $query->where('secondary_category_id', $categoryID);
                // セカンダリーカテゴリーでの商品絞り込みを行い、
                // secondary_category_id カラムが指定された $categoryID と一致する商品をデータベースから取得するための条件を設定
            }
        }
        Log::info("showItems メソッドが呼び出されました");

        // キーワードで絞り込み
        if ($request->filled('keyword')) {//リクエストの中に keyword という名前のパラメータが存在し、かつ空でない場合
            // $keyword 変数には、キーワードの前後に % を付けた文字列が代入されます。これにより、部分一致検索（LIKE検索）が行われます。
            $keyword = '%' . $this->escape($request->input('keyword')) . '%';
// $this->escape($request->input('keyword')) は、キーワードをエスケープするためのメソッドです。
// これにより、検索に悪影響を与える可能性のある文字を無害化

            $query->where(function ($query) use ($keyword) {//where メソッドのクロージャ内で、$query を使用してキーワード検索の条件を設定
                $query->where('name', 'LIKE', $keyword);//name カラムが $keyword に部分一致するレコードを取得する条件
                $query->orWhere('description', 'LIKE', $keyword);//description カラムが $keyword に部分一致するレコードを取得する条件
            });
        }

        // orderByRawメソッドを使用するとORDER BY句のSQLを直接記述することができます
        // orderByRaw... により、state カラムの値を特定の順序で並び替え
        $items = $query->orderByRaw("FIELD(state, '" . Item::STATE_SELLING . "', '" . Item::STATE_BOUGHT . "')")
            
            //orderBy('id', 'DESC') により、id カラムを降順（新しい順）に並び替えています。最も新しい商品が先頭に来るようにしています。
            ->orderBy('id', 'DESC')
            ->paginate(9);//paginate(9) により、ページネーションを実行しています。1ページあたり9件の商品データを取得する設定

        Log::info("アイテムの取得が完了しました");
        return view('items.items')->with('items', $items);
        // items' というキーで $items という変数をビューに渡しています。こうすることで、
        // ビュー側で $items を利用して、コントローラで取得した商品データなどを表示することができます
    }

    // 検索処理: ユーザーが検索フォームで入力したキーワードをエスケープして、安全にデータベースクエリに組み込むために使われます。
    // 例えば、$query->where('name', 'LIKE', $this->escape($request->input('keyword'))); のように、
    // キーワードをエスケープした上で部分一致検索を行います。
    private function escape(string $value)
    {//SQLインジェクション対策
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $value
        );
    }

    //このメソッドは、ユーザーが商品の購入フォームを表示し、購入可能な商品であることを確認するために使用されます
    public function showBuyItemForm(Item $item)
    {//商品の状態確認: $item->isStateSelling を使用して、商品が販売中であるかどうかをチェック
        if (!$item->isStateSelling) {
            abort(404);//販売中でない商品の場合はページが見つからないというエラーを返します。
        }
    //ビューの表示: 商品が販売中であれば、items.item_buy_form ビューを表示します。
        return view('items.item_buy_form')
            ->with('item', $item);
    }

    public function showItemDetail(Item $item)// ユーザーが特定の商品の詳細を閲覧するためのページを表示する際に使用されます。
    {
        return view('items.item_detail')
            ->with('item', $item);
    }

    public function buyItem(Request $request, Item $item)
    {
        // 認証されたユーザーの取得: Auth::user() を使用して、現在ログインしているユーザーのインスタンスを取得します。
        // ユーザーがログインしているかの確認: もしユーザーがログインしていない場合
        // （つまり Auth::user() が null を返す場合）、この操作を実行することはできません。
        $user = Auth::user();

        if (!$item->isStateSelling) {//商品の状態確認: $item->isStateSelling を使用して、商品が販売中であるかどうかをチェック
            abort(404);//販売中でない商品の場合はページが見つからないというエラーを返します。
        }
// クレジットカードのトークン取得: 一般的に、クレジットカード決済を行う際には、フォームに入力されたクレジットカード情報（トークン化されたもの）が
// このようなパラメータを通じてサーバーに送信されます。そのため、このコードはそのトークンを取得しています。
// この $token を通じて、後続の処理でクレジットカードの決済を行う準備を整えたり、
// そのトークンを使って外部の決済プロバイダに送信することが一般的
        $token = $request->input('card-token');

        try {//商品の購入処理を試みている部分
            $this->settlement($item->id, $item->seller->id, $user->id, $token);
            // 決済処理の呼び出し: $this->settlement($item->id, $item->seller->id, $user->id, $token); で、
            // 商品の決済処理を実行しています。このメソッドは、購入者（$user）、商品（$item）、および決済トークン（$token）を引数として受け取ります。
        } catch (\Exception $e) {//例外が発生した場合は、そのエラーメッセージをログに記録し、ユーザーに対して購入処理が失敗した旨を伝えるメッセージを表示します
            Log::error($e);
            return redirect()->back()
                ->with('type', 'danger')//Laravelにおけるリダイレクト先でセッションに情報をフラッシュするための方法
                // 'type' キーには通常、メッセージのスタイルや種類を示す文字列が設定されます。例えば、
                // 'success'（成功メッセージ）、'info'（情報メッセージ）、'warning'（警告メッセージ）、'danger'（エラーメッセージ）などが一般的に使用されます
                ->with('message', '購入処理が失敗しました。');
        }

        return redirect()->route('item', [$item->id])//item という名前のルート（通常は商品の詳細ページへのルート）にリダイレクトします。
        // $item->id はルートのパラメータとして渡され、指定された商品の詳細ページにリダイレクト
            ->with('message', '商品を購入しました。');
    }

    private function settlement($itemID, $sellerID, $buyerID, $token)//商品の購入処理を行うためのプライベートメソッド
    {
        DB::beginTransaction();//データベーストランザクションを開始

        try {
            // 売り手のデータを取得します。lockForUpdate() メソッドを使って、取得したレコードに対して排他ロックをかけます。
            // これにより、他のトランザクションがこのレコードを変更することを防ぎます。
            // find($sellerID) メソッドを使って、売り手のID（$sellerID）に対応するレコードを取得
            $seller = User::lockForUpdate()->find($sellerID);//
            $item   = Item::lockForUpdate()->find($itemID);//商品のデータを取得,後は上と同様の処理、find($itemID) メソッドで、商品のID（$itemID）に対応するレコードを取得します

            if ($item->isStateBought) {//$item の isStateBought プロパティが true の場合、つまり商品がすでに購入済みの状態である場合に、以下の処理を実行
                throw new \Exception('多重決済');
                // この処理の目的は、同じ商品に対して複数回の決済が行われるのを防ぐことです。商品が既に購入されている状態であれば、
                // 新たな購入処理を中止し、例外をスローしてエラーハンドリングを行うことができます
            }

            $item->state     = Item::STATE_BOUGHT;//$item の state プロパティに Item::STATE_BOUGHT をセット。これは、商品の状態を「購入済み」に更新
            $item->bought_at = Carbon::now();//$item の bought_at プロパティに現在の日時をセットしています。これにより、商品が購入された日時が記録
            $item->buyer_id  = $buyerID;//$item の buyer_id プロパティに購入者のユーザーID ($buyerID) をセットしています。これにより、どのユーザーが商品を購入したかが記録
            $item->save();//$item->save(); は、変更をデータベースに保存するためのメソッド

            $seller->sales += $item->price;//これは売り手の売上に購入された商品の価格を加算します
            //$seller->sales は売り手の現在の売上額を表しています
            // $item->price は購入された商品の価格です。
            $seller->save();

            $charge = Charge::create([//外部ライブラリやAPIを介して決済を行う処理を示しています
                'card'     => $token,//クレジットカードや支払い手段のトークンを表しています
                'amount'   => $item->price,//購入される商品の価格
                'currency' => 'jpy'//日本円を表す通貨コード
            ]);
            // if (!$charge->captured) は、もし決済が正常にキャプチャされていない場合に条件が成立
            if (!$charge->captured) {//$charge->captured は、決済が正常にキャプチャされたかどうかを示すプロパティ
                throw new \Exception('支払い確定失敗');//例外を発生させて支払い確定に失敗したことを示します
            }
        } catch (\Exception $e) {
            DB::rollBack();//例外が発生した場合は、DB::rollBack(); を呼び出してトランザクションをロールバックし、変更を取り消し
            throw $e;
        }

        DB::commit();//すべての処理が成功した場合は、DB::commit(); でトランザクションをコミットし、データベースへの変更を確定
    }
}
