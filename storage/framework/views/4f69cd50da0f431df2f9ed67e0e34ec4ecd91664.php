<!DOCTYPE html>
<!-- web画面で表示される言語を設定している -->
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <!-- width=device-width: デバイスの幅にページの幅を合わせることを指定します。これにより、画面幅に合わせてコンテンツが自動的に調整されます -->
    <!-- initial-scale=1: ページの初期表示倍率を設定します。1 は通常、通常の倍率で表示することを意味します。ユーザーがページにアクセスしたときに、初期状態で通常の拡大率で表示されるように指定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<!-- ファビコン -->
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name', 'Laravel')); ?></title>
     <link rel="shortcut icon" href="<?php echo e(asset('/images/logo.ico')); ?>">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* ローディング画面のスタイル */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            z-index: 9999; /* 最前面に表示 */
        }

        @keyframes  rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #loading-screen p {
            animation: rotate 2s linear infinite;
        }
    </style>
</head>
<body>
    <!-- ローディング画面 -->
    <div id="loading-screen">
        <p>ロード中...</p>
    </div>
    <div id="app">
        
        <?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- Header パーシャルのインクルード -->
        <!-- x-headerx-header Header コンポーネントの挿入larabel　7以降の機能 -->
        <main class="py-4">
            
            <?php echo $__env->yieldContent('content'); ?>
        </main>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <script>
        // ページが完全に読み込まれたらローディング画面を非表示にする
        window.onload = function() {
            const loadingScreen = document.getElementById('loading-screen');
            loadingScreen.style.display = 'none'; // ローディング画面を非表示
        };
    </script>
    <?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/layouts/app.blade.php ENDPATH**/ ?>