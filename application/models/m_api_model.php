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
    	return $this->db->get();
    }
}