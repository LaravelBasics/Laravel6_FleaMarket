

<?php $__env->startSection('title'); ?>
    購入した商品一覧
<?php $__env->stopSection(); ?>
<!-- http://localhost/a_laravel/public/mypage/bought-items -->
<?php $__env->startSection('content'); ?>
    <div class="container">

        <div class="row">
            <div class="col-10 offset-1 bg-white">

                <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">購入した商品</div>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex mt-3 border position-relative">
                        <div>
                            <!-- imagesディレクトリから購入した商品画像を表示 -->
                            <img src="<?php echo e(asset('images/'.$item->image_file_name)); ?>" class="img-fluid" style="height: 140px;">
                        </div>
                        <div class="flex-fill p-3">
                            <div>
                                <span class="badge badge-dark px-2 py-2">売却済</span>
                                <span><?php echo e($item->secondaryCategory->primaryCategory->name); ?> / <?php echo e($item->secondaryCategory->name); ?></span>
                            </div>
                            <div class="card-title mt-2 font-weight-bold" style="font-size: 20px"><?php echo e($item->name); ?></div>
                            <div>
                                <i class="fas fa-yen-sign"></i>
                                <span class="ml-1"><?php echo e(number_format($item->price)); ?></span>
                                <i class="far fa-clock ml-3"></i>
                                <span><?php echo e($item->bought_at->format('Y年n月j日 H:i')); ?></span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('item', [$item->id])); ?>" class="stretched-link"></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/mypage/bought_items.blade.php ENDPATH**/ ?>