<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function index() {
		
		$this->api_model->get_or_create_ticket(1);
	}
}