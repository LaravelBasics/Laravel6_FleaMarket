<?php

use Illuminate\Database\Seeder;
use App\Models\ItemCondition;

class ItemConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ItemCondition::class)->create([
            'id'      => 1,
            'name'    => '新品、未使用',
            'sort_no' => 1,
        ]);
        factory(ItemCondition::class)->create([
            'id'      => 2,
            'name'    => '未使用に近い',
            'sort_no' => 2,
        ]);
        factory(ItemCondition::class)->create([
            'id'      => 3,
            'name'    => '目立った傷や汚れなし',
            'sort_no' => 3,
        ]);
        factory(ItemCondition::class)->create([
            'id'      => 4,
            'name'    => 'やや傷や汚れあり',
            'sort_no' => 4,
        ]);
        factory(ItemCondition::class)->create([
            'id'      => 5,
            'name'    => '傷や汚れあり',
            'sort_no' => 5,
        ]);
        factory(ItemCondition::class)->create([
            'id'      => 6,
            'name'    => '全体的に状態が悪い',
            'sort_no' => 6,
        ]);
    }
    // factory(ItemCondition::class)->create() を使うことで、Laravelのファクトリー機能を利用してモデルのインスタンスを生成し、
    // データベースに初期データを挿入することができます

    // コントローラクラスで使用する一例
    // public function index(){
    //     $conditions = ItemCondition::all();
    //     return view('conditions.index', ['conditions' => $conditions]);
    
    // ItemCondition::all()を使ってitem_conditionsテーブルからすべてのレコードを取得し、ビューに渡しています。
    // ItemCondition::classは、App\Models\ItemConditionというクラスの完全修飾名を表すので、モデルを使用する際には便利です
}
