<?php
require_once "jssdk.php";
/**
 *
 * 微信APi接口类
 * @author limx
 *
 */
class WxApi extends JSSDK {

	public $code = "";
	public $state = "";
	public $redirect_uri = "";

	public function WxGetUserInfo() {
		// 获取AccessToken
		$accessToken = $this -> getOAuthAccessToken();
		//获取基本信息
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $accessToken["access_token"] . "&openid=" . $accessToken["openid"] . "&lang=zh_CN";
		
		//$res = $this -> httpGet($url);
		
		$res = json_decode($this -> httpGet($url));
		if (is_object($res)) {
			$res = (array)$res;
		}

		return $res;

	}

	private function getOAuthAccessToken() {

		if ($this -> code == "") {
			$this -> getCode();
			exit ;
		}
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$this->code&grant_type=authorization_code";
		$res = json_decode($this -> httpGet($url));
		if (is_object($res)) {
			$res = (array)$res;
		}
		return $res;
	}

	private function getCode() {

		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=$this->redirect_uri&response_type=code&scope=snsapi_userinfo&state=$this->state#wechat_redirect";
		//echo $url;exit;
		Header("Location: $url");
	}

}
