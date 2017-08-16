<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends GO_Home_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model','home');
	}

}