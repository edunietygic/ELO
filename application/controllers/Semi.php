<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

		define("HOSTURL", 'http://localhost/~sseog');

		$this->load->library('session');
    }

    public function Main()
    {
		if( !$this->_isLogin() )
		{
			header('Location: '.HOSTURL.'/ELO/Semi/LocalLogin');
		}

    	$this->load->view('semi_main');
    }

	public function LocalLogin()
	{
		if( $this->_isLogin() )
		{
			header('Location: '.HOSTURL.'/ELO/Semi/Main');
		}

		$this->load->view('semi');
	}

	private function _isLogin()
	{
		if(!$this->session->userdata('ss_mb_id'))
			return false;

		return true;
	}

	public function RpcLogin()
	{
		$mb_id = $this->input->post('mb_id');
		$mb_pw = $this->input->post('mb_pw');

		// test code
		// $mb_id = 'sseog818';
		// $mb_pw = 'test';

		if( !$mb_id || !$mb_pw )
		{
			$rtn = array('code'=>'990', 'msg'=>'Login Error');
			response_json($rtn);
        	die;
		}

		if( $this->_loginProcess($mb_id) )
			$rtn = array('code'=>'1', 'msg'=>'OK');
		else
			$rtn = array('code'=>'999', 'msg'=>'Login Fail');

        response_json($rtn);
        die;
	}

	public function RpcLogout()
	{
		$this->session->sess_destroy();

		if($this->session->userdata('ss_mb_id'))
			$rtn = array('code'=>'1', 'msg'=>'OK');
		else
			$rtn = array('code'=>'999', 'msg'=>'Logout Fail');

        response_json($rtn);
        die;
	}


	private function _loginProcess($mb_id)
	{
		$this->load->model('semi_model');

		if( $this->semi_model->isMember($mb_id) )
			return $mb_id;

		return false;
	}

}
