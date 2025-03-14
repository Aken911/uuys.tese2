<?php
// 检查GD库是否安装
if (extension_loaded('gd')) {
    echo "GD库已安装\n";

    // 获取GD库信息
    $gd_info = gd_info();
    echo "GD库版本: " . (isset($gd_info['GD Version']) ? $gd_info['GD Version'] : '未知') . "\n";

    // 检查支持的图片格式
    echo "支持的图片格式:\n";
    echo "- JPEG: " . (isset($gd_info['JPEG Support']) && $gd_info['JPEG Support'] ? '是' : '否') . "\n";
    echo "- PNG: " . (isset($gd_info['PNG Support']) && $gd_info['PNG Support'] ? '是' : '否') . "\n";
    echo "- GIF: " . (isset($gd_info['GIF Read Support']) && $gd_info['GIF Read Support'] ? '是' : '否') . "\n";
    echo "- WebP: " . (isset($gd_info['WebP Support']) && $gd_info['WebP Support'] ? '是' : '否') . "\n";

    // 检查是否支持FreeType
    echo "FreeType支持: " . (isset($gd_info['FreeType Support']) && $gd_info['FreeType Support'] ? '是' : '否') . "\n";
} else {
    echo "GD库未安装，请安装GD库后再使用图片处理功能\n";
}

// 检查think-image库
$thinkImagePath = 'vendor/topthink/think-image/src/Image.php';
if (file_exists($thinkImagePath)) {
    echo "think-image库文件存在\n";
} else {
    echo "think-image库文件不存在，请检查composer依赖\n";
}

// 尝试创建一个简单的图片
try {
    // 创建一个空白图片
    $image = imagecreatetruecolor(100, 100);

    // 设置背景颜色
    $bg = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bg);

    // 设置文字颜色
    $textColor = imagecolorallocate($image, 0, 0, 0);

    // 写入文字
    imagestring($image, 5, 10, 40, 'GD Test', $textColor);

    // 保存图片
    $outputFile = 'test_gd_output.png';
    imagepng($image, $outputFile);
    imagedestroy($image);

    echo "测试图片已创建: $outputFile\n";
} catch (Exception $e) {
    echo "创建测试图片失败: " . $e->getMessage() . "\n";
}
?>
