<?php
// env関数で.envまたは環境変数の値を取得できます。
// 第一引数には環境変数の名前を指定します。
// 第二引数には環境変数が見つからなかった場合の初期値を指定できます。
// ここでは.envのPAYJP_PUBLIC_KEYの値を取得しています

return [
    'public_key' => env('PAYJP_PUBLIC_KEY'),
    'secret_key' => env('PAYJP_SECRET_KEY'),
];

// env関数を使うのはconfig内のみにしましょう。
// 理由は、「configをキャッシュすると、env関数が必ずnullを返すようになる」という仕様があるためです。

// config以外の箇所（例えばコントローラなど）からenv関数を呼び出していると、
// 本番環境ではconfigをキャッシュしている場合に、本番環境にデプロイした途端に動かなくなるということがありますので注意しましょう。
