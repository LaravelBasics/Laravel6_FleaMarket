<?php
function resizeImage($filePath, $width, $height) {
    // ファイルが存在するか確認
    if (!file_exists($filePath)) {
        die("指定されたファイルが存在しません: $filePath\n");
    }

    list($originalWidth, $originalHeight) = getimagesize($filePath);
    $image = imagecreatefromjpeg($filePath);
    
    if (!$image) {
        die("画像の作成に失敗しました: $filePath\n");
    }

    $resizedImage = imagecreatetruecolor($width, $height);

    // リサイズ
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

    // 保存先のパスを指定
    $outputPath = '/var/www/html/test/mercari_flea_market_laravel6/storage/app/public/resized-image.jpg';
    if (imagejpeg($resizedImage, $outputPath)) {
        echo "リサイズされた画像が保存されました: $outputPath\n";
    } else {
        die("画像の保存に失敗しました\n");
    }

    imagedestroy($image);
    imagedestroy($resizedImage);
}

// 使用例
resizeImage('/var/www/html/test/mercari_flea_market_laravel6/storage/app/public/item-images/4Spd29FT9syTxM7vSB1jpixV56uBxZrZEDERB9il.jpg', 800, 600);
?>
