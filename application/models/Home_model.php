<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends GO_Home_model {

	public function __construct(){
		parent::__construct();
	}

	public function logout() {
		$this->db->where('SessionID', $this->session->userdata('session_id'));
		$this->db->delete('cart');				
		unset($_SESSION['home']);
		redirect(base_url() . 'login', 'refresh');
	}

}