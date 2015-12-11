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
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token['token'].'&type=jsapi';
		$response = file_get_contents($url);
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
				'ticket' => $this->get_jsapi_ticket(),
				'created' => time()
			);
			$this->db->insert('ticket', $data);
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
	
	public function send_message($open_id, $articles) {
		$token = $this->get_or_create_token();
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token['token'];
		$content = array();
		$content['touser'] = $open_id;
		$content['msgtype'] = 'news';
		$content['news'] = array('articles' => $articles);
		return $this->post($url, $content);
	}
	
	public function update_weixin_user($open_id) {
		if(!empty($open_id)) {
			$token = $this->get_or_create_token();
			$access_token = $token['token'];
			$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
			$result = file_get_contents($url);
			$data = json_decode($result, true);
			
			$this->db->from('weixin');
			$this->db->where('openid', $open_id);
			$data_weixin = $this->db->get()->row_array();
			if(empty($data_weixin)) {
				$this->db->insert('weixin', $data);
			} else {
				$this->db->where('id', $data_weixin['id']);
				$this->db->update('weixin', $data);
			}
		}
	}
	
	public function search_house_by_name($keyword) {
		$this->db->select('a.*, b.name AS xq_name, c.name AS region_name');
		$this->db->from('house a');
		$this->db->join('xiaoqu b', 'a.xq_id = b.id', 'left');
		$this->db->join('house_region c', 'a.region_id = c.id', 'left');
		$this->db->where('a.type_id', 2);
		$this->db->like('b.name', $keyword);
		$this->db->order_by('rand()');
		$this->db->limit(6);
		return $this->db->get()->result_array();
	}
}