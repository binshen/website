<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_api extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_api_model');
		
		header('Content-Type: application/json; charset=utf-8');
	}
	
	public function login() {
		
		$username = $this->input->post('username'); 
		$password = $this->input->post('password');
		$result = $this->m_api_model->login($username, $password);
		echo json_encode(array('result' => $result));
	}
}