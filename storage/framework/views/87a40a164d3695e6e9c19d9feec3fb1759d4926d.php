<div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px"><?php echo e($item->name); ?></div>
<!-- http://localhost/a_laravel/public/items/12 -->
<div class="row">
    <div class="col-4 offset-1">
        <img class="card-img-top" src="<?php echo e(asset('/storage/item-images/' . $item->image_file_name)); ?>">
    </div>
    <div class="col-6">
        <table class="table table-bordered">
            <tr>
                <th>出品者</th>
                <td>
                    <?php if(!empty($item->seller->avatar_file_name)): ?>
                        <img src="<?php echo e(asset('/storage/avatars/' . $item->seller->avatar_file_name)); ?>" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                    <?php else: ?>
                        <img src="<?php echo e(asset('/images/avatar-default.svg')); ?>" class="rounded-circle" style="object-fit: cover; width: 35px; height: 35px;">
                    <?php endif; ?>
                    <?php echo e($item->seller->name); ?>

                </td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                <td><?php echo e($item->secondaryCategory->primaryCategory->name); ?> / <?php echo e($item->secondaryCategory->name); ?></td>
            </tr>
            <tr>
                <th>商品の状態</th>
                <td><?php echo e($item->condition->name); ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="font-weight-bold text-center pb-3 pt-3" style="font-size: 24px">
    <i class="fas fa-yen-sign"></i>
    <span class="ml-1"><?php echo e(number_format($item->price)); ?></span>
</div>
<?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/items/item_detail_panel.blade.php ENDPATH**/ ?>