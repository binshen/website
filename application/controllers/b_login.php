<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class B_login extends MY_Controller {
	
public function __construct() {
		parent::__construct();
		$this->load->model('manage_model');
	}
	
	public function index() {
		$this->display('broker/login.html');
	}
	
	public function login() {
		if($this->manage_model->check_login(true)) {
			redirect(site_url('/b_house/view_list'));
		} else {
			$this->display('broker/login.html');
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		//redirect(site_url('b_login'));
		redirect(site_url('/b_house/view_list'));
	}
	
	public function logout2() {
		$this->session->unset_userdata('login_broker_id');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('group_id');
		$this->session->unset_userdata('rel_name');
		$this->session->unset_userdata('manager_group');
		$this->session->unset_userdata('company_id');
		$this->session->unset_userdata('subsidiary_id');
		$this->session->unset_userdata('login_broker_tel');
		redirect(site_url('/b_house/view_list'));
	}
}