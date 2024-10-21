

<?php $__env->startSection('title'); ?>
    <?php echo e($item->name); ?> | 商品詳細
<?php $__env->stopSection(); ?>
<!-- http://localhost/a_laravel/public/items/11 -->
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8 offset-2 bg-white">
            <div class="row mt-3">
                <div class="col-8 offset-2">
                    <?php if(session('message')): ?>
                        <div class="alert alert-<?php echo e(session('type', 'success')); ?>" role="alert">
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
<!-- インクルードディレクティブで別のbladeを読み込むことができます -->
            <?php echo $__env->make('items.item_detail_panel', [
                'item' => $item
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="row">
                <div class="col-8 offset-2">
                    <?php if($item->isStateSelling): ?>
                        <a href="<?php echo e(route('item.buy', [$item->id])); ?>" class="btn btn-secondary btn-block">購入(｀・ω・´)ゞ</a>
                    <?php else: ?>
                        <button class="btn btn-dark btn-block" disabled>売却済み٩( 'ω' )و</button>
                    <?php endif; ?>
                </div>
            </div>
<!-- nl2br関数で改行文字をbrタグに変換できます。先にe関数（HTMLをエスケープします）に掛けてからnl2br関数に掛けるのがコツです。
(逆にするとbrタグがエスケープされてしまいます) -->
            <div class="my-3"><?php echo nl2br(e($item->description)); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/items/item_detail.blade.php ENDPATH**/ ?>