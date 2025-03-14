<?php
// 引入ThinkPHP自动加载文件
require_once 'vendor/autoload.php';

// 测试修复后的think-image库
try {
    // 创建一个测试图片
    $width = 300;
    $height = 150;
    $image = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bg);

    // 保存测试图片
    $testImagePath = './test_fixed_image.png';
    imagepng($image, $testImagePath);
    imagedestroy($image);

    echo "测试图片已创建: $testImagePath\n";

    // 使用think-image库处理图片
    $thinkImage = \think\Image::open($testImagePath);

    // 测试使用GD内置字体添加水印
    $builtinFontPath = './test_builtin_font.png';
    $thinkImage->text('使用GD内置字体', 5, 12, '#FF0000', \think\Image::WATER_CENTER)
               ->save($builtinFontPath);
    echo "使用GD内置字体添加水印成功: $builtinFontPath\n";

    // 测试使用TTF字体添加水印（如果存在）
    $fontPath = './static/font/test.ttf';
    $ttfFontPath = './test_ttf_font.png';

    // 创建字体目录
    if (!is_dir(dirname($fontPath))) {
        mkdir(dirname($fontPath), 0777, true);
    }

    // 检查是否有TTF字体文件
    if (file_exists($fontPath)) {
        $thinkImage->text('使用TTF字体', $fontPath, 20, '#0000FF', \think\Image::WATER_SOUTH)
                   ->save($ttfFontPath);
        echo "使用TTF字体添加水印成功: $ttfFontPath\n";
    } else {
        echo "TTF字体文件不存在，跳过TTF字体测试\n";
    }

    // 测试缩略图功能
    $thumbPath = './test_fixed_thumb.png';
    $thinkImage->thumb(150, 75)->save($thumbPath);
    echo "缩略图创建成功: $thumbPath\n";

    echo "think-image库修复测试成功\n";
} catch (Exception $e) {
    echo "测试失败: " . $e->getMessage() . "\n";
    echo "错误位置: " . $e->getFile() . " 第 " . $e->getLine() . " 行\n";
    echo "错误堆栈: \n" . $e->getTraceAsString() . "\n";
}
?>
