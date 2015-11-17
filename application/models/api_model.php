<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends MY_Model {

	public function __construct () {
		parent::__construct();
	}
	
	public function __destruct () {
		parent::__destruct();
	}
	
	public function get_access_token() {
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
		$response = file_get_contents($url);
		return json_decode($response)->access_token;
	}
	
	public function get_or_create_token() {
		
		$this->db->from('token');
		$this->db->where('app_id', APP_ID);
		$this->db->where('app_secret', APP_SECRET);
		$data_token = $this->db->get()->row_array();
		if(empty($data_token)) {
			$data = array(
				'app_id' => APP_ID,
				'app_secret' => APP_SECRET,
				'token' => $this->get_access_token(),
				'created' => time()
			);
			$this->db->insert('token', $data);
			return $data;
		} else {
			$interval = time() - intval($data_token['created']);
			if($interval / 60 / 60 > 1) {
				$data_token['token'] = $this->get_access_token();
				$data_token['created'] = time();
				$this->db->where('id', $data_token['id']);
				$this->db->update('token', $data_token);
			}
			return $data_token;
		}
	}
	
	public function get_jsapi_ticket() {
		$token = $this->get_or_create_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi';
		var_dump($url);
		$response = file_get_contents($url);
		var_dump($response);
		return json_decode($response)->ticket;
	}
	
	public function get_or_create_jsapi_ticket() {
		$this->db->from('ticket');
		$this->db->where('app_id', APP_ID);
		$this->db->where('app_secret', APP_SECRET);
		$data_ticket = $this->db->get()->row_array();
		if(empty($data_ticket)) {
			$data = array(
				'app_id' => APP_ID,
				'app_secret' => APP_SECRET,
				'token' => $this->get_jsapi_ticket(),
				'created' => time()
			);
			$this->db->insert('token', $data);
			return $data;
		} else {
			$interval = time() - intval($data_ticket['created']);
			if($interval / 60 / 60 > 1) {
				$data_ticket['ticket'] = $this->get_jsapi_ticket();
				$data_ticket['created'] = time();
				$this->db->where('id', $data_ticket['id']);
				$this->db->update('ticket', $data_ticket);
			}
			return $data_ticket;
		}
	}
	
	public function get_or_create_ticket($id, $action_name = 'QR_LIMIT_SCENE') {
		$this->db->from('admin');
		$this->db->where('id', $id);
		$broker = $this->db->get()->row_array();
		if(!empty($broker)) {
			if(empty($broker['ticket'])) {
				$token_data = $this->get_or_create_token();
				$access_token = $token_data['token'];
				$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
				@$post_data->action_name = $action_name;
				@$post_data->action_info->scene->scene_id = $id;
				$ticket_data = json_decode($this->post($url, $post_data));
				$ticket = $ticket_data->ticket;
				$data = array(
					'ticket' => $ticket
				);
				$this->db->where('id', $id);;
				$this->db->update('admin', $data);
				return $ticket;
			} else {
				return $broker['ticket'];
			}
		}
		return null;
	}
	
	public function send_message($access_token, $message, $open_id) {
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
		$content = array();
// 		$content['touser'] = $open_id;
// 		$content['msgtype'] = 'text';
// 		$content['text'] = array('content' => $message);

		$content['touser'] = $open_id;
		$content['msgtype'] = 'news';
		$content['news'] = array(
			'articles' => array(
				array(
					'title' => urlencode('周市 宇业天逸华庭 3室2厅 104 60万'),
					'url' => 'http://www.funmall.com.cn/b_house/view_detail/2904',
					'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151102135539/1/817a0b92fbf7bc3bd0dde2cd1de60277.png'
				),
				array(
					'title' => urlencode('城中 锦晟花园 5室1厅 120 100万'),
					'url' => 'http://www.funmall.com.cn/b_house/view_detail/2791',
					'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151030134650/1/283f930940902011b0e3aa4b683cfaf3.jpg'
				),
				array(
					'title' => urlencode('城中 金鹰天地 4室2厅 170 238万'),
					'url' => 'http://www.funmall.com.cn/b_house/view_detail/2836',
					'picurl' => 'http://www.funmall.com.cn/uploadfiles/pics/20151030163107/1/dca6a48adf15403065c5a23ecd0eae59.png'
				)
			)
		);
		return $this->post($url, $content);
	}
}