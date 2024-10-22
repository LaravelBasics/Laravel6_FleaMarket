<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{//  STATE_SELLING と STATE_BOUGHT は、商品の状態を表す定数
    // 出品中
    const STATE_SELLING = 'selling';//定数の宣言
    // 購入済み
    const STATE_BOUGHT = 'bought';

    protected $casts = [//データベースから取得した日時情報を直接 DateTime オブジェクトとして利用できます
        'bought_at' => 'datetime',
    ];

    protected $fillable = [
        'image_file_name',
        'image_data',
        'seller_id',
        'name',
        'description',
        'secondary_category_id',
        'item_condition_id',
        'price',
        'state',
        // 他のフィールド...
    ];

    public function secondaryCategory()
    {
        return $this->belongsTo(SecondaryCategory::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
        // 外部キーが自動的に推測されます。通常、Eloquent は関連するモデル名（SecondaryCategory）の単数形に _id を付けたカラム（secondary_category_id）を外部キーとして探します。
        // したがって、Item モデルの場合、secondary_category_id カラムが外部キーとして使用されることになります
    }

    public function condition()
    {
        return $this->belongsTo(ItemCondition::class, 'item_condition_id');
        // こちらでは、明示的に外部キーを指定しています。'seller_id' という文字列は、Item モデルの中で User モデルとの関係を示すための外部キーとして使われます。
        // したがって、Item モデルの中には seller_id という名前の外部キーが存在する必要があります
    }

    public function getIsStateSellingAttribute()
    {//このように定数を使用することで、特定の状態（例えば出品中）をわかりやすく表現し、その状態に関する処理や条件分岐を簡潔に記述できるようになります
        return $this->state === self::STATE_SELLING;
    }

    public function getIsStateBoughtAttribute()
    {
        return $this->state === self::STATE_BOUGHT;
    }
}