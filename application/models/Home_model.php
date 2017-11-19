<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends GO_Home_model {

	public function __construct(){
		parent::__construct();
	}

    /**
     *  This function fires in ADMIN login process, so that additional application 
     *  specific logic can be injected at login runtime.
     */
    public function admin_login_helper($user, $post) {
		return;
	}

    /**
     *  Data queries for page load, any datasets for which you want to return result sets
     *  should have a matching route below and your requested data
     *
     *  @return array
     */
    public function queries($route) {
        switch ($route) {
            case 'home':
                return array(
                    'data' => "None Today!"
                );
                break;
            default:
                return array();
                break;
        }
    }	

	/**
	 *  Home Logout
	 */
	public function logout() {			
		unset($_SESSION['home']);
		redirect(base_url() . 'login', 'refresh');
	}

}