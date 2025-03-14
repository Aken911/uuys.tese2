<?php
// 引入ThinkPHP自动加载文件
require_once 'vendor/autoload.php';

// 测试think-image库
try {
    // 创建一个测试图片
    $width = 200;
    $height = 100;
    $image = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bg);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, 50, 40, 'Think Image Test', $textColor);

    // 保存测试图片
    $testImagePath = './test_image.png';
    imagepng($image, $testImagePath);
    imagedestroy($image);

    echo "测试图片已创建: $testImagePath\n";

    // 使用think-image库处理图片
    $thinkImage = \think\Image::open($testImagePath);

    // 获取图片信息
    echo "图片宽度: " . $thinkImage->width() . "\n";
    echo "图片高度: " . $thinkImage->height() . "\n";
    echo "图片类型: " . $thinkImage->type() . "\n";
    echo "图片MIME类型: " . $thinkImage->mime() . "\n";

    // 测试缩略图功能
    $thumbPath = './test_image_thumb.png';
    $thinkImage->thumb(100, 50)->save($thumbPath);
    echo "缩略图已创建: $thumbPath\n";

    // 测试添加文字水印
    $watermarkPath = './test_image_watermark.png';
    $thinkImage->text('Watermark', './static/font/test.ttf', 12, '#FF0000')->save($watermarkPath);
    echo "水印图片已创建: $watermarkPath\n";

    echo "think-image库测试成功\n";
} catch (Exception $e) {
    echo "think-image库测试失败: " . $e->getMessage() . "\n";
    echo "错误位置: " . $e->getFile() . " 第 " . $e->getLine() . " 行\n";
    echo "错误堆栈: \n" . $e->getTraceAsString() . "\n";
}
?>
