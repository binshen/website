<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Manage extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('manage_model');
		$this->load->library('image_lib');
		$this->load->helper('directory');

	}

	function _remap($method,$params = array())
	{
		if(! $this->session->userdata('username'))
		{
			if($this->input->is_ajax_request()){
				header('Content-type: text/json');
				echo '{
                        "statusCode":"301",
                        "message":"\u4f1a\u8bdd\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\u3002"
                    }';
			}else{
				redirect(site_url('manage_login/login'));
			}

		}else{
			//整理参数
			$params_str = "";
			if($params){
				foreach ($params as $v){
					$params_str = $params_str.$v.',';
				}
			}
			$this->$method(substr($params_str,0,-1));
		}
	}

	public function index()
	{
		$this->load->view('manage/index.php');
	}

	/**
	 *
	 * ***************************************以下为关于我们模块控制器*******************************************************************
	 */

	public function list_about()
	{
		$data = $this->manage_model->list_about();
		$this->load->view('manage/list_about.php',$data);
	}

	public function add_about(){
		$this->load->view('manage/add_about.php');
	}

	public function save_about(){
		$rs = $this->manage_model->save_about();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_about");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function delete_about($id){
		$rs = $this->manage_model->delete_about($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_about", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function edit_about($id){
		$data = $this->manage_model->get_about($id);
		$this->load->view('manage/add_about.php',$data);
	}




	/**
	 *
	 * ***************************************以下为新闻动态模块控制器*******************************************************************
	 */
	//----------------------以下为新闻类别
	public function list_news_type(){
		$data = $this->manage_model->list_news_type();
		$this->load->view('manage/list_news_type.php',$data);
	}

	public function add_news_type(){
		$this->load->view('manage/add_news_type.php');
	}

	public function delete_news_type($id){
		$rs = $this->manage_model->delete_news_type($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news_type", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function edit_news_type($id){
		$data = $this->manage_model->get_news_type($id);
		$this->load->view('manage/add_news_type.php',$data);
	}

	public function save_news_type(){
		$rs = $this->manage_model->save_news_type();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news_type");
		} else {
			form_submit_json("300", $rs);
		}
	}
	//----------------------以下为新闻列表
	public function list_news(){
		$data = $this->manage_model->list_news();
		$data['list_type'] = $this->manage_model->get_news_type_list();
		$this->load->view('manage/list_news.php',$data);
	}

	public function add_news(){
		$data['list_type'] = $this->manage_model->get_news_type_list();
		$this->load->view('manage/add_news.php',$data);
	}

	public function delete_news($id){
		$rs = $this->manage_model->delete_news($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function edit_news($id){
		$data = $this->manage_model->get_news($id);
		$data['list_type'] = $this->manage_model->get_news_type_list();
		$this->load->view('manage/add_news.php',$data);
	}

	public function save_news(){
		//var_dump($this->input->post());die;
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/news/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}

		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$data = $this->input->post();
			unset($data['ajax']);
			unset($data['old_img']);
			$rs = $this->manage_model->save_news($data);
		}else{
			$config['upload_path'] = './././uploadfiles/news';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$data = $this->input->post();
				$data['pic'] = $img_info['file_name'];
				unset($data['ajax']);
				unset($data['old_img']);
				$rs = $this->manage_model->save_news($data);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}

		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news");
		} else {
			form_submit_json("300", $rs);
		}
	}

	/**
	 *
	 * ***************************************以下为顺达人才招聘模块控制器*******************************************************************
	 */
	public function list_recruits(){
		$data = $this->manage_model->list_recruits();
		$this->load->view('manage/list_recruits.php',$data);
	}

	public function add_recruits(){
		$this->load->view('manage/add_recruits.php');
	}

	public function delete_recruits($id){
		$rs = $this->manage_model->delete_recruits($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_recruits", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function edit_recruits($id){
		$data = $this->manage_model->get_recruits($id);
		$this->load->view('manage/add_recruits.php',$data);
	}

	public function save_recruits(){
		$rs = $this->manage_model->save_recruits();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_recruits");
		} else {
			form_submit_json("300", $rs);
		}
	}

	/**
	 *
	 * ***************************************以下为顺达联系我们模块控制器*******************************************************************
	 */
	public function contact(){
		//$data = $this->manage_model->get_contact();
		$this->load->view('manage/test.php');
	}
	
	public function add_pic(){
		//$data = $this->manage_model->get_contact();
		$this->load->view('manage/contact.php');
	}

	public function save_contact(){
//		$config['upload_path'] = './././uploadfiles';
//		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
//		$config['max_size'] = '1000';
//		$config['encrypt_name'] = true;
//		$this->load->library('upload', $config);
//		$rs = $this->upload->data();
//			
//		if($this->upload->do_upload()){
//			var_dump($rs);die;
//		}else{
//			form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
//			exit;
//		}
			
			
		
		echo '{
	"statusCode":"200",
	"message":"\u64cd\u4f5c\u6210\u529f",
	"navTabId":"",
	"rel":"",
	"callbackType":"",
	"forwardUrl":"",
	"confirmMsg":""
}
		';
		//		$rs = $this->manage_model->save_contact();
		//		if ($rs === 1) {
		//			form_submit_json("200", "操作成功", "contact", "", "");
		//		} else {
		//			form_submit_json("300", $rs);
		//		}
	}
	
	
	/**
	 *
	 * ***************************************以下景点图片库控制器*******************************************************************
	 */
	public function list_spots(){
		$data = $this->manage_model->list_spots();
		$this->load->view('manage/list_spots.php',$data);
	}

	public function add_spot(){
		$this->load->view('manage/add_spot.php');
	}
	
	public function add_pics($time){
		$data['time'] = $time;
		$this->load->view('manage/add_pics.php',$data);
	}
	
	public function save_pics($time){
		if (is_readable('./././uploadfiles/pics/'.$time) == false) {
			mkdir('./././uploadfiles/pics/'.$time);
		}
		
		$path = './././uploadfiles/pics/'.$time;
		
		//设置缩小图片属性
		$config_small['image_library'] = 'gd2';
		$config_small['create_thumb'] = TRUE;
		$config_small['quality'] = 80;
		$config_small['maintain_ratio'] = TRUE; //保持图片比例
		$config_small['new_image'] = $path;
		$config_small['width'] = 800;
		$config_small['height'] = 600;
		
		//设置原图限制
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		//$config['max_size'] = '1000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload()){
			$data = $this->upload->data();//返回上传文件的所有相关信息的数组
			$config_small['source_image'] = $data['full_path']; //文件路径带文件名
			$this->image_lib->initialize($config_small);
			
			$this->image_lib->resize();

		}else{
			form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
			exit;
		}		
	}
	
	public function get_pics($time){
		$path = './././uploadfiles/pics/'.$time;
		$map = directory_map($path);
		$data = array();
		foreach($map as $v){
			if(substr($v,-9) == 'thumb.jpg'){
				$data['img'][] = $v;
			}
		}
		$data['time'] = $time;
		echo json_encode($data);
	}
	
	
	

	public function delete_spot($id){
		$rs = $this->manage_model->delete_cases($id);
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_spots", "", "");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function edit_cases($id){
		$data = $this->manage_model->get_cases($id);
		$this->load->view('manage/add_cases.php',$data);
	}

	public function save_cases(){
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/cases/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}

		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$data = $this->input->post();
			unset($data['ajax']);
			unset($data['old_img']);
			$rs = $this->manage_model->save_cases($data);
		}else{
			$config['upload_path'] = './././uploadfiles/cases';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$data = $this->input->post();
				$data['img'] = $img_info['file_name'];
				unset($data['ajax']);
				unset($data['old_img']);
				$rs = $this->manage_model->save_cases($data);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}

		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_spots");
		} else {
			form_submit_json("300", $rs);
		}
	}
}
