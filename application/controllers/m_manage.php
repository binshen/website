<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_manage extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->display('mobile/manager.html');
	}
	
	public function edit() {
		$this->display('mobile/editor.html');
	}
}