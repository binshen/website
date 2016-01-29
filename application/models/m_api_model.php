<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class M_api_model extends MY_Model {

	public function __construct () {
        parent::__construct();
    }

    public function __destruct () {
        parent::__destruct();
    }
    
    public function login($username, $password) {
    	
    	$this->db->from('admin');
    	$this->db->where('username', $username);
    	$this->db->where('passwd', sha1($password));
    	return $this->db->get()->row();
    }
    
    public function list_client($id) {
    	
    	$this->db->select('a.open_id, b.nickname, b.sex, b.headimgurl, b.realname, b.user_tel');
    	$this->db->from('wx_user a');
    	$this->db->join('weixin b', 'a.open_id = b.openid', 'inner');
    	$this->db->where('a.broker_id', $id);
    	$this->db->where('b.subscribe', 1);
    }
}