<?php
/*
'软件名称：苹果CMS 全局工具函数
'--------------------------------------------------------
'Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
'遵循Apache2开源协议发布，并提供免费使用。
'--------------------------------------------------------
*/
namespace app\common\util;

class GlobalUtil
{
    /**
     * 格式化日期时间
     * @param int $timestamp 时间戳
     * @param string $format 格式化字符串
     * @return string 格式化后的日期时间字符串
     */
    public static function formatDateTime($timestamp = 0, $format = 'Y-m-d H:i:s')
    {
        if (empty($timestamp)) {
            $timestamp = time();
        }
        return date($format, $timestamp);
    }

    /**
     * 生成随机字符串
     * @param int $length 字符串长度
     * @param bool $numeric 是否只包含数字
     * @return string 随机字符串
     */
    public static function generateRandomString($length = 8, $numeric = false)
    {
        $chars = $numeric ? '0123456789' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[mt_rand(0, $max)];
        }
        return $result;
    }

    /**
     * 获取客户端IP地址
     * @param bool $convertToInteger 是否转换为整数
     * @return string|int 客户端IP地址
     */
    public static function getClientIp($convertToInteger = false)
    {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        // 验证IP地址格式
        $ip = filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
        
        if ($convertToInteger) {
            $ipParts = explode('.', $ip);
            $ip = (int)$ipParts[0] * 256 * 256 * 256 + (int)$ipParts[1] * 256 * 256 + (int)$ipParts[2] * 256 + (int)$ipParts[3];
        }
        
        return $ip;
    }

    /**
     * 过滤HTML标签
     * @param string $content 需要过滤的内容
     * @param string $allowableTags 允许的HTML标签
     * @return string 过滤后的内容
     */
    public static function filterHtml($content, $allowableTags = '<p><br><a><img><div><span><ul><li><table><tr><td><th><h1><h2><h3><h4><h5><h6>')
    {
        if (empty($content)) {
            return '';
        }
        
        // 移除JavaScript脚本
        $content = preg_replace('/<script[^>]*?>.*?<\/script>/is', '', $content);
        
        // 移除CSS样式
        $content = preg_replace('/<style[^>]*?>.*?<\/style>/is', '', $content);
        
        // 移除HTML注释
        $content = preg_replace('/<!--.*?-->/s', '', $content);
        
        // 过滤HTML标签
        $content = strip_tags($content, $allowableTags);
        
        return $content;
    }

    /**
     * 截取字符串
     * @param string $string 需要截取的字符串
     * @param int $length 截取长度
     * @param string $suffix 截取后缀
     * @param string $charset 字符编码
     * @return string 截取后的字符串
     */
    public static function subString($string, $length = 100, $suffix = '...', $charset = 'utf-8')
    {
        if (empty($string)) {
            return '';
        }
        
        $string = trim($string);
        $strLength = mb_strlen($string, $charset);
        
        if ($strLength <= $length) {
            return $string;
        }
        
        $sliced = mb_substr($string, 0, $length, $charset);
        return $sliced . $suffix;
    }

    /**
     * 格式化文件大小
     * @param int $size 文件大小（字节）
     * @param int $decimals 小数位数
     * @return string 格式化后的文件大小
     */
    public static function formatFileSize($size, $decimals = 2)
    {
        if ($size <= 0) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($size) - 1) / 3);
        
        return sprintf("%.{$decimals}f", $size / pow(1024, $factor)) . ' ' . $units[$factor];
    }

    /**
     * 检查是否为移动设备
     * @return bool 是否为移动设备
     */
    public static function isMobileDevice()
    {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
        return (bool) preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent) 
            || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4));
    }

    /**
     * 发送HTTP请求
     * @param string $url 请求URL
     * @param array $params 请求参数
     * @param string $method 请求方法
     * @param array $headers 请求头
     * @param int $timeout 超时时间（秒）
     * @return array 响应结果
     */
    public static function httpRequest($url, $params = [], $method = 'GET', $headers = [], $timeout = 30)
    {
        $ch = curl_init();
        
        // 设置请求URL
        if ($method == 'GET' && !empty($params)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // 设置请求方法
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        
        // 设置请求头
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        // 设置其他选项
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        // 执行请求
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        return [
            'code' => $httpCode,
            'data' => $response,
            'error' => $error
        ];
    }
}
