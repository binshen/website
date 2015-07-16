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
			return call_user_func_array(array($this, $method), $params);
		}
	}

	public function index()
	{
		$this->load->view('manage/index.php');
	}

	/**
	 *
	 * ***************************************yaobin*******************************************************************
	 */
	public function list_new_house(){
		$this->load->view('manage/list_new_house.php');
	}
	
	public function add_new_house(){
		$this->load->view('manage/add_new_house.php');
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
		$config_small['width'] = 801;
		$config_small['height'] = 470;
	
		//设置原图限制
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
	
		if($this->upload->do_upload()){
			$data = $this->upload->data();//返回上传文件的所有相关信息的数组
			$config_small['source_image'] = $data['full_path']; //文件路径带文件名
			$this->image_lib->initialize($config_small);
			$this->image_lib->resize();
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
			exit;
		}
	}
	

	
	//ajax获取图片信息
	public function get_pics($time){
		$path = './././uploadfiles/pics/'.$time;
		$map = directory_map($path);
		$data = array();
		//整理图片名字，取缩略图片
		foreach($map as $v){
			if(substr(substr($v,0,strrpos($v,'.')),-5) == 'thumb'){
				$data['img'][] = $v;
			}
		}
		$data['time'] = $time;//文件夹名称
		echo json_encode($data);
	}
	
	//ajax删除图片
	public function del_pic($folder,$pic,$id=null){
		$data = $this->manage_model->del_pic($folder,$pic,$id);
		echo json_encode($data);
	}
	
	//清理不使用的图片数据
	public function clear_pics(){
		$rs = $this->manage_model->clear_pics();
		if($rs === 1){
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $rs);
		}
	}
	

	/**
	 *
	 * ***************************************shenbin*******************************************************************
	 */
	public function list_broker() {
		$data = $this->manage_model->list_broker();
		$this->load->view('manage/list_broker.php', $data);
	}
	
	public function add_broker() {
		$this->load->view('manage/add_broker.php');
	}
	
	public function save_broker() {
		$this->manage_model->save_broker();
	}
	
	public function edit_broker($id) {
		$data = $this->manage_model->get_broker($id);
		$this->load->view('manage/add_broker.php', $data);
	}
}
