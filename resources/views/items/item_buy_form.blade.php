@extends('layouts.app')

@section('title')
{{$item->name}} | 商品購入
@endsection
<!-- http://localhost/a_laravel/public/items/12/buy -->
@section('content')
<!-- 以下のコードでPAY.JPのクライアントサイド向けのライブラリを読み込む -->
<script src="https://js.pay.jp/v2/pay.js"></script>
<div class="container">
    <div class="row">
        <div class="col-8 offset-2 bg-white">
            <div class="row mt-3">
                <div class="col-8 offset-2">
                    @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }}" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
            </div>
<!-- 商品パネルを再利用 -->
            @include('items.item_detail_panel', [
            'item' => $item
            ])

            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card-form-alert alert alert-danger" role="alert" style="display: none"></div>
                    <div class="form-group mt-3">
                        <label for="number-form">カード番号</label>
                        <span>例:4242 4242 4242 4242</span>
                        <div id="number-form" class="form-control">
                            <!-- ここにカード番号入力フォームが生成されます -->
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="expiry-form">有効期限未来の年月</label>
                        <div id="expiry-form" class="form-control">
                            <!-- ここに有効期限入力フォームが生成されます -->
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="expiry-form">セキュリティコード任意の3桁数字</label>
                        <div id="cvc-form" class="form-control">
                            <!-- ここにCVC入力フォームが生成されます -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col-8 offset-2">

                    <button class="btn btn-secondary btn-block" onclick="onSubmit(event)">購入</button>
                </div>
            </div>

            <form id="buy-form" method="POST" action="{{route('item.buy', [$item->id])}}">
                @csrf
                <input type="hidden" id="card-token" name="card-token">
            </form>
        </div>
    </div>
</div>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var payjp = Payjp('{{config("payjp.public_key")}}');
    //     var elements = payjp.elements();
    //     var numberElement = elements.create('cardNumber');
    //     var expiryElement = elements.create('cardExpiry');
    //     var cvcElement = elements.create('cardCvc');

    //     numberElement.mount('#number-form');
    //     expiryElement.mount('#expiry-form');
    //     cvcElement.mount('#cvc-form');
    // });
    var payjp = Payjp('{{config("payjp.public_key")}}')//PAY.JPのクライアントライブラリを初期化,config("payjp.public_key") は、Laravelの設定ファイルからPAY.JPのパブリックキーを取得

    var elements = payjp.elements()//PAY.JP Elements API を使用するための要素オブジェクトを取得

    var numberElement = elements.create('cardNumber')//create メソッドを使用してカード番号、有効期限、CVCの入力要素を作成しています
    var expiryElement = elements.create('cardExpiry')
    var cvcElement = elements.create('cardCvc')
    // それぞれの要素を numberElement, expiryElement, cvcElement として取得し、mount メソッドでそれぞれのフォーム要素 (#number-form, #expiry-form, #cvc-form) にマウントしています
    numberElement.mount('#number-form');
    expiryElement.mount('#expiry-form');
    cvcElement.mount('#cvc-form');

    function onSubmit(event) {//購入ボタンがクリックされた際に実行される関数
        const msgDom = document.querySelector('.card-form-alert');//.card-form-alert というクラスを持つ要素を取得し、
        msgDom.style.display = "none";//エラーメッセージを表示するために display: none で非表示にしていま

        //  payjp.createToken(numberElement) を使用して、入力されたカード情報を元にPAY.JPにトークンを作成しています。
        // この際、then メソッドで非同期的にトークンの作成結果を取得し、エラーがあればエラーメッセージを表示し、
        // 正常な場合はトークンをフォームに設定して購入フォーム (#buy-form) を送信しています
        payjp.createToken(numberElement).then(function(r) {
            if (r.error) {
                msgDom.innerText = r.error.message;
                msgDom.style.display = "block";
                return;
            }

            document.querySelector('#card-token').value = r.id;
            document.querySelector('#buy-form').submit();
        })
    }//PAY.JPを使用したクレジットカード情報の安全な処理と、それに伴うフォームの送信処理が行われています
</script>
@endsection