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

		$this->assign('search_key', $this->input->post('search_key'));
		$this->assign('search_text', $this->input->post('search_text'));
		$this->assign('search_region', $this->input->post('search_region'));
		$this->assign('search_style', $this->input->post('search_style'));
		$this->assign('search_price', $this->input->post('search_price'));
		$this->assign('search_acreage', $this->input->post('search_acreage'));
		$this->assign('search_type', $this->input->post('search_type'));
		$this->assign('search_feature', $this->input->post('search_feature'));
		$this->assign('search_rent_style', $this->input->post('search_rent_style'));
		
		$this->assign('search_order', $this->input->post('search_order') ? $this->input->post('search_order') : 1);
		$this->assign('order_price_dir', $this->input->post('order_price_dir') ? $this->input->post('order_price_dir') : 1);
		
		$this->load->model('house_model');
		$this->load->model('manage_model');
	}
	
	public function index() {
		redirect('/');
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
		$recommend_list = $this->house_model->get_recommend_list();
		foreach($recommend_list as $k=>$v){
			$recommend_list[$k]['feature'] = explode(",", $v['feature']);
		}
		
		$this->assign('rooms', $rooms);
		$this->assign('news', $news);
		$this->assign('recommend_list', $recommend_list);
		$this->assign('new_house_list', $data);
		
		$pager = $this->pagination->getPageLink('/house/new_house_list', $data['countPage'], $data['numPerPage']);
		$this->assign('pager', $pager);
		
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
			$d->unit_price = intval($d->total_price * 10000 / $d->acreage);
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
		
		$recommend_list = $this->house_model->get_recommended_house_list(2);
		foreach($recommend_list as $k=>$v){
			$recommend_list[$k]['feature'] = explode(",", $v['feature']);
		}
		$this->assign('recommend_list', $recommend_list);
		
		$this->display('second_hand_list.html');
	}
	
	private function get_monthly_payment($rate, $months, $amount) {
		$v = 1 + ($rate / 12);
		$t = -($months / 12) * 12;
		$value = ($amount * ($rate / 12))/(1 - pow($v, $t));
		return round($value, 2);
	}
	
	public function second_hand_detail($id) {
		
		$house = $this->house_model->get_second_hand_detail($id);
		$house['feature_list'] = explode(",", $house['feature']);
		$house['unit_price'] = intval($house['total_price'] * 10000 / $house['acreage']);
		$house['first_pay'] = intval($house['total_price'] * 0.3);
		$house['monthly_pay'] = $this->get_monthly_payment(0.054, 240, $house['total_price'] * 10000 * 0.7);
		
		$broker_house_count = $this->house_model->get_broker_house_count($house['broker_id']);
		$house['broker_house_count'] = $broker_house_count;
		
		$house['house_pics_all'] = $this->house_model->get_second_hand_house_pics($id);
		$house['house_pics'] = array_slice($house['house_pics_all'], 0, 5);
		
		$this->assign('house', $house);
		
		$recommend_list = $this->house_model->get_recommended_house_list(2);
		foreach($recommend_list as $k=>$v){
			$recommend_list[$k]['feature'] = explode(",", $v['feature']);
		}
		$this->assign('recommend_list', $recommend_list);
		
		$xy = $this->Convert_GCJ02_To_BD09($house['latitude'],$house['longitude']);
		$this->assign('xy',$xy);
		
		$this->display('second_hand_detail.html');
	}
	
	
	public function rent_house_list() {
		
		$search_region_list = $this->house_model->get_search_region_list();
		$this->assign('search_region_list', $search_region_list);
		
		$search_style_list = $this->house_model->get_search_style_list();
		$this->assign('search_style_list', $search_style_list);
		
		$data = $this->house_model->get_rent_house_list();
		$rent_style_list = array(
			1 => '整租',
			2 => '合租'
		);
		foreach ($data['res_list'] as &$d) {
			$d->feature_list = explode(",", $d->feature);
			$region_id = $d->region_id;
			if($region_id < 6) {
				$d->region_fullname = "玉山镇-" . $d->region_name;
			} else {
				$d->region_fullname = $d->region_name . "-" . $d->region_name;
			}
			$d->rent_style = $rent_style_list[$d->rent_style_id];
		}
		$this->assign('second_hand_list', $data);
		
		$pager = $this->pagination->getPageLink('/house/second_hand_list', $data['countPage'], $data['numPerPage']);
		$this->assign('pager', $pager);
		
		$recommend_list = $this->house_model->get_recommended_house_list(3);
		foreach($recommend_list as $k=>$v){
			$recommend_list[$k]['feature'] = explode(",", $v['feature']);
		}
		$this->assign('recommend_list', $recommend_list);
		
		$this->display('rent_house_list.html');
	}
	
	public function rent_house_detail($id) {
		
		$house = $this->house_model->get_rent_house_detail($id);
		$house['feature_list'] = explode(",", $house['feature']);
		
		$broker_house_count = $this->house_model->get_broker_house_count($house['broker_id']);
		$house['broker_house_count'] = $broker_house_count;
		
		$house['house_pics_all'] = $this->house_model->get_second_hand_house_pics($id);
		$house['house_pics'] = array_slice($house['house_pics_all'], 0, 5);
		
		$rent_type_id = $house['rent_style_id'];
		$rent_style_id = $house['rent_style_id'];
		$rent_style_list = array(
			1 => '整租',
			2 => '合租'
		);
		$rent_type_list = array(
			1 => '付三押一',
			2 => '付二押一',
			3 => '付一押一',
			4 => '其他'
		);
		$house['rent_style'] = $rent_style_list[$rent_style_id];
		$house['rent_type'] = $rent_type_list[$rent_type_id];
		
		$this->assign('house', $house);
		
		$recommend_list = $this->house_model->get_recommended_house_list(3);
		foreach($recommend_list as $k=>$v){
			$recommend_list[$k]['feature'] = explode(",", $v['feature']);
		}
		$this->assign('recommend_list', $recommend_list);
		
		$xy = $this->Convert_GCJ02_To_BD09($house['latitude'],$house['longitude']);
		$this->assign('xy',$xy);
		
		$this->display('rent_house_detail.html');
	}
	
	public function new_house_detail($id) {
		$rooms = $this->house_model->get_house_rooms($id);
		$house = $this->house_model->get_new_house_detail($id);
		$huxing = $this->house_model->get_new_house_huxing($id);
		$house['feature_list'] = explode(",", $house['feature']);
		
		$xy = $this->Convert_GCJ02_To_BD09($house['latitude'],$house['longitude']);
		$this->assign('xy',$xy);
		
		$news = $this->house_model->get_house_news_row($house['xq_id']);
		$pics = $this->house_model->get_new_house_pics($id);
		$prices = $this->house_model->get_new_house_price($id,$house['region_id'],$house['substyle_id']);
		$this->assign('huxing', $huxing);
		$this->assign('prices', $prices);
		$this->assign('house', $house);
		$this->assign('pics', $pics);
		$this->assign('news', $news);
		$this->assign('rooms', $rooms[$id]);
		$this->display('new_house_detail.html');
	}
	
	public function article_list($id){
		$data = $this->house_model->get_article_list($id);
		$this->assign('list', $data['list']);
		$this->assign('tag', $data['tag']);
		$this->display('article_list.html');
	}
	
	public function article_detail($h_id,$id,$flag=null){
		$data = $this->house_model->get_article_detail($h_id,$id,$flag);
		$this->assign('detail', $data['detail']);
		$this->assign('tag', $data['tag']);
		$this->display('article_detail.html');
	}
	
	public function huxing_list($h_id,$count='all',$pageNum=1){
		$rooms = $this->house_model->get_house_rooms($h_id);
		$this->assign('rooms', $rooms[$h_id]);
		$data = $this->house_model->get_huxing_list($h_id,$count,$pageNum);
		$this->assign('huxing_list', $data);
		$this->assign('tag', $data['tag']);
		$pager = $this->pagination->getPageLink('/house/huxing_list/'.$h_id.'/'.$count, $data['countPage'], $data['numPerPage'],5);
		$this->assign('pager', $pager);
		$this->display('huxing_list.html');
	}

	public function publish() {
		
		$region_list = $this->manage_model->get_region_list();
		$decoration_list = $this->manage_model->get_decoration_list();
		$orientation_list = $this->manage_model->get_orientation_list();
		
		$this->assign('region_list', $region_list);
		$this->assign('decoration_list', $decoration_list);
		$this->assign('orientation_list', $orientation_list);
		
		$style_list = $this->manage_model->get_style_list();
		$substyle_list = $this->manage_model->get_substyle_list_by_parent(1);

		$this->assign('style_list', $style_list);
		$this->assign('substyle_list', $substyle_list);
		
		$rent_type_list = array(
			(object)array('id' => 1, 'name' => '付三押一'),
			(object)array('id' => 2, 'name' => '付二压一'),
			(object)array('id' => 3, 'name' => '付一压一'),
			(object)array('id' => 4, 'name' => '其他')
		);
		$this->assign('rent_type_list', $rent_type_list);
		
		$xiaoqu_list = $this->house_model->list_xiaoqu();
		$this->assign('xiaoqu_list', $xiaoqu_list);
		
		$this->assign('time', date('YmdHis'));
		
		$this->display('publish.html');
	}
	
	public function savePublish() {
		
		var_dump($_POST);
		die;
	}
	
	public function get_substyle_list($id) {
		$data = $this->manage_model->get_substyle_list_by_parent($id);
		echo json_encode($data);
		die;
	}
	
// 	public function add_pics(){
		
// 		$this->assign('time', date('YmdHis'));
		
// 		$this->load->view('upload.html');
// 	}
}
