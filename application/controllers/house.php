<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 房源列表页/详情页控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		bin.shen
 *
 */
class House extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('house_model');
	}
	
	public function index() {
		
	}
	
	public function new_house_list() {
		
		$this->display('new_house_list.html');
	}
	
	public function second_hand_list() {
		
		$search_region_list = $this->house_model->get_search_region_list();
		$this->assign('search_region_list', $search_region_list);
		
		$search_style_list = $this->house_model->get_search_style_list();
		$this->assign('search_style_list', $search_style_list);
		
		$this->assign('search_region', $this->input->post('search_region'));
		$this->assign('search_style', $this->input->post('search_style'));
		$this->assign('search_price', $this->input->post('search_price'));
		$this->assign('search_acreage', $this->input->post('search_acreage'));
		$this->assign('search_type', $this->input->post('search_type'));
		$this->assign('search_feature', $this->input->post('search_feature'));
		
		$this->display('second_hand_list.html');
	}
}
