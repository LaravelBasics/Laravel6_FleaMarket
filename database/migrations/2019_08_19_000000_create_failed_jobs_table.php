<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
// longText カラムは非常に大きなテキストデータを格納するのに適しており、
// 通常、数十キロバイトからギガバイトにわたる大きな文字列データを保存する場合に使用されます。
// このようなカラムを使用することで、例えばアプリケーションで発生したエラーの詳細なスタックトレースやデバッグ情報、
// 例外の詳細なメッセージなどを保存することができます。これにより、
// 開発やデバッグ時に役立つ情報をデータベースに記録することが可能になります

            $table->timestamp('failed_at')->useCurrent();
// timestamp メソッドは、データベースのテーブルにタイムスタンプを格納するためのカラムタイプを定義します。
// useCurrent() メソッドを付け加えることで、現在の日時をデフォルト値として設定します。これにより、
// レコードが挿入された時点の日時が自動的に記録されます。
// この機能を使用することで、特定の操作のタイムスタンプを簡単に管理し、
// 操作のタイミングや順序を把握することができ例えば、ジョブの失敗時に failed_at カラムに失敗した時刻を記録する場合などに便利 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
