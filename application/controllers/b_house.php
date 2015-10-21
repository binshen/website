<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#include_once APPPATH . '/controllers/m_house.php';

class B_house extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('house_model');
		$this->load->model('manage_model');
	}
	
	public function index() {
		
	}
	
	public function view_list($page=1) {
		
		$this->display('broker/list.html');
	}
	
	public function view_detail($hid) {
		
		$this->display('broker/details.html');
	}
	
	public function compare($hid1, $hid2) {
		
		$house1 = $this->house_model->get_m_house_detail($hid1);
		$house1['unit_price'] = intval($house1['total_price'] * 10000 / $house1['acreage']);
		
		$house2 = $this->house_model->get_m_house_detail($hid2);
		$house2['unit_price'] = intval($house2['total_price'] * 10000 / $house2['acreage']);
		
		$this->assign('house1', $house1);
		$this->assign('house2', $house2);
		
		$this->display('broker/contrast-tool.html');
	}
	
	public function compute() {
	
		$this->display('mobile/daikuan.html');
	}
}