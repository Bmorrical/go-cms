<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends GO_Home_model {

	public function __construct(){
		parent::__construct();
	}

	/**
	 *  This function fires in home login process, so that additional application 
	 *  specific logic can be injected at login runtime.
	 */
	public function login_helper($post = false) {
		return false;
	}

	/**
	 *  Home Logout
	 */
	public function logout() {			
		unset($_SESSION['home']);
		redirect(base_url() . 'login', 'refresh');
	}
}