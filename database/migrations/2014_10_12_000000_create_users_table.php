<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar_file_name')->nullable(); //nullable() メソッドは、カラムがNULL値を許容することを示します

            $table->unsignedInteger('sales')->default(0); //データベースのテーブルに sales という名前の符号なし整数型のカラムを追加し、デフォルト値として0を設定することを意味します
            // sales カラムは、例えば商品の売上数などの数値データを保存する場合に使用されます。
            // default(0) メソッドは、カラムのデフォルト値を設定するためのものです。
            // つまり、この場合は sales カラムがデータ挿入時に値が指定されなかった場合に、自動的に0が設定されます


            $table->rememberToken();
// この例では、users テーブルに remember_token カラムが追加され、ユーザーの認証トークンが保存されるようになります。
// Laravelでは、認証機能が組み込まれており、このようなトークンを使ってユーザーのセッションを維持する仕組みが提供されています


            $table->timestamps();
        });
        //         MySQLはデフォルトではカラムにnullを入力できません。
        // アバター画像は会員登録時には設定されない項目のため、nullを許容しています。
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
