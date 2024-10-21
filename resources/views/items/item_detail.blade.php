@extends('layouts.app')

@section('title')
    {{$item->name}} | 商品詳細
@endsection
<!-- http://localhost/a_laravel/public/items/11 -->
@section('content')
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
<!-- インクルードディレクティブで別のbladeを読み込むことができます -->
            @include('items.item_detail_panel', [
                'item' => $item
            ])

            <div class="row">
                <div class="col-8 offset-2">
                    @if ($item->isStateSelling)
                        <a href="{{route('item.buy', [$item->id])}}" class="btn btn-secondary btn-block">購入(｀・ω・´)ゞ</a>
                    @else
                        <button class="btn btn-dark btn-block" disabled>売却済み٩( 'ω' )و</button>
                    @endif
                </div>
            </div>
<!-- nl2br関数で改行文字をbrタグに変換できます。先にe関数（HTMLをエスケープします）に掛けてからnl2br関数に掛けるのがコツです。
(逆にするとbrタグがエスケープされてしまいます) -->
            <div class="my-3">{!! nl2br(e($item->description)) !!}</div>
        </div>
    </div>
</div>
@endsection
