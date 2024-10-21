<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('primary_categories', function (Blueprint $table) {
            // $table->id();これは７以降のバージョン
            $table->bigIncrements('id');
            // ここにカラムを追加していく

            $table->string('name'); //name という名前の文字列（VARCHAR）カラムを追加します。デフォルトでは255文字の長さに制限されています
            $table->integer('sort_no'); //sort_no という名前の整数（INT）カラムを追加
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->bigIncrements('id'); //自動で主キーとなる
            // 符号なしの大きな整数型です。この型は、負の値を許容せず、通常の整数型よりも大きな値を扱うことができます。
            // 外部キーとして他のテーブルの主キーを参照する場合によく使われます。
            $table->unsignedBigInteger('primary_category_id'); //このコードで対応する大カテゴリのIDを格納するカラムを定義しています

            // ここにカラムを追加していく

            $table->string('name');
            $table->integer('sort_no');

            $table->timestamps();

            // foreign() メソッドは、外部キー制約を設定するためのメソッドです。
            // 引数には外部キーとして設定するカラム名を指定します。この場合は primary_category_id カラム
            // references() メソッドは、外部キーが参照するテーブルのカラムを指定します。
            // ここでは primary_categories テーブルの id カラムを参照
            $table->foreign('primary_category_id')->references('id')->on('primary_categories'); //このコードでprimary_category_idカラムに外部キー制約を付与
            // on() メソッドは、外部キーが参照するテーブルを指定します。
            // この場合、primary_category_id カラムは primary_categories テーブルの id カラムを参照
        });

        Schema::create('item_conditions', function (Blueprint $table) {
            $table->bigIncrements('id'); //主キー

            // ここにカラムを追加していく
            $table->string('name');
            $table->integer('sort_no');

            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');

            // 外部キー制約により、関連する seller が削除された場合に、
            // その seller に関連する item も自動的に削除されるように設定されています
            $table->unsignedBigInteger('seller_id'); //外部キーとして他のテーブルとの関連付けに使用

            // $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('buyer_id')->nullable(); //このカラムには値が設定されなくてもよく、NULL 値が許可されます

            $table->unsignedBigInteger('secondary_category_id'); //このカラムには NULL 値が許可されず、必ず値が設定されなければなりません
            $table->unsignedBigInteger('item_condition_id');

            // ここにカラムを追加していく

            $table->string('name');
            $table->string('image_file_name');
            $table->text('description'); // 長いテキストを格納するためのカラム（TEXT
            $table->unsignedInteger('price'); //符号なしの整数（unsigned INT）として価格を格納します。符号なし整数にすることで、負の値を防ぎ、0以上の値のみを許可します
            $table->string('state');
            $table->timestamp('bought_at')->nullable(); //購入日時を格納するために使用され、NULLを許可することで、購入日時がまだ設定されていない場合や後で設定される場合に対応できます
            // bought_at という特定のカラムを作成し、主に購入日時を格納します。
            // NULLの許可: nullable() メソッドを使用して、このカラムが NULL 値を持つことを許可します。
            // これにより、購入日時がまだ決まっていない場合や後で設定される場合でも対応可能

            $table->timestamps();
            // created_at: レコードが作成された日時を格納します。
            // updated_at: レコードが最後に更新された日時を格納します。
            // 自動管理: LaravelのEloquent ORMがこれらのカラムを自動的に管理します。新しいレコードが作成されたときに created_at が設定され、レコードが更新されたときに updated_at が自動的に更新されます。
            // NULLの許可なし: これらのカラムには NULL 値は許可されません。常に有効な日時が設定されます


            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('secondary_category_id')->references('id')->on('secondary_categories');
            $table->foreign('item_condition_id')->references('id')->on('item_conditions');
            // foreign() メソッドの第一引数には、外部キー制約を設定するカラム（seller_id や buyer_id）を指定し、
            // references() メソッドの引数には、参照先のテーブル名（users）とそのテーブル内の参照するカラム（id）を指定します。
            // 削除時の挙動: onDelete('set null') などのオプションを使用することで、参照先の行が削除された際の挙動を設定できます。
            // set null は、参照先の行が削除されたときに外部キーの値を NULL に設定します

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // secondary_categories という名前のテーブルが存在する場合にそのテーブルを削除します。
        // dropIfExists メソッドは、指定したテーブルが存在する場合にのみ削除操作を行い、存在しない場合は何もしません。

        Schema::dropIfExists('items');
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
        Schema::dropIfExists('item_conditions');
    }
}
