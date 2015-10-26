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
	
	public function view_list($page=1, $bid=NULL) {
		
// 		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
// 			$code = $_GET['code'];
// 			if(empty($code)){
// 				$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
// 				$url = urlencode($url);
// 				redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APP_ID."&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
// 			} else {
// 				$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
// 				$result = file_get_contents($url);
// 				$jsonInfo = json_decode($result, true);
// 				$open_id = $jsonInfo['open_id'];
// 				echo $open_id;
// 				die;
// 			}
// 		}
		
		var_dump($bid);
		
		echo "<hr>";
		
		$this->display('broker/list.html');
	}
	
	public function view_detail($hid) {
		
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
	
	public function compute() {
	
		$this->display('mobile/daikuan.html');
	}
	
	public function card($bid = 1) {
		
		$broker = $this->house_model->get_broker_by_id($bid);
		$this->assign('broker', $broker);
		
		$this->display('broker/card.html');
	}
}