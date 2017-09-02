<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends GO_Admin_Controller { 

	/**
	 *  Any methods for Core Admin (GO Methods) should go in core/GO_Controller.php
	 *
	 *  This file allows us to use /admin in the URL
	 */

	public function __construct(){
		parent::__construct();
	}
	

}