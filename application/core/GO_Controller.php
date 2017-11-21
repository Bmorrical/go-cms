<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan to
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

class GO_Controller extends CI_Controller 
{

	/**
	 *  Construct
	 */ 

	public function __construct() {
		parent::__construct();

		$this->config->load('go_config');
		$this->load->helper('url');
		$this->load->model('go_admin_model','admin');

		require_once(APPPATH . 'go_inc/helpers/helper__functions.php');
		require_once(APPPATH . 'go_inc/helpers/helper__go_functions.php');
		require_once(APPPATH . 'go_inc/classes/class__go_login.php');		
		require_once(APPPATH . 'go_inc/classes/class__go_lab.php');
		require_once(APPPATH . 'go_inc/classes/class__go_postal.php');		

	}

	/**
	 *  Process page requests, handle html meta-data, load template
	 *  @param $params array
	 */

	public function go_load_page($params = array()) {

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

		/** Detect if user is already signed in **/

		if(
			!empty($_SESSION['admin']['hash']) &&
			$this->input->cookie("go-admin-hash") === $_SESSION['admin']['hash']) 
		{ 
			redirect($this->config->item("go_admin_login_default_route"), 'refresh');
		}

		/** Not signed in **/

		else if(
			$this->input->get('go') == $this->config->item('go_login_key') || // used the ?go={key} param in the URL string
			$this->input->cookie("go-vetted-" . md5($this->config->item('go_admin_login_cookie'))) // had already signed in previously
		){
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
		} 

		/** No Authorization **/
		
		else {
			show_404();
		}
	}	

	/**
	 *  Logout User
	 */

	public function logout() {

		// if(!empty($_SESSION['admin'])) {
		// needs some more work here
		// }
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

		public function dashboard() {

			go_verify_user_session("admin");

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
		 *  User Page
		 *  Only accessible to Super Admins user status
		 */

		public function users() {

			go_verify_user_session("admin");

			/** Deny access if not Super Admin */			
			if($_SESSION['admin']['session_type'] != 1) show_404();		

			if(($_POST && isset($_POST['menu_activate_inactivate']))) $this->admin->users_activate_inactivate($_POST);  // Toggle Active/Inactive


			$queries = array(
				'users' => $this->admin->go_get_users($this->admin->users_page_id())
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
		 *  User Edit Page
		 */

		public function user_edit() {

			go_verify_user_session("admin");

			/** Admin User can only load their own account for editing */

			if( $_SESSION['admin']['session_type'] != 1 && 
			    $this->input->get('id') != $_SESSION['admin']['session_type'] ) show_404();

			/** Request for User Update */

			if($_POST) $this->admin->put_user($_POST); 

			/** If the user is Super Admin, we will honor the GET param for user ID */

			if($_SESSION['admin']['session_type'] == 1) {

				/** If Super Admin is editing, make sure they can't access and edit page where a user does not exist */

				$query = $this->db
					->select('ID')
					->where('ID', $this->input->get('id'))
					->limit(1)
					->get('go_users');

				if(!$query->row()) show_404();

				/** All checks are passed, process user load request */

				$queries = array(
					'user' => (array)$this->admin->go_get_user($this->input->get('id'))
				);	

			} else {

				$queries = array(
					'user' => (array)$this->admin->go_get_user($_SESSION['admin']['user_id'])
				);		

			}


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
		 *  User Add Page
		 */

		public function user_add() {

			/** Deny access if not Super Admin */
			if($_SESSION['admin']['session_type'] != 1) show_404();

			go_verify_user_session("admin");

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
		 *  When updating Active/Inactive menu from Users page
		 */

		public function ajax_users_update_display_status() {
			echo json_encode($this->admin->ajax_users_update_display_status($this->input->post()));
		}		

		/**
		 *  Requires Documentation
		 */

		public function put_user() {
			go_verify_user_session("admin");	
			$this->admin->put_user($_POST);
		}

	// End Users
	// Start Go Lab()

		/**
		 *  Requires Documentation
		 */

		public function lab() {

			go_verify_user_session("admin");

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

			go_verify_user_session("admin");

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
		redirect($this->config->item('go_redirect_url'), 'refresh'); // home route from application/config/go_config.php 
	}

	/**
	 *  This is the slug router function to load the pages of the website.
	 *  If you do not use dynamic Pages, then you should have a partial with a filename
	 *  that matches the route in application/views/home/partials
	 */

	public function page($route) {

        $query = $this->db
            ->select('MetaTitle')
            ->where('Status', 1)
            ->where('Slug', $route)
            ->limit(1)
            ->get('go_pages');

        $row = $query->row();

        if(!$row) $page = 'home/partials/' . $route; /** Is a partial */
        else $page = 'home/go_router'; /** Is dynamic content from router */

        $route_string = str_replace("-", " ", $route);

        $meta_title = (!empty($row->MetaTitle)) ? $row->MetaTitle : ucwords($route_string);

		$this->load->model('home_model','home');

		$this->go_load_page(
			array(
				'page' => $page,
				'title' => $meta_title,
				'template' => 'home',
				'activeClass' => '$route',
				'queries' => $this->home->queries($route)
			)
		);		
	}

}
