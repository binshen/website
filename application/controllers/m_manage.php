<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_manage extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('user_id'))
			redirect(site_url('m_login'));
		$this->assign('rel_name', $this->session->userdata('rel_name'));
		$this->load->model('m_manage_model');
	}
	
	public function index() {
		$data = $this->m_manage_model->get_list($this->session->userdata('user_id'));
		$this->assign('data', $data);
		$this->display('mobile/manager.html');
	}
	
	public function refresh($id){
		$rs = $this->m_manage_model->refresh($id);
		if($rs == 1) {
			$this->show_message('操作成功',site_url('m_manage'));
		} else if($rs == -2){
			$this->show_message('今天已经刷新过该房源');
		} else {
			$this->show_message('操作失败');
		}
	}
	
	public function down_up($id,$exe_status){
		$rs = $this->m_manage_model->down_up($id,$exe_status);
		if($rs){
			$this->show_message('操作成功',site_url('m_manage'));
		}else{
			$this->show_message('操作失败');
		}
	}
	
	public function edit($id) {
		$data = $this->m_manage_model->get_house_detail($id);
		$this->assign('data', $data);
		$this->display('mobile/editor.html');
	}
	
	public function post_edit(){
		$rs = $this->m_manage_model->post_edit();
		if($rs){
			$this->show_message('操作成功',site_url('m_manage'));
		}else{
			$this->show_message('操作失败');
		}
	}
	
	public function collect(){
		$data = $this->m_manage_model->get_collects();
		$this->assign('data', $data['list']);
		$this->assign('house_count', $data['house_count']);
		$this->display('mobile/collect.html');
	}
}