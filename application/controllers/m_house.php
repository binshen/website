<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_house extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('house_model');
		$this->load->model('manage_model');
	}
	
	public function index() {
	}
	
	public function view_list() {
		
		$region_list = $this->house_model->get_m_house_region();
		$this->assign('region_list', $region_list);
		
		$style_list = $this->house_model->get_search_style_list();
		$this->assign('style_list', $style_list);
		
		$this->display('mobile/list.html');
	}
	
	public function view_detail() {
		$this->display('mobile/details.html');
	}
	
	public function compare() {
		$this->display('mobile/contrast-tool.html');
	}
}