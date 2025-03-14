<?php
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
define('RUNTIME_PATH', __DIR__ . '/runtime/');
define('ROOT_PATH', __DIR__ . '/');

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';

// 测试Image模型
try {
    // 创建一个测试图片
    $width = 300;
    $height = 200;
    $image = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bg);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, 100, 80, 'Image Model Test', $textColor);

    // 保存测试图片
    $testDir = './upload/test/';
    if (!is_dir($testDir)) {
        mkdir($testDir, 0777, true);
    }
    $testImagePath = $testDir . 'test_model_image.png';
    imagepng($image, $testImagePath);
    imagedestroy($image);

    echo "测试图片已创建: $testImagePath\n";

    // 测试水印功能
    $imageModel = model('Image');
    $config = [
        'watermark' => 1,
        'watermark_content' => 'Test Watermark',
        'watermark_font' => './static/font/test.ttf',
        'watermark_size' => 20,
        'watermark_color' => '#FF0000',
        'watermark_location' => 9 // 右下角
    ];

    // 检查字体文件是否存在，如果不存在则创建一个测试字体目录
    if (!file_exists($config['watermark_font'])) {
        $fontDir = dirname($config['watermark_font']);
        if (!is_dir($fontDir)) {
            mkdir($fontDir, 0777, true);
        }

        // 如果没有字体文件，使用数字作为内置字体
        $config['watermark_font'] = 5;
        echo "使用GD内置字体\n";
    }

    // 添加水印
    $watermarkResult = $imageModel->watermark('upload/test/test_model_image.png', $config);
    echo "水印添加" . ($watermarkResult ? "成功" : "失败") . "\n";

    // 测试缩略图功能
    $thumbConfig = [
        'thumb' => 1,
        'thumb_type' => 1, // 等比例缩放
        'thumb_size' => '150x100,100x50' // 多个尺寸
    ];

    // 创建缩略图
    $thumbResult = $imageModel->makethumb('upload/test/test_model_image.png', $thumbConfig);
    echo "缩略图创建" . (!empty($thumbResult['thumb']) ? "成功" : "失败") . "\n";

    if (!empty($thumbResult['thumb'])) {
        foreach ($thumbResult['thumb'] as $thumb) {
            echo "缩略图: " . $thumb['file'] . ", 大小: " . $thumb['size'] . "KB\n";
        }
    }

    echo "Image模型测试完成\n";
} catch (Exception $e) {
    echo "测试失败: " . $e->getMessage() . "\n";
    echo "错误位置: " . $e->getFile() . " 第 " . $e->getLine() . " 行\n";
    echo "错误堆栈: \n" . $e->getTraceAsString() . "\n";
}
?>
