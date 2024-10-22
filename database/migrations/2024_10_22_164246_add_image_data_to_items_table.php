<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageDataToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
     public function up()
     {
         Schema::table('items', function (Blueprint $table) {
             $table->binary('image_data')->nullable(); // 画像データを追加
         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
     public function down()
     {
         Schema::table('items', function (Blueprint $table) {
             $table->dropColumn('image_data'); // カラム削除
         });
     }

}
