<!DOCTYPE html>
<!-- web画面で表示される言語を設定している -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- width=device-width: デバイスの幅にページの幅を合わせることを指定します。これにより、画面幅に合わせてコンテンツが自動的に調整されます -->
    <!-- initial-scale=1: ページの初期表示倍率を設定します。1 は通常、通常の倍率で表示することを意味します。ユーザーがページにアクセスしたときに、初期状態で通常の拡大率で表示されるように指定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- ファビコン -->
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}('ω')</title>
     <link rel="shortcut icon" href="{{ asset('/images/logo.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        
        @include('components.header') <!-- Header パーシャルのインクルード -->
        <!-- x-headerx-header Header コンポーネントの挿入larabel　7以降の機能 -->
        <main class="py-4">
            
            @yield('content')
        </main>
        
    </div>
</body>
</html>
