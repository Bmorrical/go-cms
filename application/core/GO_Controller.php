<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////
	/**
	 *  Requires Documentation to
	 *  ever update your go-cms version.  Changes would be lost.
	 */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

class GO_Controller extends CI_Controller 
{

	/**
	 *  Construct
	 */ 

	public function __construct()
	{
		parent::__construct();

		$this->config->load('go_config');
		$this->load->helper('url');
		$this->load->model('go_admin_model','admin');

		require_once(APPPATH . 'go_inc/helpers/helper__functions.php');
		require_once(APPPATH . 'go_inc/classes/class__go_login.php');		
		require_once(APPPATH . 'go_inc/classes/class__go_lab.php');
		require_once(APPPATH . 'go_inc/classes/class__go_postal.php');		

	}

	/**
	 *  Process page requests, handle html meta-data, load template
	 *  @param $params array
	 */

	public function go_load_page($params = array()) 
	{

	    if(!isset($params["page"]) || $params["page"] == "") { 
	        show_404(); 
	        return; 
	    }

	    if(!isset($params["title"]) || $params["title"] == "") { 
	        $params["title"] = ucfirst("(Untitled)"); 
	    }

	    if(!isset($params["queries"])) { 
	        $params["queries"] = null; 
	    }

	    if($params["activeClass"] != "") {
	        $this->session->set_userdata("menu_active_class", $params["activeClass"]);
	    }

	    if(!file_exists(APPPATH . "views/" . $params["page"] . ".php")) { 
	        show_404(); 
	        return; 
	    }

	    $this->load->view("templates/" . $params["template"] . "/template",$params);

	}   


	/**
	 *  Requires Update - When front end is added to go-cms.
	 */
	public function go_verify_user_session($route = "admin") {

		switch($route) {
			case 1: // admin
				if(!$_SESSION['admin']) {
					if($this->input->cookie("go-cms")) $this->login(); // has a cookie, new the ?go=key within cookie expiration
					else show_404();
				} 
			break;
			case 2: // home
				if(!$_SESSION['home']) $this->login();
			break;
		}
	}	

	/**
	 *  Login User
	 */

	public function sign_in() {
		if ($this->session->userdata('session_id')) $this->logout(); // user had a session, just log them out and start over
		if (!empty($_POST)) new GO_Login($_POST, "home");
		else $this->go_load_page(
			array(
				'page' => 'home/login',
				'title' => 'Login',
				'template' => 'home',
				'activeClass' => 'sign-in',
				'queries' => null
			)
		);		
	}

	public function login() {
		if ($this->session->userdata('session_id')) $this->logout(); // user had a session, just log them out and start over
		if($this->input->cookie("go-cms") || ($this->input->get('go') == $this->config->item('go_login_key'))) {
			if (!empty($_POST)) {
				new GO_Login($_POST, "admin");
			} else {
				$queries = null;
				$this->go_load_page(
					array(
						'page' => 'admin/go/login',
						'title' => 'Login',
						'template' => 'admin',
						'activeClass' => 'dashboard',
						'queries' => $queries
					)
				);
			}
		} else {
			show_404();
		}
	}	

	/**
	 *  Logout User
	 */

	public function logout() {

		$_SESSION = array();
		session_destroy();

		if($this->input->get('go') == $this->config->item('go_login_key')) {
			redirect(base_url() . 'admin/login?go=' . $this->config->item('go_login_key'), 'refresh');
		} else {
			redirect(base_url() . 'login', 'refresh');
		}

	}

}

class GO_Admin_Controller extends GO_Controller 
{ 

	/**
	 *  Construct
	 */ 

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Requires Documentation
	 */

	public function index() {
		redirect($this->config->item("go_admin_login_default_route"), 'refresh');
	}


	// End Login/Logout
	// Start Dashboard

		/**
		 *  Requires Documentation
		 */

		public function dashboard() 
		{
			$this->go_verify_user_session("home");
			$queries = null;
			$this->go_load_page(
				array(
					'page' => 'admin/go/dashboard',
					'title' => 'Dashboard' ,
					'template' => 'admin',
					'activeClass' => 'dashboard',
					'queries' => $queries
				)
			);
		}

	// End Dashboard
	// Start Users

		/**
		 *  Requires Documentation
		 */

		public function users() {
			$this->go_verify_user_session();
			$queries = array(
				'users' => $this->admin->go_get_users()
			);	
			$this->go_load_page(
				array(
					'page' => 'admin/go/users/users',
					'title'=> 'Users',
					'template' => 'admin',
					'activeClass' => 'users',
					'queries' => $queries
				)
			);
		}

		/**
		 *  Requires Documentation
		 */

		public function user_edit() {
			$this->go_verify_user_session();
			if($_POST) {
				$this->admin->put_user($_POST); 
			}
			$queries = array(
				'user' => $this->admin->go_get_user($this->input->get('id'))
			);	
			$this->go_load_page(
				array(
					'page' => 'admin/go/users/edit',
					'title' => 'Edit User',
					'template' => 'admin',
					'activeClass' => 'users',
					'queries' => $queries
				)
			);
		}

		/**
		 *  Requires Documentation
		 */

		public function user_add() {
			$this->go_verify_user_session();
			$queries = null;
			if($_POST) {
				$this->admin->post_user($_POST);
			} 
			$this->go_load_page(
				array(
					'page' => 'admin/go/users/add',
					'title' => 'Add User',
					'template' => 'admin',
					'activeClass' => 'users',
					'queries' => $queries
				)
			);
		}

		/**
		 *  Requires Documentation
		 */

		public function put_user() {
			$this->go_verify_user_session();		
			$this->admin->put_user($_POST);
		}

	// End Users
	// Start Go Lab

		/**
		 *  Requires Documentation
		 */

		public function lab() {
			$this->go_verify_user_session();
			if($_POST) { 		
				new GO_Lab($this->input->post());
			}
			$queries = array(
					'menus' => $this->admin->lab_get_menus()
				);
			$this->go_load_page(
				array(
					'page' => 'admin/go/lab/lab',
					'title' => 'CRUD Lab',
					'template' => 'admin',
					'activeClass' => 'lab',
					'queries' => $queries
				)
			);		
		}

	// End Go Lab
	// Start Config

		/**
		 *  Requires Documentation
		 */

		public function config() {

			$this->go_verify_user_session();
			$queries = array(
	          'currentVersion' => $this->admin->go_get_version(),
	        );

			$this->go_load_page(
				array(
					'page' => 'admin/go/config/config',
					'title' => 'Configuration',
					'template' => 'admin',
					'activeClass' => 'config',
					'queries' => $queries
				)
			);		
		}

		/**
		 *  Controller call to model when updating go-cms core
		 */

		public function ajax_go_update() {
			echo json_encode($this->admin->go_update($this->input->post()));
		}

	// End Config


}

class GO_Home_Controller extends GO_Controller 
{

    /**
     *  Construct
     */ 

	public function __construct(){
		parent::__construct();
	}

	/**
	 *  This is the homepage router function to load the base of the website.
	 *  By default you are taken to /login for request of /index.  This can be overridden in go_config.php param go_redirect_url
	 */

	public function index() {
		if(null != $this->config->item('go_redirect_url')) redirect($this->config->item('go_redirect_url'), 'refresh');
		else $this->sign_in();
	}

	// public function home_login() {
	// 	$this->login();
	// }

}
