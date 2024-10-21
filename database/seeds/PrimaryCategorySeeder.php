<?php

use Illuminate\Database\Seeder;
use App\Models\PrimaryCategory;

class PrimaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PrimaryCategory::class)->create([
            'id'      => 1,
            'name'    => 'レディース',
            'sort_no' => 1,
        ]);
        factory(PrimaryCategory::class)->create([
            'id'      => 2,
            'name'    => 'メンズ',
            'sort_no' => 2,
        ]);
        factory(PrimaryCategory::class)->create([
            'id'      => 3,
            'name'    => 'ベビー・キッズ',
            'sort_no' => 3,
        ]);
        factory(PrimaryCategory::class)->create([
            'id'      => 4,
            'name'    => 'その他',
            'sort_no' => 4,
        ]);
    }
    // リストやメニューの順序付け: カテゴリや商品のリストなど、特定の順序で表示する必要がある場合に、sort_noを使って順序を指定します。
    // データの優先順位付け: 特定のデータに対して優先順位を付ける場合に、sort_noを使って重要度や順序を示します。
    // ソート操作の基準: ユーザーがデータを並べ替えたい場合に、sort_noを基準にソート操作を行います。
}
