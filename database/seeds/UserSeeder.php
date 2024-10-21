<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'めるぴっと太郎',//テストユーザーの名前を設定しています。
            'email' => 'test@test.test',//テストユーザーのメールアドレスを設定しています
            'email_verified_at' => now(),//現在の日時でメール認証済みとしてマークします
            'password' => Hash::make('testtest'),//平文のパスワードを Hash::make() 関数でハッシュ化して安全に保存します。
        ]);
        // Hash::makeセキュリティ: ハッシュ化されたパスワードは、逆に復号化できないため、
        // 万が一データベースが漏洩してもパスワードが安全に保護されます。
        // ベストプラクティス: ハッシュ化は、パスワードを安全に保存するための業界標準のベストプラクティスです。
        // 平文のパスワードを保存することは避けるべきです。
    }
}
