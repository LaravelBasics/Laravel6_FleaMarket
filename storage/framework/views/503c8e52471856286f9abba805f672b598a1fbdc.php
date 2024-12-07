

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

            <div class="font-weight-bold text-center border-bottom pb-3 pt-3" style="font-size: 24px">プロフィール編集</div>

            <form method="POST" action="<?php echo e(route('mypage.edit-profile')); ?>" class="p-5" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                
                <span class="avatar-form image-picker">
                    <!-- ファイル選択ボタンを隠して、ラベルをクリックしたときにファイル選択がされるようにする -->
                    <input type="file" name="avatar" class="d-none" accept="image/png,image/jpeg,image/gif" id="avatar" onchange="updateAvatarPreview()" />
                    <label for="avatar" class="d-inline-block" style="cursor: pointer;">
                        <img id="avatar-preview" src="<?php echo e(asset('/images/test0.jpg')); ?>" class="rounded-circle" style="object-fit: cover; width: 200px; height: 200px;" onclick="changeAvatarImage()" />
                    </label>
                    <!-- 選択された画像のインデックスを送信するための隠しフィールド -->
                    <input type="hidden" name="selected-avatar" id="selected-avatar" value="0">
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

<?php $__env->startSection('script'); ?>
<script>
    let imageIndex = 0; // 初期値としてtest0.jpgを選択

    // 画像のパスを配列に格納
    const imagePaths = [
        "<?php echo e(asset('/images/test0.jpg')); ?>", 
        "<?php echo e(asset('/images/test1.jpg')); ?>", 
        "<?php echo e(asset('/images/test2.jpg')); ?>", 
        "<?php echo e(asset('/images/test3.jpg')); ?>"
    ];

    // 画像が選ばれた場合にプレビューを更新
    function updateAvatarPreview() {
        const fileInput = document.getElementById('avatar');
        const previewImage = document.getElementById('avatar-preview');

        if (fileInput.files && fileInput.files[0]) {
            // ユーザーが画像を選択した場合、その画像をプレビュー
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            // 画像が選ばれていない場合、test0.jpgをプレビュー
            previewImage.src = imagePaths[imageIndex];
        }
    }

    // 画像をクリックすると次の画像に切り替わる
    function changeAvatarImage() {
        // 次の画像に切り替え、最後に達したら最初に戻る
        imageIndex = (imageIndex + 1) % imagePaths.length; 
        document.getElementById('avatar-preview').src = imagePaths[imageIndex];

        // 隠しフィールドに選択された画像のインデックスをセット
        document.getElementById('selected-avatar').value = imageIndex;
    }

    // 画像の選択を防ぐ（エクスプローラーが開かない）
    document.getElementById('avatar').addEventListener('click', function(event) {
        if (!this.files.length) {
            event.preventDefault(); // ファイルが選択されていなければ、ダイアログを開かない
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/mypage/profile_edit_form.blade.php ENDPATH**/ ?>