<?php $__env->startSection('content'); ?>
<!--  Bootstrapのcontainerクラスを使用して、ページ全体のコンテンツを中央に配置します。 -->
<div class="container">
    <!-- rowクラスを使用して、その中に含まれる要素を中央に配置します -->
    <div class="row justify-content-center">
        <!-- Bootstrapのcol-md-8クラスを使用して、中央に8つのカラム幅のカードを表示します -->
        <div class="col-md-8">
            <!-- Bootstrapのcardクラスを使用して、情報をカードの形式で表示 -->
            <div class="card">
                <!-- 実際に表示される内容は、言語ファイル内でキーに対応する値が設定されているかどうかに依存します。例えば、resources/lang/en/messages.phpに次のように設定されている場合
                 return ['verify_email' => 'Verify Your Email Address',];　この場合、__('verify_email')と記述することで「Verify Your Email Address」というテキストが表示されます -->
                <div class="card-header"><?php echo e(__('Verify Your Email Address')); ?></div>

                <!-- Bootstrapのカード（card）コンポーネントの本文部分を定義する要素です。通常、この要素内にはカードの内容を表示するコンテンツが含まれます。例えば、フォームやテキスト、画像などを配置することができます -->
                <div class="card-body">
                    <!-- ユーザーに新しい確認リンクがメールアドレスに送信されたことを示すアラートメッセージを表示するために使用されます -->
                    <?php if(session('resent')): ?>
                        <div class="alert alert-success" role="alert">
                            <!-- 言語ファイルから「A fresh verification link has been sent to your email address.」というテキストを取得して表示することができます -->
                            <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

                        </div>
                    <?php endif; ?>
<!-- 続行する前に、確認リンクを含むメールをご確認ください。」というメッセージを表示 -->
                    <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

                    <!-- メールが届かない場合は、」という部分を表示 -->
                    <?php echo e(__('If you did not receive the email')); ?>,
                    <form class="d-inline" method="POST" action="<?php echo e(route('verification.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <!-- ここをクリックして別のリクエストを送信してください」というテキストを含むボタンを表示します -->
		                <button type="submit" class="btn btn-link p-0 m-0 align-baseline"><?php echo e(__('click here to request another')); ?></button>.
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/test/mercari_flea_market_laravel6/resources/views/auth/verify.blade.php ENDPATH**/ ?>