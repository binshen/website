<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#include_once APPPATH . '/controllers/m_house.php';

class B_house extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('house_model');
		$this->load->model('manage_model');
		$this->load->model('api_model');
		
		$wx_open_id = $this->session->userdata('wx_open_id');
		if(!empty($wx_open_id)) {
			$this->assign('wx_open_id', $wx_open_id);
		}
		$wx_broker_id = $this->session->userdata('wx_broker_id');
		if(!empty($wx_broker_id)) {
			$this->assign('wx_broker_id', $wx_broker_id);
		} else {
			if(!empty($wx_open_id)) {
				$broker = $this->house_model->get_bind_broker_id($wx_open_id);
				$this->assign('wx_broker_id', $broker['broker_id']);
				$this->session->set_userdata('wx_broker_id', $broker['broker_id']);
			}
		}
	}
	
	public function index($oid, $bid=NULL) {
		$this->session->set_userdata('wx_open_id', $oid);
		$this->session->set_userdata('wx_broker_id', $bid);
		//$this->api_model->update_weixin_user($oid);
		
		$this->assign('wx_open_id', $oid);
		$this->assign('wx_broker_id', $bid);
		
		$this->view_art($bid);
	}
	
	public function view_art($bid=NULL) {
		
		$ticket = $this->api_model->get_or_create_jsapi_ticket();
		$signPackage = $this->getSignPackage($ticket);
		$this->assign('signPackage', $signPackage);
		
		$article = $this->house_model->get_article($bid);
		$this->assign('article', $article);
		$this->display('broker/article.html');
	}
	
	public function view_list($page=1) {
		
		$broker_name = $this->session->userdata('rel_name');
		if(!empty($broker_name)) {
			$this->assign('store_name', $broker_name . ' - 微店房源');
		} else {
			$this->assign('store_name', '经纪人微店房源');
		}
		
		$connected_brokers = array();
		$login_broker_id = $this->session->userdata('login_broker_id');
		if(!empty($login_broker_id)) {
			$broker_id = $login_broker_id;
			$open_id = "--BROKER--";
			$company = $this->house_model->get_company_by_broker($broker_id);
			$this->assign('company', $company);
		} else {
			$open_id = $this->session->userdata('wx_open_id');
			$broker_id = $this->session->userdata('wx_broker_id');
			if(!empty($open_id)) {
				$connected_brokers = $this->house_model->get_connected_brokers($open_id);
			}
			$broker = $this->house_model->get_bind_broker_id($open_id);
			$this->assign('connected_broker_id', $broker['broker_id']);
		}
		$this->assign('open_id', $open_id);
		$this->assign('wx_broker_id', $broker_id);
		$this->assign('connected_brokers', $connected_brokers);
		
		$region_list = $this->house_model->get_m_house_region();
		$this->assign('region_list', $region_list);
		
		$style_list = $this->house_model->get_search_style_list();
		$this->assign('style_list', $style_list);
		if(empty($broker_id)) {
			$house_list = $this->house_model->get_b_all_house_list($page);
		} else {
			$house_list = $this->house_model->get_b_broker_house_list($broker_id, $page);
		}
		if(!empty($house_list)) {
			foreach ($house_list['res_list'] as &$d) {
				if(empty($d["total_price"]) || empty($d["acreage"])) {
					$d["unit_price"] = 0;
				} else {
					$d["unit_price"] = intval($d["total_price"] * 10000 / $d["acreage"]);
				}
			}
		}
		$this->assign('house_list', $house_list);
		
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
		
		$pager = $this->pagination->getMobilePageLink('/b_house/view_list/', $house_list['countPage'], $house_list['numPerPage'], 3);
		$this->assign('pager', $pager);
		
		$this->display('broker/list.html');
	}
	
	public function view_detail($hid) {
		
		$open_id = $this->session->userdata('wx_open_id');
		if(!empty($open_id) && !empty($hid)) {
			$this->house_model->track_house($open_id, (int)$hid);
		}

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
		$broker_tel = $this->session->userdata('login_broker_tel');
		if(!empty($broker_tel)) {
			$house['tel'] = $broker_tel;
		}
		$this->assign('house', $house);
		
		$user_id = $this->session->userdata('user_id');
		$this->assign('user_id', $user_id);
		
		$collected = $this->house_model->check_collect_house($user_id, $hid);
		$this->assign('collected', $collected);
		
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
	
	public function compute($id) {
	
		$house = $this->house_model->get_m_house_detail($id);
		$house['unit_price'] = intval($house['total_price'] * 10000 / $house['acreage']);
		$this->assign('house', $house);
		
		$this->display('broker/daikuan.html');
	}
	
	public function card($bid) {
		
		$broker = $this->house_model->get_broker_by_id($bid);
		if(!empty($broker) && empty($broker['ticket'])) {
			$broker['ticket'] = $this->api_model->get_or_create_ticket($broker['id']);
		}
		$this->assign('broker', $broker);
		
		$this->display('broker/card.html');
	}
	
	////////////////////////////////////////////////////////////////////////////////
	public function chat() {
				
		$this->display('broker/chat.html');
	}
	
	public function choose_broker($id, $o_bid) {
		
		$wx_user = $this->house_model->choose_broker($id);
		if(!empty($wx_user)) {
			$open_id = $wx_user['open_id'];
			$broker_id = $wx_user['broker_id'];
			$this->api_model->update_weixin_user($open_id);
			
			$this->session->set_userdata('rel_name', $wx_user['rel_name']);
			$this->session->set_userdata('wx_broker_id', $broker_id);
			
			if($broker_id != $o_bid) {
				$redis = new Redis();
				$redis->connect('127.0.0.1', 6379);
				if(!empty($o_bid)) {
					$o_key = "map:" . $o_bid;
					$redis->lrem($o_key, $open_id, 0);
				}
					
				$key = "map:" . $broker_id;
				$users = $redis->lrange($key, 0, -1);
				if(!in_array($open_id, $users)) {
					$redis->lpush($key, $open_id);
				}
			}
		}
		$this->view_list(1);
	}
	
	public function send_notification($open_id, $broker_id) {
		
		$text = "您收到了一条消息。<a href='http://www.funmall.com.cn/b_house/view_chat/{$open_id}/{$broker_id}'>点击查看</a>";
		$this->api_model->send_text($open_id, urlencode($text));
	}
	
	public function view_chat($open_id, $broker_id, $user_type=1) {
		
		$this->assign('wx_open_id', $open_id);
		$this->assign('wx_broker_id', $broker_id);
		$this->assign('wx_user_type', $user_type);
		$this->display('broker/chat.html');
	}
	
	public function chat_list($broker_id) {
		
		$client_users = $this->house_model->get_bind_client_users($broker_id);
		$this->assign('client_users', $client_users);
		
		$this->assign('wx_broker_id', $broker_id);
		
		$this->display('broker/chat-list.html');
	}
}