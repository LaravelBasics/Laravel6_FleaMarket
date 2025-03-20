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

class ProfileController extends Controller
{
    public function showProfileEditForm()
    {
        return view('mypage.profile_edit_form')
            ->with('user', Auth::user());
    }

    public function editProfile(EditRequest $request)
    {
        $user = Auth::user();

        // ニックネームの更新
        $user->name = $request->input('name');

        // アバターの処理
        if ($request->hasFile('avatar')) {
            // アバター画像がアップロードされている場合
            $fileName = $this->saveAvatar($request->file('avatar'));
            $user->avatar_file_name = $fileName;
        } else {
            // アバター番号が送信された場合（画像選択）
            $avatarNumber = $request->input('selected-avatar', 0); // デフォルト値は0
            $user->avatar_file_name = "test{$avatarNumber}.jpg"; // test0.jpg などの名前に設定
        }

        $user->save(); // ユーザー情報を保存

        return redirect()->back()->with('status', 'プロフィールを変更しました。');
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

        // publicディスクに画像を保存
        // 'avatars' フォルダ内に保存
        $filePath = $image->store('avatars', 'public'); 

        // ファイル名を返す（例えば、'avatars/filename.jpg' のようなパスからファイル名を取得）
        return basename($filePath);
    }
}
