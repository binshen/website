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
		
		$search_region_list = $this->house_model->get_search_region_list();
		$this->assign('search_region_list', $search_region_list);
		
		$search_style_list = $this->house_model->get_search_style_list();
		$this->assign('search_style_list', $search_style_list);
		
		$data = $this->house_model->get_new_house_list();
		foreach ($data['res_list'] as &$d) {
			$d->feature_list = explode(",", $d->feature);
			$region_id = $d->region_id;
			if($region_id < 6) {
				$d->region_fullname = "玉山镇-" . $d->region_name;
			} else {
				$d->region_fullname = $d->region_name . "-" . $d->region_name;
			}
		}
		$this->assign('new_house_list', $data);
		
		$pager = $this->pagination->getPageLink('/house/new_house_list', $data['countPage'], $data['numPerPage']);
		$this->assign('pager', $pager);
		
		$this->assign('search_region', $this->input->post('search_region'));
		$this->assign('search_style', $this->input->post('search_style'));
		$this->assign('search_price', $this->input->post('search_price'));
		$this->assign('search_acreage', $this->input->post('search_acreage'));
		$this->assign('search_type', $this->input->post('search_type'));
		$this->assign('search_feature', $this->input->post('search_feature'));
		
		$this->display('new_house_list.html');
	}
	
	public function second_hand_list() {
		
		$search_region_list = $this->house_model->get_search_region_list();
		$this->assign('search_region_list', $search_region_list);
		
		$search_style_list = $this->house_model->get_search_style_list();
		$this->assign('search_style_list', $search_style_list);
		
		$data = $this->house_model->get_second_hand_list();
		foreach ($data['res_list'] as &$d) {
			$d->feature_list = explode(",", $d->feature);
			$d->unit_price = intval($d->total_price / $d->acreage * 10000);
			$region_id = $d->region_id;
			if($region_id < 6) {
				$d->region_fullname = "玉山镇-" . $d->region_name;
			} else {
				$d->region_fullname = $d->region_name . "-" . $d->region_name;
			}
		}
		$this->assign('second_hand_list', $data);
		
		$pager = $this->pagination->getPageLink('/house/second_hand_list', $data['countPage'], $data['numPerPage']);
		$this->assign('pager', $pager);
		
		$this->assign('search_text', $this->input->post('search_text'));
		$this->assign('search_region', $this->input->post('search_region'));
		$this->assign('search_style', $this->input->post('search_style'));
		$this->assign('search_price', $this->input->post('search_price'));
		$this->assign('search_acreage', $this->input->post('search_acreage'));
		$this->assign('search_type', $this->input->post('search_type'));
		$this->assign('search_feature', $this->input->post('search_feature'));
		
		$this->assign('search_order', $this->input->post('search_order') ? $this->input->post('search_order') : 1);
		$this->assign('order_price_dir', $this->input->post('order_price_dir') ? $this->input->post('order_price_dir') : 1);
		
		$this->display('second_hand_list.html');
	}
	
	public function second_hand_detail($id) {
		
		$house = $this->house_model->get_second_hand_detail($id);
		$house['feature_list'] = explode(",", $house['feature']);
		$house['unit_price'] = intval($house['total_price'] / $house['acreage'] * 10000);
		
		$this->assign('house', $house);
		
		$this->display('second_hand_detail.html');
	}
}
