

<?php $__env->startSection('title'); ?>
プロフィール編集
<?php $__env->stopSection(); ?>
<!-- http://localhost/a_laravel/public/mypage/edit-profile -->
<?php $__env->startSection('content'); ?>
<div id="profile-edit-form" class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <?php if(session('status')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(session('status')); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2 bg-white">

            <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">プロフィール編集φ(..)メモあああ</div>

            <form method="POST" action="<?php echo e(route('mypage.edit-profile')); ?>" class="p-5" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                
                <span class="avatar-form image-picker">
                    <input type="file" name="avatar" class="d-none" accept="image/png,image/jpeg,image/gif" id="avatar" />
                    <label for="avatar" class="d-inline-block">
                        
                        <?php if(!empty($user->avatar_file_name)): ?>
                        <img src="<?php echo e(asset('/storage/avatars/' . $user->avatar_file_name)); ?>" class="rounded-circle" style="object-fit: cover; width: 200px; height: 200px;">
                        <?php else: ?>
                        <img src="<?php echo e(asset('/images/avatar-default.svg')); ?>" class="rounded-circle" style="object-fit: cover; width: 200px; height: 200px;">
                        <?php endif; ?>

                    </label>
                </span>

                
                <div class="form-group mt-3">
                    <label for="name">ニックネーム</label>
                    <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $user->name)); ?>" required autocomplete="name" autofocus>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group mb-0 mt-3">
                    <button type="submit" class="btn btn-block btn-secondary">
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/mypage/profile_edit_form.blade.php ENDPATH**/ ?>