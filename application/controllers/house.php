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
		
		//$search_region_list = $this->house_model->get_room_news();
		$this->assign('search_region_list', $search_region_list);
		
		$search_style_list = $this->house_model->get_search_style_list();
		$this->assign('search_style_list', $search_style_list);
		
		$data = $this->house_model->get_new_house_list();
		$ids = array();
		$xq_ids = array();
		
		foreach ($data['res_list'] as &$d) {
			$d->feature_list = explode(",", $d->feature);
			$region_id = $d->region_id;
			if($region_id < 6) {
				$d->region_fullname = "玉山镇-" . $d->region_name;
			} else {
				$d->region_fullname = $d->region_name . "-" . $d->region_name;
			}
			$ids[] = $d->id;
			$xq_ids[] = $d->xq_id;
		}
		$rooms = $this->house_model->get_house_rooms($ids);
		$news = $this->house_model->get_house_news($xq_ids);
		$this->assign('rooms', $rooms);
		$this->assign('news', $news);
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
		
		$this->assign('search_region', $this->input->post('search_region'));
		$this->assign('search_style', $this->input->post('search_style'));
		$this->assign('search_price', $this->input->post('search_price'));
		$this->assign('search_acreage', $this->input->post('search_acreage'));
		$this->assign('search_type', $this->input->post('search_type'));
		$this->assign('search_feature', $this->input->post('search_feature'));
		
		$this->display('second_hand_list.html');
	}
}
