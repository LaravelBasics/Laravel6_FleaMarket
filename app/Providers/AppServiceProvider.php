<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Blade;
// use App\View\Components\Header;
use Illuminate\Support\Facades\View;
use App\Http\View\Components\HeaderComposer;
use Payjp\Payjp;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()//アプリケーションのサービスコンテナにサービスを登録するために使用されます。ここでは特に何も登録していません
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ヘッダー　コンポーネントを登録するlaravel　6では未実装
        // Blade::component('header', \App\View\Components\Header::class);
        
        // View::composer('components.header', HeaderComposer::class);


        View::composer('layouts.app', HeaderComposer::class);
// layouts.app ビューがレンダリングされる際に HeaderComposer クラスが自動的に呼び出されるように設定しています。
// HeaderComposer クラスは、ビューがレンダリングされる前にデータを注入するために使用されます

        // View::composer('home', HeaderComposer::class); // 実際のビューファイル名に合わせて修正

        // PayJP SDK の API キーを設定しています。config('payjp.secret_key') は、
        // Laravel の設定ファイル (config/payjp.php など) で設定された PayJP のシークレットキーを取得するための方法
        Payjp::setApiKey(config('payjp.secret_key'));
    }
}
