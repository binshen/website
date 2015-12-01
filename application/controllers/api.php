<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('house_model');
	}
	
	public function update_weixin_user($openid) {
		$this->api_model->update_weixin_user($openid);
	}
	
	public function view_art($open_id, $broker_id) {
		//$this->api_model->update_weixin_user($open_id);
		
		$token = $this->api_model->get_or_create_token();
		$access_token = $token['token'];
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
		$result = file_get_contents($url);
		$jsonInfo = json_decode($result, true);
		$this->assign('subscribe', $jsonInfo['subscribe']);

		$ticket = $this->api_model->get_or_create_jsapi_ticket();
		$signPackage = $this->getSignPackage($ticket);
		$this->assign('signPackage', $signPackage);
		
		$article = $this->house_model->get_article($broker_id);
		$this->assign('article', $article);
		$this->display('broker/article.html');
	}
	
///////////////////////////////////////////////////////////////////////////	
	public function index() {
		$articles = array(
			array(
				'title' => urlencode('周市 宇业天逸华庭 3室2厅 104 60万'),
				'url' => 'http://www.funmall.com.cn/b_house/view_detail/2904',
				'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151102135539/1/817a0b92fbf7bc3bd0dde2cd1de60277.png'
			),
			array(
				'title' => urlencode('城中 锦晟花园 5室1厅 120 100万'),
				'url' => 'http://www.funmall.com.cn/b_house/view_detail/2791',
				'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151030134650/1/283f930940902011b0e3aa4b683cfaf3.jpg'
			),
			array(
				'title' => urlencode('城中 金鹰天地 4室2厅 170 238万'),
				'url' => 'http://www.funmall.com.cn/b_house/view_detail/2836',
				'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151030163107/1/dca6a48adf15403065c5a23ecd0eae59.png'
			)
		);
		$ret = $this->api_model->send_message('orFu-vgK-snskoQdDgMkBe-jFe1k', $articles);
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