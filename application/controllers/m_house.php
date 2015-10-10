<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_house extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('house_model');
		$this->load->model('manage_model');
	}
	
	public function index() {
		
		$term_list = $this->house_model->get_m_index();
		$this->assign('term_list', $term_list);
		
// 		$username = $this->session->userdata('rel_name');
// 		$this->assign('username', $username);
		
		$this->display('mobile/index.html');
	}
	
	public function view_list($term_id, $page=1) {
		$region_list = $this->house_model->get_m_house_region();
		$this->assign('region_list', $region_list);
		
		$style_list = $this->house_model->get_search_style_list();
		$this->assign('style_list', $style_list);
		
		$house_list = $this->house_model->get_m_house_list($term_id, $page);
		$this->assign('house_list', $house_list);
		
		$this->assign('term_id', $term_id);
		$term = $this->house_model->get_m_term($term_id);
		$this->assign('term_name', $term['name']);
		$this->assign('term_title', $term['title']);
		$this->assign('term_is_top', $term['is_top']);
		$this->assign('term_pic', $term['pic']);
		
		/////////////////////////////////////////////////////
		$search_region = $this->input->post('search_region');
		if(!empty($search_region)) {
			$this->assign('search_region', $search_region);
			$search_region_name = "不限";
			foreach ($region_list as $region) {
				if($region['id'] == $search_region) {
					$search_region_name = $region['name'];
					break;
				}
			}
			$this->assign('search_region_name', $search_region_name);
		} else {
			$this->assign('search_region_name', '区域');
		}
		
		$search_style = $this->input->post('search_style');
		if(!empty($search_style)) {
			$this->assign('search_style', $search_style);
			$search_style_name = "不限";
			foreach ($style_list as $style) {
				if($style['id'] == $search_style) {
					$search_style_name = $style['name'];
					break;
				}
			}
			$this->assign('search_style_name', $search_style_name);
		} else {
			$this->assign('search_style_name', '类型');
		}
		
		$search_price = $this->input->post('search_price');
		if(!empty($search_price)) {
			$this->assign('search_price', $search_price);
			$search_price_names = array(
					0 => '不限',
					1 => '50万以下',
					2 => '50-80万',
					3 => '80-100万',
					4 => '100-120万',
					5 => '120-150万',
					6 => '150-200万',
					7 => '200-250万',
					8 => '250-300万',
					9 => '300-500万',
					10 => '500万以上'
			);
			$this->assign('search_price_name', $search_price_names[$search_price]);
		} else {
			$this->assign('search_price_name', '售价');
		}
		
		$search_acreage = $this->input->post('search_acreage');
		if(!empty($search_acreage)) {
			$this->assign('search_acreage', $search_acreage);
			$search_acreage_names = array(
					0 => '不限',
					1 => '50平以下',
					2 => '50-70平',
					3 => '70-90平',
					4 => '90-120平',
					5 => '120-150平',
					6 => '150-200平',
					7 => '200-300平',
					8 => '300平以上'
			);
			$this->assign('search_acreage_name', $search_acreage_names[$search_acreage]);
		} else {
			$this->assign('search_acreage_name', '面积');
		}
		
		$search_type = $this->input->post('search_type');
		if(!empty($search_type)) {
			$this->assign('search_type', $search_type);
			$search_type_names = array(
					0 => '不限',
					1 => '一室',
					2 => '二室',
					3 => '三室',
					4 => '四室',
					5 => '五室',
					6 => '五室以上'
			);
			$this->assign('search_type_name', $search_type_names[$search_type]);
		} else {
			$this->assign('search_type_name', '户型');
		}
		
		$search_feature = $this->input->post('search_feature');
		if(!empty($search_feature)) {
			$this->assign('search_feature', $search_feature);
			$this->assign('search_feature_name', empty($search_feature)?'不限':$search_feature);
		} else {
			$this->assign('search_feature_name', '特色');
		}
		
		$pager = $this->pagination->getMobilePageLink('/m_house/view_list/'.$term_id, $house_list['countPage'], $house_list['numPerPage'], $term_id);
		$this->assign('pager', $pager);
		
		$this->display('mobile/list.html');
	}
	
	public function view_detail($hid, $term_id = null) {
		
		$this->assign('term_id', $term_id);
		$house = $this->house_model->get_m_house_detail($hid);
		$house['unit_price'] = intval($house['total_price'] * 10000 / $house['acreage']);
		
		if(!empty($house['refresh_time'])) {
			$house['refresh_date'] = date('Y-m-d', strtotime($house['refresh_time']));
			$datetime1 = date_create($house['refresh_time']);
			$datetime2 = date_create(date('Y-m-d H:i:s'));
			$interval = date_diff($datetime1, $datetime2);
			$house['hours'] = $interval->days * 24 + $interval->h;
		} else {
			$house['refresh_date'] = '';
			$house['hours'] = '';
		}
		$house['house_pics_all'] = $this->house_model->get_second_hand_house_pics($hid);
		$house['house_pics'] = array_slice($house['house_pics_all'], 0, 5);
		$house['house_pics_rest'] = array_slice($house['house_pics_all'], 6, 5);
		$this->assign('house', $house);
		
		$user_id = $this->session->userdata('user_id');
		$user_type_id = $this->session->userdata('user_type_id');
		$this->assign('user_id', $user_id);
		$this->assign('user_type_id', $user_type_id);
		
		$collected = $this->house_model->check_collect_house($user_id, $user_type_id, $hid);
		$this->assign('collected', $collected);
		
		$this->display('mobile/details.html');
	}
	
	public function collect() {
		$uid = $this->input->post('uid');
		$type = $this->input->post('type');
		$hid = $this->input->post('hid');
		echo $this->house_model->collect_house($uid, $type, $hid);
	}
	
	public function compare($hid1, $hid2, $term_id) {
		$this->assign('term_id', $term_id);
// 		$term = $this->house_model->get_m_term($term_id);
// 		$this->assign('term_name', $term['name']);
// 		$this->assign('term_title', $term['title']);
		
		$house1 = $this->house_model->get_m_house_detail($hid1);
		$house1['unit_price'] = intval($house1['total_price'] * 10000 / $house1['acreage']);
		
		$house2 = $this->house_model->get_m_house_detail($hid2);
		$house2['unit_price'] = intval($house2['total_price'] * 10000 / $house2['acreage']);
		
		$this->assign('house1', $house1);
		$this->assign('house2', $house2);
		
		$this->display('mobile/contrast-tool.html');
	}
	
	public function compute() {
		
		$this->display('mobile/daikuan.html');
	}
}