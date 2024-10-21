<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <!-- app.blade.phpのインクルードで呼び出し -->
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('/images/logo-1.png')); ?>" style="height: 39px;" alt="Melpit">
        </a>
        <!-- 6-3ヘッダーに検索フォームを作ろう Bootstrap を使用してナビゲーションバーのトグルボタンを作成-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                <form class="form-inline" method="GET" action="<?php echo e(route('top')); ?>">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="custom-select" name="category">
                                <option value="">全て(`･ω･´)</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="primary:<?php echo e($category->id); ?>" class="font-weight-bold" <?php echo e($defaults['category'] == "primary:" . $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                <?php $__currentLoopData = $category->secondaryCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secondary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="secondary:<?php echo e($secondary->id); ?>" <?php echo e($defaults['category'] == "secondary:" . $secondary->id ? 'selected' : ''); ?>>　<?php echo e($secondary->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <input type="text" name="keyword" class="form-control" value="<?php echo e($defaults['keyword']); ?>" aria-label="Text input with dropdown button" placeholder="キーワード検索(ΦωΦ)">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-dark">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- 4-4ヘッダー部分を作ろう -->

                <?php if(auth()->guard()->guest()): ?>
                
                <li class="nav-item">
                    <a class="btn btn-secondary ml-3" href="<?php echo e(route('register')); ?>" role="button">会員登録_(:3 」∠)_</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-info ml-2" href="<?php echo e(route('login')); ?>" role="button">ログイン|ω・)</a>
                </li>
                <?php else: ?>
                
                <li class="nav-item dropdown ml-2">
                    
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?php if(!empty($user->avatar_file_name)): ?>
                        <img src="<?php echo e(asset('/storage/avatars/' . $user->avatar_file_name)); ?>" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                        <?php else: ?>
                        <img src="<?php echo e(asset('/images/avatar-default.svg')); ?>" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                        <?php endif; ?>
                        <?php echo e($user->name); ?> <span class="caret"></span>
                    </a>

                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="dropdown-item-text">
                            <div class="row no-gutters">
                                <div class="col">売上金|ω・)
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-yen-sign"></i>
                                    <span class="ml-1"><?php echo e(number_format($user->sales)); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item-text">
                            <div class="row no-gutters">
                                <div class="col">出品数(`･ω･´)</div>
                                <div class="col-auto"><?php echo e(number_format($user->soldItems->count())); ?> 個</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>


                        <a class="dropdown-item" href="<?php echo e(route('sell')); ?>">
                            <i class="fas fa-camera text-left" style="width: 30px"></i>商品を出品する(´っ･ω･)っ
                        </a>

                        <a class="dropdown-item" href="<?php echo e(route('mypage.sold-items')); ?>">
                            <i class="fas fa-store-alt text-left" style="width: 30px"></i>出品した商品(∩´∀｀)∩
                        </a>

                        <a class="dropdown-item" href="<?php echo e(route('mypage.bought-items')); ?>">
                            <i class="fas fa-shopping-bag text-left" style="width: 30px"></i>購入した商品( ..)φメモメモ
                        </a>

                        <a class="dropdown-item" href="<?php echo e(route('mypage.edit-profile')); ?>">
                            <i class="far fa-address-card text-left" style="width: 30px"></i>プロフィール編集(?_?)
                        </a>

                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt text-left" style="width: 30px"></i>ログアウトε≡≡ﾍ( ´Д`)ﾉ
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/components/header.blade.php ENDPATH**/ ?>