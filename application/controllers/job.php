<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
		$this->load->model('job_model');
	}
	
	public function match_house() {
		$access_token = $this->api_model->get_access_token();
		$this->job_model->match_house($access_token);
	}
	
	public function bind() {
		$redis = new Redis();
		$redis->connect(REDIS_HOST, REDIS_PORT);
		$redis->auth(REDIS_AUTH);
		
		$results = $this->job_model->getWxUserKeys();
		$keys = array_map(function($v) {
			return 'map:'.$v['broker_id'];
		}, $results);		
		$redis->delete($keys);
				
		$results = $this->job_model->getWxUser();
		foreach($results as $u) {
			$key = 'map:' . $u['broker_id'];
			$open_id = $u['open_id'];
			$redis->lpush($key, $open_id);
		}
	}
	
	
	public function update() {
		$access_token = $this->api_model->get_or_create_token();
		$users = $this->job_model->getWeixinUserList();
		foreach ($users as $u) {
			$open_id = $u["openid"];
			$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
			$result = file_get_contents($url);
			$data = json_decode($result, true);
			$this->db->where('id', $open_id);
			$this->db->update('weixin', $data);
		}
	}
	
	////////////////////////////////////////////////
	public function test() {
		$result = $this->api_model->search_house_by_name('昆山花园');
		var_dump($result);
		
		echo json_decode(json_encode("12321321aaa"));
	}
}