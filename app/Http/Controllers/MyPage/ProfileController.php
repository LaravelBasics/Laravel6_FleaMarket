<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Mypage\Profile\EditRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function showProfileEditForm()
    {
        return view('mypage.profile_edit_form')
            ->with('user', Auth::user()); //  with('user', Auth::user()) は、ビューファイルに user という名前で認証されたユーザーの情報を渡します。
    } //  Auth:user() は、現在認証されているユーザーの情報を取得する Laravel のファサードです。

    public function editProfile(EditRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name'); //ユーザーがフォームを通じて送信した名前が、データベース内の $user オブジェクトに保存されます。これにより、ユーザーの名前を更新することができます
        // アバターの更新がある場合の処理
        if ($request->has('avatar')) { //リクエストに avatar という名前のファイルが含まれているかどうかをチェック
            $fileName = $this->saveAvatar($request->file('avatar')); //フォームからアップロードされたアバター画像を処理して、その結果得られたファイル名を取得するために使用
            // $request->file('avatar') は、リクエストから avatar というファイルを取得します。
            // file() メソッドはアップロードされたファイルのインスタンスを取得するために使用されます。
            // 取得したファイルを $this->saveAvatar() メソッドに渡します。このメソッドは、アップロードされた画像ファイルをリサイズして保存し、保存されたファイルの名前（またはパス）を返します。
            // saveAvatar() メソッドから返されたファイル名（またはパス）を $fileName 変数に代入します。これにより、後続の処理でこのファイル名を使用できま

            $user->avatar_file_name = $fileName; //$user オブジェクトの avatar_file_name プロパティに、アップロードされたアバター画像のファイル名（またはパス）をセットしています
        }

        $user->save(); //保存

        return redirect()->back()->with('status', 'プロフィールを変更しました。'); //back() メソッドは直前のページのURLを取得
        // with() メソッドを使って、セッションに status キーで「プロフィールを変更しました。」というメッセージを保存します。
        // リダイレクト先のページで、セッションから status キーを取得して、ユーザーにメッセージを表示
    }

    /**
     * アバター画像をリサイズして保存します
     *
     * @param UploadedFile $file アップロードされたアバター画像
     * @return string ファイル名
     */


    private function saveAvatar(UploadedFile $file): string
    {
        // Intervention Image を使用して画像をリサイズ
        $image = Image::make($file)->fit(200, 200);

        // 一時ファイルのパスを生成
        $tempPath = $this->makeTempPath();

        // $image->save($tempPath);90無しでも通る
        // リサイズした画像を一時ファイルに保存
        $image->save($tempPath);  // ($tempPath, 90)　90は品質の指定（適宜調整してください）

        $filePath = Storage::disk('public')->putFile('avatars', new File($tempPath));

        // Storage::disk('public') は、public ディスクを指定してファイルストレージシステムにアクセスします。
        // public ディスクは、config/filesystems.php で定義された設定に基づいて、
        // 通常は storage/app/public ディレクトリにファイルを保存します

        // putFile('avatars', new File($tempPath)) メソッドは、指定したディレクトリ（avatars）に一時的なファイル（$tempPath）を保存します。
        // putFile メソッドは、ファイルを自動的にユニークなファイル名で保存し、そのファイルのパスを返します

        // $filePath 変数には、実際に永続的なストレージに保存されたファイルのパスが格納されます。
        // このパスは、後段の処理で画像の場所を参照するために使用されることがあります

        // ファイル名のみを返す
        // 例えば/path/to/storage/app/public/avatars/filename.jpg のようなパスがあれば、filename.jpg を取得します。
        return basename($filePath);
    }


    /**
     * 一時的なファイルを生成してパスを返します。
     *
     * @return string ファイルパス
     */
    //  private function makeTempPath(): string
    //  {
    //      $tmp_fp = tmpfile();
    //      $meta   = stream_get_meta_data($tmp_fp);
    //      return $meta["uri"];
    //  }

    private function makeTempPath(): string
    {
        $tempDir = sys_get_temp_dir(); //sys_get_temp_dir() 関数を使用してシステムの一時ディレクトリのパスを取得します。
        $tempFileName = tempnam($tempDir, 'avatar') . '.jpg';  // これが原因拡張子を追加

        // tempnam($tempDir, 'avatar') 関数を使用して、
        // 指定された一時ディレクトリ ($tempDir) 内にプレフィックスが 'avatar' の一時ファイル名を生成します
        // 生成された一時ファイル名に .jpg 拡張子を追加します
        // 最終的に生成された一時的なファイルのパスを返します。
        // このメソッドを使用することで、一時的にファイルを保存するための一意なパスを生成し、
        // そのパスを saveAvatar メソッド内で利用しています
        return $tempFileName;
    }
}
