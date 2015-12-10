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
	
	////////////////////////////////////////////////
	public function test() {
		$result = $this->api_model->search_house_by_name('昆山花园');
		var_dump($result);
		
		echo json_decode(json_encode("12321321aaa"));
	}
}