<?php
/*
'软件名称：苹果CMS 全局工具函数测试
'--------------------------------------------------------
'Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
'遵循Apache2开源协议发布，并提供免费使用。
'--------------------------------------------------------
*/
namespace app\index\controller;

use think\Controller;
use app\common\util\GlobalUtil;
use app\common\example\GlobalUtilExample;

class Test extends Controller
{
    /**
     * 测试全局工具函数
     */
    public function index()
    {
        // 测试格式化日期时间
        $currentDateTime = GlobalUtil::formatDateTime();
        $this->assign('currentDateTime', $currentDateTime);
        
        // 测试生成随机字符串
        $randomStr = GlobalUtil::generateRandomString(10);
        $this->assign('randomStr', $randomStr);
        
        // 测试获取客户端IP
        $clientIp = GlobalUtil::getClientIp();
        $this->assign('clientIp', $clientIp);
        
        // 测试过滤HTML
        $html = '<div>这是一个<script>alert("XSS攻击");</script>示例<style>.test{color:red;}</style>文本</div>';
        $filteredHtml = GlobalUtil::filterHtml($html);
        $this->assign('originalHtml', $html);
        $this->assign('filteredHtml', $filteredHtml);
        
        // 测试截取字符串
        $longText = '这是一段很长的文本，用于测试截取字符串功能。我们将截取前20个字符，并在末尾添加省略号。';
        $shortText = GlobalUtil::subString($longText, 20);
        $this->assign('longText', $longText);
        $this->assign('shortText', $shortText);
        
        // 测试格式化文件大小
        $fileSize = 1048576; // 1MB
        $formattedSize = GlobalUtil::formatFileSize($fileSize);
        $this->assign('fileSize', $fileSize);
        $this->assign('formattedSize', $formattedSize);
        
        // 测试是否为移动设备
        $isMobile = GlobalUtil::isMobileDevice() ? '是' : '否';
        $this->assign('isMobile', $isMobile);
        
        return $this->fetch();
    }
    
    /**
     * 运行所有示例
     */
    public function runExamples()
    {
        // 创建示例对象
        $example = new GlobalUtilExample();
        
        // 开启缓冲区
        ob_start();
        
        // 运行所有示例
        $example->runAllExamples();
        
        // 获取缓冲区内容
        $output = ob_get_clean();
        
        // 将换行符转换为HTML换行
        $output = nl2br($output);
        
        // 输出结果
        return $output;
    }
} 