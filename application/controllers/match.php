<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//https://github.com/bcit-ci/CodeIgniter/issues/1890
/*
<h4>A PHP Error was encountered</h4>
<p>Severity: Notice</p>
<p>Message:  Undefined index: REMOTE_ADDR</p>
<p>Filename: core/Input.php</p>
<p>Line Number: 351</p>
 */
class Match extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		echo "+++++++++++++++++++++++++++++++++++";
	}
}