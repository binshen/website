<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_house extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
	}
	
	public function view_list() {
		$this->display('mobile/list.html');
	}
	
	public function view_detail() {
		$this->display('mobile/details.html');
	}
	
	public function compare() {
		$this->display('mobile/contrast-tool.html');
	}
}