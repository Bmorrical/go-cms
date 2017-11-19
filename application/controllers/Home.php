<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends GO_Home_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model','home');
	}

    /**
     *  This function fires in HOME login process, so that additional application 
     *  specific logic can be injected at login runtime.
     */
	public function home_login_helper($data) {

	}

	public function logout() {			
		if(!empty($_SESSION['home'])) unset($_SESSION['home']);
		redirect(base_url() . 'login', 'refresh');
	}

}