<?php
namespace app\admin\controller;
use http\Cookie;
use think\Db;
use think\Config;
use think\Cache;
use think\View;

class Artplayer extends Base
{

	public function index()
	{
		//后台模版方法
		if (Request()->isPost()) {
			$config = input();
			$config_new["artplayer"] = $config["artplayer"];
			$config_old = config("artplayer");
			$config_new = array_merge($config_old, $config_new);
			//写入模版后台配置
			$res = mac_arr2file(APP_PATH . "extra/artplayer.php", $config_new);
			if ($res === false) {
				return $this->error("保存失败，请重试!");
			}
			return $this->success("保存成功!");
		}
		$this->assign("config", config("artplayer"));
		//写模版后台前端
		return $this->fetch("admin@artplayer/index");
	}


}