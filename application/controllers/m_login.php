<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('manage_model');
	}
	
	public function index() {
		$this->display('mobile/login.html');
	}
	
	public function login() {
		if($this->manage_model->check_login()) {
			redirect(site_url('/m_manage/'));
		} else {
			$this->display('mobile/login.html');
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect(site_url('m_login'));
	}
}