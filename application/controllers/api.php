<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function index() {
		$token = $this->api_model->get_or_create_token();
		$access_token = $token['token'];
		$ret = $this->api_model->send_message($access_token, 'Hello World', 'orFu-vgK-snskoQdDgMkBe-jFe1k');
		var_dump($ret);
	}
	
	public function test_ticket() {
		$ret = $this->api_model->get_or_create_ticket(1);
		var_dump($ret);
	}
	
	public function test_jsapi_ticket() {
		$ret = $this->api_model->get_or_create_jsapi_ticket();
		var_dump($ret);
	}
	
	public function get_wx_user_info($open_id) {
		$token = $this->api_model->get_or_create_token();
		$access_token = $token['token'];
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
		$result = file_get_contents($url);
		$jsonInfo = json_decode($result, true);
		var_dump($jsonInfo);
		header("Content-type: text/html; charset=utf-8");
	}
}