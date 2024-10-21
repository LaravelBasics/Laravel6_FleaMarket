<?php

// namespace App;
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//User モデルは、Laravel の認証機能を使用しており、ユーザーの情報を管理するために利用されています
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // $fillable プロパティは、ユーザーモデルに直接代入可能な属性（カラム）を指定します。
    // ここでは、name、email、password の3つが設定されています。
    // これにより、これらの属性をMass Assignment（一括代入）できるようにしています
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // $hidden プロパティは、配列に指定された属性（ここでは password と remember_token）をJSON配列や配列としてシリアライズする際に非表示にします。
    // これにより、APIなどでパスワードやトークンが暴露されることを防ぎます
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // $casts プロパティは、モデルの属性をネイティブなPHPのデータ型にキャストする方法を定義します。
    // ここでは email_verified_at を datetime 型にキャストしています。これにより、
    // この属性を操作する際に常に日時オブジェクトとして取り扱えます
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function soldItems()//soldItems() メソッドは、User モデルと Item モデルの間に1対多の関係を定義します
    {//この関係により、特定のユーザーが販売した商品（Item モデルのインスタンス）を取得することができます
        return $this->hasMany(Item::class, 'seller_id');//Item::class：関連付けるモデルのクラス名を指定します。ここでは Item::class を使用しています
    }//'seller_id'：Item モデルの中で、外部キーとして使用されるユーザーのIDを示します。
    // つまり、このメソッドはユーザーが販売した商品を取得する際に、Item モデルの seller_id カラムを使用します

    public function boughtItems()
    {
        return $this->hasMany(Item::class, 'buyer_id');
    }
}
