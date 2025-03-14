<?php
namespace app\common\model;
use think\image\Exception;

class Image extends Base {

    public function down_load($url,$config,$flag='vod')
    {
        if(substr($url,0,4)=='http'){
            return $this->down_exec($url,$config,$flag);
        }
        else{
            return $url;
        }
    }

    public function down_exec($url,$config,$flag='vod')
    {
        $upload_image_ext = 'jpg,jpeg,png,gif,webp';
        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        if(!in_array($ext, explode(',', $upload_image_ext))){
            $ext = 'jpg';
        }
        $img = mac_curl_get($url);
        if($img){
            $file_name = md5(uniqid()) .'.' . $ext;
            // 上传附件路径
            $_upload_path = ROOT_PATH . 'upload' . '/' . $flag . '/';
            // 附件访问路径
            $_save_path = 'upload'. '/' . $flag . '/' ;
            $ymd = date('Ymd');
            $n_dir = $ymd;
            for($i=1;$i<=100;$i++){
                $n_dir = $ymd .'-'.$i;
                $path1 = $_upload_path . $n_dir. '/';
                if(file_exists($path1)){
                    $farr = glob($path1.'*.*');
                    if($farr){
                        $fcount = count($farr);
                        if($fcount>999){
                            continue;
                        }
                        else{
                            break;
                        }
                    }
                    else{
                        break;
                    }
                }
                else{
                    break;
                }
            }

            $_upload_path .= $n_dir . '/';
            $_save_path .= $n_dir . '/';

            //附件访问地址
            $_file_path = $_save_path.$file_name;
            //写入文件
            $r = mac_write_file($_upload_path.$file_name,$img);
            if(!$r){
                return $url;
            }
            $file_size = filesize($_upload_path.$file_name);
            // 水印
            if ($config['watermark'] == 1) {
                $this->watermark($_file_path,$config,$flag);
            }
            // 缩略图
            if ($config['thumb'] == 1) {
                $this->makethumb($_file_path,$config,$flag);
            }
            //上传到远程
            $_file_path = model('Upload')->api($_file_path,$config);

            $tmp = $_file_path;
            if((substr($tmp,0,7) == "/upload")){
                $tmp = substr($tmp,1);
            }
            if((substr($tmp,0,6) == "upload")){
                $annex = [];
                $annex['annex_file'] = $tmp;
                $annex['annex_type'] = 'image';
                $annex['annex_size'] = $file_size;
                model('Annex')->saveData($annex);
            }
            return $_file_path;
        }
        else{
            return $url;
        }
    }

    public function watermark($file_path,$config,$flag='vod')
    {
        if(empty($config['watermark_font'])){
            $config['watermark_font'] = './static/font/test.ttf';
        }

        // 检查文件是否存在
        $full_file_path = './' . $file_path;
        if (!file_exists($full_file_path)) {
            return false;
        }

        try {
            // 检查GD库是否支持
            if (!extension_loaded('gd')) {
                return false;
            }

            // 检查字体文件是否存在
            if (!file_exists($config['watermark_font'])) {
                // 尝试使用系统默认字体
                $config['watermark_font'] = 5; // 使用GD内置字体
            }

            // 打开图片
            $image = \think\Image::open($full_file_path);

            // 添加水印
            if (is_numeric($config['watermark_font'])) {
                // 使用GD内置字体
                $image->text($config['watermark_content'], $config['watermark_font'], $config['watermark_size'], $config['watermark_color'], $config['watermark_location'])->save($full_file_path);
            } else {
                // 使用TTF字体
                $image->text($config['watermark_content'], $config['watermark_font'], $config['watermark_size'], $config['watermark_color'], $config['watermark_location'])->save($full_file_path);
            }

            return true;
        }
        catch(\Exception $e){
            // 记录错误日志
            trace('水印添加失败: ' . $e->getMessage(), 'error');
            return false;
        }
    }

    public function makethumb($file_path,$config,$flag='vod',$new=1)
    {
        $thumb_type = isset($config['thumb_type']) ? $config['thumb_type'] : 1; // 默认使用等比例缩放
        $data['thumb'] = [];

        // 检查文件是否存在
        $full_file_path = './' . $file_path;
        if (!file_exists($full_file_path)) {
            return $data;
        }

        if (!empty($config['thumb_size'])) {
            try {
                // 检查GD库是否支持
                if (!extension_loaded('gd')) {
                    return $data;
                }

                // 打开图片
                $image = \think\Image::open($full_file_path);

                // 支持多种尺寸的缩略图
                $thumbs = explode(',', $config['thumb_size']);
                foreach ($thumbs as $k => $v) {
                    $t_size = explode('x', strtolower($v));
                    if (!isset($t_size[1])) {
                        $t_size[1] = $t_size[0];
                    }

                    // 确保尺寸是整数
                    $t_size[0] = intval($t_size[0]);
                    $t_size[1] = intval($t_size[1]);

                    // 如果尺寸为0，跳过
                    if ($t_size[0] <= 0 || $t_size[1] <= 0) {
                        continue;
                    }

                    $new_thumb = $file_path . '_' . $t_size[0] . 'x' . $t_size[1] . '.' . strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                    if($new==0){
                        $new_thumb = $file_path;
                    }

                    // 创建缩略图
                    $image->thumb($t_size[0], $t_size[1], $thumb_type)->save('./' . $new_thumb);

                    // 检查缩略图是否创建成功
                    if (file_exists('./' . $new_thumb)) {
                        $thumb_size = round(filesize('./' . $new_thumb) / 1024, 2);
                        $data['thumb'][$k]['type'] = 'image';
                        $data['thumb'][$k]['flag'] = $flag;
                        $data['thumb'][$k]['file'] = $new_thumb;
                        $data['thumb'][$k]['size'] = $thumb_size;
                        $data['thumb'][$k]['ctime'] = request()->time();

                        // 添加水印
                        if (isset($config['watermark']) && $config['watermark'] == 1) {
                            $this->watermark($new_thumb, $config, $flag);
                        }
                    }
                }
            }
            catch(\Exception $e){
                // 记录错误日志
                trace('缩略图创建失败: ' . $e->getMessage(), 'error');
            }
        }
        return $data;
    }
}
