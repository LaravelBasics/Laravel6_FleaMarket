

<?php $__env->startSection('title'); ?>
商品一覧
<?php $__env->stopSection(); ?>
<!-- http://localhost/a_laravel/public/ -->
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
         <!-- test0.jpg を表示 -->
    <img src="<?php echo e(asset('images/test0.jpg')); ?>" alt="Test Image">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-3 mb-3">
            <div class="card">
                <div class="position-relative overflow-hidden">
                    <img class="card-img-top" src="<?php echo e(asset('/storage/item-images/' . $item->image_file_name)); ?>">

                    <div class="position-absolute py-2 px-3" style="left: 0; bottom: 20px; color: white; background-color: rgba(0, 0, 0, 0.70)">
                        <i class="fas fa-yen-sign"></i>
                        <span class="ml-1"><?php echo e(number_format($item->price)); ?></span>
                    </div>
                    <?php if($item->isStateBought): ?>
                    <div class="position-absolute py-1 font-weight-bold d-flex justify-content-center align-items-end" style="left: 0; top: 0; color: white; background-color: #EA352C; transform: translate(-50%,-50%) rotate(-45deg); width: 125px; height: 125px; font-size: 20px;">
                        <span>SOLD</span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <small class="text-muted"><?php echo e($item->secondaryCategory->primaryCategory->name); ?> / <?php echo e($item->secondaryCategory->name); ?></small>
                    <h5 class="card-title"><?php echo e($item->name); ?></h5>
                </div>
                <a href="<?php echo e(route('item', [$item->id])); ?>" class="stretched-link"></a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- withQueryString() メソッドは Laravel 7 で導入された新機能です。
    そのため、Laravel 6 ではこの方法でページネーションリンクを生成することはできません。
    Laravel 6 で同様のページネーションを行う場合、以下 -->
    <div class="d-flex justify-content-center">
        <?php echo e($items->links()); ?>

    </div>


</div>

<a href="<?php echo e(route('sell')); ?>" class="bg-secondary text-white d-inline-block d-flex justify-content-center align-items-center flex-column" role="button" style="position: fixed; bottom: 30px; right: 30px; width: 150px; height: 150px; border-radius: 75px;">
    <div style="font-size: 24px;">出品</div>
    <div>
        <i class="fas fa-camera" style="font-size: 30px;"></i>
    </div>
</a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/items/items.blade.php ENDPATH**/ ?>