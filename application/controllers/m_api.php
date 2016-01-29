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
		$user_info = $this->m_api_model->login($username, $password);
		//var_dump($user_info);
		echo json_encode($user_info);
	}
	
	public function list_client($id) {
		
		$client_list = $this->m_api_model->list_client($id);
		echo json_encode($client_list);
	}
}