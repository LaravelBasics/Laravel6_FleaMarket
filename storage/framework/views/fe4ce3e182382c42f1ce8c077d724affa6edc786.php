<!doctype html>
<!-- h-100 は、高さ（height）を100%に設定するクラスであり、通常は親要素に対して要素全体を画面の高さに広げる助けとなります -->
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <link rel="shortcut icon" href="/images/logo.ico">
</head>
<body class="h-100 d-flex justify-content-center align-items-center">
    <div class="app app-only-content">
        
        <div class="d-flex justify-content-center">
            <!-- public/images/logo-1.pngにある画像 -->
            <a href="<?php echo e(route('top')); ?>"><img src="<?php echo e(asset('/images/logo-1.png')); ?>" /></a>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            <div class="col-auto">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/layouts/app_only_content.blade.php ENDPATH**/ ?>