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
		require_once(APPPATH . 'go_inc/classes/class__go_postman.php');		

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
	public function go_verify_user_session() {
		if(!$this->session->has_userdata('logged_in')) {
			show_404();
		}

		// switch($route) {
		// 	case 1: // admin
		// 		break;
		// 	case 2: // home
		// 		$session_vars = $this->session->userdata('home');
		// 		if(!isset($session_vars['client_logged_in']) && $session_vars['client_logged_in'] != true) header('Location:' . base_url());
		// 		break;
		// }
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

	// Start Login/Logout

		/**
		 *  Login User
		 */

		public function login() {
			if($this->input->get('go') == $this->config->item('go_login_key')) {
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
				redirect($this->config->item('redirect_url'), 'refresh');
			}
		}	

		/**
		 *  Logout User
		 */

		public function logout() {
			$this->session->unset_userdata('admin');
            // codebase should be refactored with extra "admin" key in sessions array above and in go_login.php
            // leaving lower for now as not to break login 			
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('name');
			$this->session->unset_userdata('user_type');
			$this->session->unset_userdata('menu_item_id');
			$this->session->unset_userdata('display_status');
			if($this->input->get('go') == $this->config->item('go_login_key')) {
				redirect(base_url() . 'admin/login?go=' . $this->config->item('go_login_key'), 'refresh');
			} else {
				show_404();
			}
		}

	// End Login/Logout
	// Start Dashboard

		/**
		 *  Requires Documentation
		 */

		public function dashboard() 
		{
			$this->go_verify_user_session();
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
	 */

	public function index() {	
		$data = array();
		$this->go_load_page(array('page'=>'home/homepage','title'=>'The Homepage','template'=>'home','activeClass'=>'homepage','data'=>$data));	
	}

}
