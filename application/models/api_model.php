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
	
	public function get_access_token() {
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
		$response = file_get_contents($url);
		return json_decode($response)->access_token;
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
}