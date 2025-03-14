<?php
/*
'软件名称：苹果CMS 全局工具函数示例
'--------------------------------------------------------
'Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
'遵循Apache2开源协议发布，并提供免费使用。
'--------------------------------------------------------
*/
namespace app\common\example;

use app\common\util\GlobalUtil;

/**
 * GlobalUtil类使用示例
 */
class GlobalUtilExample
{
    /**
     * 运行所有示例
     */
    public function runAllExamples()
    {
        $this->formatDateTimeExample();
        $this->generateRandomStringExample();
        $this->getClientIpExample();
        $this->filterHtmlExample();
        $this->subStringExample();
        $this->formatFileSizeExample();
        $this->isMobileDeviceExample();
        $this->httpRequestExample();
    }

    /**
     * 格式化日期时间示例
     */
    public function formatDateTimeExample()
    {
        // 格式化当前时间
        $currentDateTime = GlobalUtil::formatDateTime();
        echo "当前时间: " . $currentDateTime . "\n";

        // 格式化指定时间戳
        $timestamp = strtotime('2023-01-01 12:00:00');
        $formattedDate = GlobalUtil::formatDateTime($timestamp, 'Y年m月d日 H:i:s');
        echo "格式化指定时间: " . $formattedDate . "\n";
    }

    /**
     * 生成随机字符串示例
     */
    public function generateRandomStringExample()
    {
        // 生成8位随机字符串（包含字母和数字）
        $randomStr = GlobalUtil::generateRandomString();
        echo "8位随机字符串: " . $randomStr . "\n";

        // 生成6位随机数字
        $randomNum = GlobalUtil::generateRandomString(6, true);
        echo "6位随机数字: " . $randomNum . "\n";
    }

    /**
     * 获取客户端IP地址示例
     */
    public function getClientIpExample()
    {
        // 获取客户端IP地址（字符串格式）
        $ipStr = GlobalUtil::getClientIp();
        echo "客户端IP地址(字符串): " . $ipStr . "\n";

        // 获取客户端IP地址（整数格式）
        $ipInt = GlobalUtil::getClientIp(true);
        echo "客户端IP地址(整数): " . $ipInt . "\n";
    }

    /**
     * 过滤HTML标签示例
     */
    public function filterHtmlExample()
    {
        // 包含脚本和样式的HTML内容
        $html = '<div>这是一个<script>alert("XSS攻击");</script>示例<style>.test{color:red;}</style>文本</div>';
        
        // 过滤HTML标签
        $filteredHtml = GlobalUtil::filterHtml($html);
        echo "原始HTML: " . $html . "\n";
        echo "过滤后HTML: " . $filteredHtml . "\n";
    }

    /**
     * 截取字符串示例
     */
    public function subStringExample()
    {
        // 长文本
        $longText = '这是一段很长的文本，用于测试截取字符串功能。我们将截取前10个字符，并在末尾添加省略号。';
        
        // 截取字符串
        $shortText = GlobalUtil::subString($longText, 10);
        echo "原始文本: " . $longText . "\n";
        echo "截取后文本: " . $shortText . "\n";
    }

    /**
     * 格式化文件大小示例
     */
    public function formatFileSizeExample()
    {
        // 文件大小（字节）
        $sizes = [
            1024,           // 1KB
            1048576,        // 1MB
            1073741824,     // 1GB
            1099511627776   // 1TB
        ];
        
        // 格式化文件大小
        foreach ($sizes as $size) {
            $formattedSize = GlobalUtil::formatFileSize($size);
            echo "原始大小: " . $size . " 字节, 格式化后: " . $formattedSize . "\n";
        }
    }

    /**
     * 检查是否为移动设备示例
     */
    public function isMobileDeviceExample()
    {
        // 检查是否为移动设备
        $isMobile = GlobalUtil::isMobileDevice();
        echo "是否为移动设备: " . ($isMobile ? '是' : '否') . "\n";
    }

    /**
     * 发送HTTP请求示例
     */
    public function httpRequestExample()
    {
        // 发送GET请求
        $url = 'https://api.example.com/data';
        $params = ['key' => 'value', 'page' => 1];
        $headers = ['User-Agent: Example/1.0'];
        
        echo "发送HTTP请求示例 (实际请求未执行)\n";
        echo "URL: " . $url . "\n";
        echo "参数: " . json_encode($params) . "\n";
        echo "请求头: " . json_encode($headers) . "\n";
        
        // 注意：这里不实际执行请求，仅作示例
        // $response = GlobalUtil::httpRequest($url, $params, 'GET', $headers);
        // echo "响应状态码: " . $response['code'] . "\n";
        // echo "响应数据: " . $response['data'] . "\n";
    }
} 