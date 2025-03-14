<?php
namespace app\common\extend\pay;

class Yipay
{
	public $name = "聚合易支付";
	public $ver = "1.0";
	public function submit($user, $order, $param)
	{
		$type = empty($param["paytype"]) ? 1 : $param["paytype"];
		switch (\strval($type)) {
			case "1":
				$type = "alipay";
				break;
			case "2":
				$type = "qqpay";
				break;
			case "3":
				$type = "wxpay";
				break;
			case "7":
				$type = "usdt";
				break;	
			default:
				$type = "alipay";
				break;
		}
		$notify_url = $GLOBALS["http_type"] . $_SERVER["HTTP_HOST"] . "/index.php/payment/notify/pay_type/yipay";
		$return_url = $GLOBALS["http_type"] . $_SERVER["HTTP_HOST"] . "/index.php/payment/notify/pay_type/yipay";
		$out_trade_no = $order["order_code"];
		$name = "积分充值（UID：" . $order["user_id"] . "）";
		$money = sprintf("%.2f", $order["order_price"]);
		$sitename = "在线充值";
		$parameter = ["pid" => trim($this->getConfig("appid")), "type" => $type, "notify_url" => $notify_url, "return_url" => $return_url, "out_trade_no" => $out_trade_no, "name" => $name, "money" => $money, "sitename" => $sitename];
		$para = $this->buildRequestPara($parameter);
		$sHtml = "<form id='yipaysubmit' name='yipaysubmit' action='{$this->getConfig("apiurl")}?_input_charset=utf-8' method='POST'>";
		while (list($key, $val) = each($para)) {
			$sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
		}
		$sHtml = $sHtml . "<input type='submit' value='正在提交'></form>";
		$sHtml = $sHtml . "<script>document.forms['yipaysubmit'].submit();</script>";
		echo $sHtml;
		exit;
	}
	public function notify()
	{
		$param = input();
		$GLOBALS["config"]["pay"] = config("maccms.pay");
		unset($param["/payment/notify/pay_type/yipay"]);
		unset($param["pay_type"]);
		$isSign = $this->getSignVeryfy($param, $param["sign"]);
		if ($isSign) {
			if ($param["trade_status"] == "TRADE_SUCCESS") {
				$res = model("Order")->notify($param["out_trade_no"], "yipay");
				if ($res["code"] > 1) {
					echo "fail";
				} else {
					echo "success";
				}
			} else {
				echo "success";
			}
		} else {
			echo "fail";
		}
	}
	private function getConfig($val = null)
	{
		if (!is_null($val) && isset($GLOBALS["config"]["pay"]["yipay"][$val])) {
			return $GLOBALS["config"]["pay"]["yipay"][$val];
		}
	}
	public function buildRequestPara($para_temp)
	{
		$para_filter = $this->paraFilter($para_temp);
		$para_sort = $this->argSort($para_filter);
		$mysign = $this->buildRequestMysign($para_sort);
		$para_sort["sign"] = $mysign;
		$para_sort["sign_type"] = "MD5";
		return $para_sort;
	}
	public function paraFilter($para)
	{
		$para_filter = [];
		while (list($key, $val) = each($para)) {
			if ($key == "sign" || $key == "sign_type" || $val == "") {
			} else {
				$para_filter[$key] = $para[$key];
			}
		}
		return $para_filter;
	}
	public function argSort($para)
	{
		ksort($para);
		reset($para);
		return $para;
	}
	public function buildRequestMysign($para_sort)
	{
		$prestr = $this->createLinkstring($para_sort);
		$mysign = $this->md5Sign($prestr, $this->getConfig("key"));
		return $mysign;
	}
	public function createLinkstring($para)
	{
		$arg = "";
		while (list($key, $val) = each($para)) {
			$arg .= $key . "=" . $val . "&";
		}
		$arg = substr($arg, 0, count($arg) - 2);
		if (get_magic_quotes_gpc()) {
			$arg = stripslashes($arg);
		}
		return $arg;
	}
	public function md5Sign($prestr, $key)
	{
		$prestr = $prestr . $key;
		return md5($prestr);
	}
	public function getSignVeryfy($para_temp, $sign)
	{
		$para_filter = $this->paraFilter($para_temp);
		$para_sort = $this->argSort($para_filter);
		$prestr = $this->createLinkstring($para_sort);
		$isSgin = false;
		$isSgin = $this->md5Verify($prestr, $sign, $this->getConfig("key"));
		return $isSgin;
	}
	public function md5Verify($prestr, $sign, $key)
	{
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);
		if ($mysgin == $sign) {
			return true;
		} else {
			return false;
		}
	}
}