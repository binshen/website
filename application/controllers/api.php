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
}