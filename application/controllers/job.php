<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('job_model');
	}
	
	public function match_house() {
		$this->job_model->match_house();
	}
}