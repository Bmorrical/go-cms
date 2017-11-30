<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends GO_Home_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model','home');
	}


	/**
	 *  Home Logout
	 */
	public function logout() {			
		unset($_SESSION['home']);
		redirect(base_url() . 'login', 'refresh');
	}

}