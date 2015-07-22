<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 站点首页控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		bin.shen
 *
 */
class Index extends MY_Controller {

	public function __construct() {
		parent::__construct();

	}
	
	public function index() {
		$data = $this->sysconfig_model->get_index_info();
		
		$this->assign('news1', $data['news1']);
		$this->assign('news2', $data['news2']);
		$this->assign('news3', $data['news3']);
		$this->assign('news4', $data['news4']);
		$this->assign('news5', $data['news5']);
		$this->display('index.html');
	}
}