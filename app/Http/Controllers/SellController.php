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
    
    // フォームで選択された画像名を取得（アップロードがない場合）
    $imageName = $request->input('selected-image', 'test0.jpg'); // デフォルトは'test0.jpg'

    // アップロードされた画像が存在し、有効であれば処理
    if ($request->hasFile('item-image') && $request->file('item-image')->isValid()) {
        $imageName = $this->saveImage($request->file('item-image'));
    }

    // 画像データを取得
    $imageFile = $request->file('item-image') ?? new \Illuminate\Http\File(public_path('images/' . $imageName));
    $imageData = $this->getImageBinaryData($imageFile);

    // 商品情報の保存
    $item = new Item();
    $item->image_file_name = $imageName;
    $item->image_data = $imageData;
    $item->seller_id = $user->id;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->secondary_category_id = $request->input('category');
    $item->item_condition_id = $request->input('condition');
    $item->price = $request->input('price');
    $item->state = Item::STATE_SELLING;
    $item->save();

    return redirect()->back()
        ->with('status', '商品を出品しました。');
}

    

    /**
     * 商品画像をリサイズして保存します
     *
     * @param UploadedFile $file アップロードされた商品画像
     * @return string ファイル名
     */
    private function saveImage(UploadedFile $file): string
    {
        // 画像のバリデーション
        if (!$file->isValid()) {
            throw new \Exception('画像ファイルが無効です');
        }

        $tempPath = $this->makeTempPath();

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
        // $tempFilePath = $meta['uri'];  // linuxは拡張子不要？

        fclose($tmp_fp);  // 一時ファイルのリソースを閉じます

        return $tempFilePath;
        // 最終的に、拡張子を追加した一時ファイルのパスを返します。このメソッドは、画像のリサイズや一時的な保存のために一意のファイルパスを生成する際に使用されます
    }

    /**
     * 画像データをバイナリ形式に変換して返します
     *
     * @param UploadedFile $file アップロードされた商品画像
     * @return string バイナリデータ
     */
    private function getImageBinaryData($file): string
{
    // $fileがnullでない場合
    if ($file instanceof UploadedFile && $file->isValid()) {
        return base64_encode(file_get_contents($file->getRealPath()));
    } else {
        // 画像が選ばれていない場合は、public/images/test0.jpgを使用
        return base64_encode(file_get_contents(public_path('images/test0.jpg')));
    }
}


}
