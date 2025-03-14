<?php
/**
 * PHP调试测试文件
 *
 * 使用方法：
 * 1. 在VSCode中打开此文件
 * 2. 在第15行设置断点（点击行号左侧）
 * 3. 按F5或点击"运行和调试"按钮
 * 4. 选择"Launch Current Script"配置
 * 5. 观察变量值和调用堆栈
 */

// 初始化变量
$testString = "Hello, World!";
$testArray = [1, 2, 3, 4, 5];
$testObject = new stdClass();
$testObject->name = "Test Object";
$testObject->value = 42;

// 在这里设置断点
function calculateSum($numbers) {
    $sum = 0;
    foreach ($numbers as $number) {
        $sum += $number;
    }
    return $sum;
}

// 调用函数
$sum = calculateSum($testArray);

// 输出结果
echo "测试字符串: " . $testString . "\n";
echo "测试数组: " . implode(", ", $testArray) . "\n";
echo "数组元素和: " . $sum . "\n";
echo "测试对象: " . $testObject->name . " - " . $testObject->value . "\n";

// 测试条件语句
if ($sum > 10) {
    echo "和大于10\n";
} else {
    echo "和小于或等于10\n";
}

// 测试循环
echo "测试循环:\n";
for ($i = 0; $i < 5; $i++) {
    echo "循环 #" . ($i + 1) . "\n";
}

echo "调试测试完成!\n";
?>
