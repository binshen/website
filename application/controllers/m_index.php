<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->display('mobile/index.html');
	}
}