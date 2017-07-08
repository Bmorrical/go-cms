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
    
class GO_Login extends GO_Controller 
{

	public $ci;
	public $post;
	public $portal;

    /**
     *  Construct
     *  @param array | $_POST
     *  @param string | admin or home portal
     */    

	public function __construct($post, $portal = "home") {
		$this->ci = get_instance();
		$this->post = $post;
		$this->portal = $portal;
		$this->init_login();
	}	

	/**
	 *  Requires Documentation
	 */

	public function init_login() {
		switch ($this->portal) {
			case "home":
				$this->process_home_login();
				break;
			case "admin":
				$this->process_admin_login();
				break;
			default:
				redirect(base_url() . 'login', 'refresh'); // bad portal request
				break;
		}
	}

	/**
	 *  Process Home Login
	 */

	public function process_home_login() {

        $query = $this->ci->db
            ->select('ID, Firstname, Lastname, Username, Password, UserTypeID')
            ->where('Username', $this->post['username'])
            ->where('Status', 1)
            ->limit(1)           
            ->get('go_users');

        if($query->num_rows() == 1){ 

            $array = array();

            foreach($query->result() as $result) {
                $array[] = get_object_vars($result);
            }   

            if($this->post['password'] == $array[0]['Password']) {
                if($query->num_rows() > 0) {

                    $return = array();
                    foreach ($query->result() as $result) { $return[] = get_object_vars($result); }   

                    $this->ci->session->set_userdata(array(
                        'session_id' => session_id(),
                        'home' => array(
                            'session_type' => $return[0]['UserTypeID']
                        )
                    ));

                    $this->ci->db
                        ->where('ID', $array[0]['ID'])
                        ->update('clients', array('LastLogin' => date('Y-m-d H:i:s'))); 

                    redirect(base_url() . $this->ci->config->item('go_home_login_default_route')); // Good, login
                }
            } 
            else {
                redirect(base_url() . 'login', 'refresh'); // bad password
            }
        } 
        else {
            redirect(base_url() . 'login', 'refresh'); // no such user
        }
    }

	/**
	 *  Process Admin Login
	 */

	public function process_admin_login() {

        $query = $this->ci->db
            ->select('ID, Firstname, Lastname, Username, Password, UserTypeID')
            ->where('Username', $this->post['username'])
            ->group_start()
                ->where('UserTypeID', 1)
                ->or_where('UserTypeID', 2)
            ->group_end()
            ->where('Status', 1)
            ->limit(1)            
            ->get('go_users');

        if($query->num_rows() == 1){ 

            $array = array();
            foreach($query->result() as $result) {
                $array[] = get_object_vars($result);
            }   

            if(password_verify($this->post['password'], $array[0]['Password'])) {

                $this->ci->session->set_userdata(array(
                    'session_id' => session_id(),   
                    'admin' => array(
	                    'logged_in' => true,
	                    'user_id' => $array[0]['ID'],
	                    'name' => $array[0]['Firstname'] . " " . $array[0]['Lastname'],
	                    'user_type' => $array[0]['UserTypeID']
                    ),    
                    // codebase should be refactored with extra "admin" key in sessions array above
                    // leaving lower for now as not to break login
                    // also update GO_Controller::logout();
                    'logged_in' => true,
                    'user_id' => $array[0]['ID'],
                    'name' => $array[0]['Firstname'] . " " . $array[0]['Lastname'],
                    'user_type' => $array[0]['UserTypeID']
                ));

                $TS = date('Y-m-d H:i:s'); 
                $vars = array(
                    'LastLogin' => $TS
                );
                $this->ci->db
                    ->where('ID', $array[0]['ID'])
                    ->update('go_users', $vars); 

                redirect($this->ci->config->item('go_admin_login_default_route'), 'refresh');
            } 
            else {
                redirect(base_url() . 'login?go=' . $this->ci->config->item('go_login_key'));
            }
        } 
        else {
            redirect(base_url() . 'login?go=' . $this->ci->config->item('go_login_key'));
        }
	}
}