<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
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
		
		$this->display('index.html');
	}
}