<?php
if (extension_loaded('gd')) {
    echo "GDライブラリは有効です。\n";
    $gdInfo = gd_info();
    echo "GD Version: " . $gdInfo['GD Version'] . "\n";
    echo "FreeType Support: " . ($gdInfo['FreeType Support'] ? 'はい' : 'いいえ') . "\n";
    echo "JPEG Support: " . ($gdInfo['JPEG Support'] ? 'はい' : 'いいえ') . "\n";
    echo "PNG Support: " . ($gdInfo['PNG Support'] ? 'はい' : 'いいえ') . "\n";
    echo "GIF Support: " . ($gdInfo['GIF Support'] ? 'はい' : 'いいえ') . "\n";
} else {
    echo "GDライブラリは有効ではありません。\n";
}
?>
