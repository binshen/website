<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户登录画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		bin.shen
 *
 */
class User extends MY_Controller {

	public function __construct() {
		parent::__construct();

	}
	
	public function login() {
		
		$this->display('login.html');
	}
	
	public function logout() {
		
		$this->session->sess_destroy();
		redirect('/');
	}
	
	public function register() {
		
		$this->display('register.html');
	}
}