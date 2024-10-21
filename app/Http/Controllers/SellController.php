<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCondition;
use App\Models\PrimaryCategory;
use App\Http\Requests\SellRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class SellController extends Controller
{
    public function showSellForm()
    { //商品出品画面を表示する処理
        // $categories = PrimaryCategory::orderBy('sort_no')->get();N+1問題 ↓が解決策
        $categories = PrimaryCategory::query()
            ->with([
                'secondaryCategories' => function ($query) {
                    $query->orderBy('sort_no');
                }
            ])
            ->orderBy('sort_no')
            ->get();

        $conditions = ItemCondition::orderBy('sort_no')->get();
        return view('sell')
            ->with('categories', $categories)
            ->with('conditions', $conditions);
    }

    public function sellItem(SellRequest $request)
    {
        $user = Auth::user();
// 商品の情報と共にアップロードされた画像のファイル名（またはパス）をデータベースに保存し、その後の処理で商品の出品を完了
        $imageName = $this->saveImage($request->file('item-image'));

        $item                        = new Item();
        $item->image_file_name       = $imageName;//image_file_name:商品の画像ファイル名（またはパス
        $item->seller_id             = $user->id;//seller_id: 出品者のユーザーID ($user->id から取得)
        $item->name                  = $request->input('name');//name: 商品名（フォームからの入力
        $item->description           = $request->input('description');//description: 商品の説明（フォームからの入力）
        $item->secondary_category_id = $request->input('category');//secondary_category_id: 商品のセカンダリカテゴリID（フォームからの入力）
        $item->item_condition_id     = $request->input('condition');//item_condition_id: 商品のコンディションID（フォームからの入力）
        $item->price                 = $request->input('price');//price: 商品の価格（フォームからの入力）
        $item->state                 = Item::STATE_SELLING;//state: 商品の状態を表す定数 Item::STATE_SELLING（出品中を示す定数）
        $item->save();

        return redirect()->back()//ユーザーが直前にいたページにリダイレクト
            ->with('status', '商品を出品しました。');
            //リダイレクト先のビューで使用できるように、セッションに 'status' キーで '商品を出品しました。' というメッセージを保存します
    }

    /**
     * 商品画像をリサイズして保存します
     *
     * @param UploadedFile $file アップロードされた商品画像
     * @return string ファイル名
     */
    private function saveImage(UploadedFile $file): string
    {
        $tempPath = $this->makeTempPath();
        Log::info('Uploaded file:', ['file' => $request->file('item-image')]);

        Image::make($file)->fit(300, 300)->save($tempPath);

        $filePath = Storage::disk('public')
            ->putFile('item-images', new File($tempPath));

        return basename($filePath);
    }//このメソッドは、商品画像の処理と保存を一貫して行い、最終的にデータベースに保存する際のファイル名を取得するために使用されます

    /**
     * 一時的なファイルを生成してパスを返します。
     *
     * @return string ファイルパス
     */
    private function makeTempPath(): string
    {
        //   $tmp_fp = tmpfile();
        //   $meta   = stream_get_meta_data($tmp_fp) . '.jpg';  // 拡張子を追加
        //   return $meta["uri"];
        $tmp_fp = tmpfile();//一時ファイルのリソースを取得
        $meta   = stream_get_meta_data($tmp_fp);//一時ファイルのメタデータを取得
        $tempFilePath = $meta['uri'] . '.jpg';  // 取得した一時ファイルのURIに、拡張子 .jpg を追加して、一時ファイルのパスを生成
        fclose($tmp_fp);  // 一時ファイルのリソースを閉じます

        return $tempFilePath;
        // 最終的に、拡張子を追加した一時ファイルのパスを返します。このメソッドは、画像のリサイズや一時的な保存のために一意のファイルパスを生成する際に使用されます
    }
}
