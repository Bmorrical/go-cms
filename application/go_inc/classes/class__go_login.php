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
        $this->ci->load->helper('cookie');
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

        /**
         *  This function is found in Home_model.php and offers a place to inject a custom process into the login 
         *  or a place to return additional meta-data about the logged in user.
         *
         *  You can also override the rest of the login process as custom, by simply finishing the login process 
         *  in login_helper().
         */

            $helper_data = $this->ci->home->login_helper($this->post);   

        /** End Helper */      

        $query = $this->ci->db
            ->select('*')
            ->where('Username', $this->post['username'])
            ->where('Status', 1)
            ->limit(1)           
            ->get('go_users');

        $user = $query->row();

        if($user) {

            if(password_verify($this->post['password'], $user->Password)) {

                $this->ci->session->set_userdata(array(
                    'session_id' => session_id(),
                    'home' => array(
                        'user_id' => $user->ID,
                        'session_type' => $user->UserTypeID,
                        'first_name' => $user->Firstname,
                        'last_name' => $user->Lastname,
                        'user_type' => $user->UserTypeID,
                        'created' => $user->Created,
                        'updated' => $user->Updated,
                        'last_login' => $user->LastLogin,
                        'hash' => md5(uniqid(rand(), true)) // some random hash that we can refer to
                    )    
                ));

                /**
                *  Set session cookie, which allows us to run front-end and back-end
                *  go-cms user sessions in the same browser on one php session
                */

                    $this->ci->input->set_cookie(
                        "go-home-hash", 
                        $_SESSION['home']['hash'], 
                        60*60*24*7 // 1 week, needs to be a config, but will be terminated by SESSION length anyways
                    );                


                /** Update users table with login meta-data */

                    $TS = date('Y-m-d H:i:s'); 
                    $vars = array(
                        'LastLogin' => $TS
                    );

                    $this->ci->db
                        ->where('ID', $user->ID)
                        ->update('go_users', $vars); 


                redirect(base_url() . $this->ci->config->item('go_home_login_default_route')); // Good, login

            } else {
                redirect(base_url() . 'login', 'refresh'); // bad password
            }
        } else {
            redirect(base_url() . 'login', 'refresh'); // no such user
        }

    }

    /**
     *  Process Admin Login
     */

    public function process_admin_login() {

        $query = $this->ci->db
            ->select('*')
            ->where('Username', $this->post['username'])
            ->group_start()
                ->where('UserTypeID', 1)
                ->or_where('UserTypeID', 2)
            ->group_end()
            ->where('Status', 1)
            ->limit(1)            
            ->get('go_users');

        $user = $query->row();

        if($user) {

            /**
             *  This function is found in Home_model.php and offers a place to inject a custom process into the login 
             *  or a place to return additional meta-data about the logged in user.
             *
             *  You can also override the rest of the login process as custom, by simply finishing the login process 
             *  in login_helper().
             */

                // On hold, can't get admin to hook to go_model, works ok for Home
                    // $helper_data = $this->ci->admin->login_helper($user, $this->post);   

            /** End Helper */              

            if(password_verify($this->post['password'], $user->Password)) {

                $this->ci->session->set_userdata(array(
                    'session_id' => session_id(),
                    'admin' => array(
                        'user_id' => $user->ID,
                        'session_type' => $user->UserTypeID,
                        'first_name' => $user->Firstname,
                        'last_name' => $user->Lastname,
                        'user_type' => $user->UserTypeID,
                        'created' => $user->Created,
                        'updated' => $user->Updated,
                        'last_login' => $user->LastLogin,
                        'hash' => md5(uniqid(rand(), true)) // some random hash that we can refer to
                    )    
                ));


                /**
                *  Set session cookie, which allows us to run front-end and back-end
                *  go-cms user sessions in the same browser on one php session
                */

                    $this->ci->input->set_cookie(
                        "go-admin-hash", 
                        $_SESSION['admin']['hash'], 
                        60*60*24*7 // 1 week, needs to be a config
                    );                


                /** Update users table with login meta-data */

                    $TS = date('Y-m-d H:i:s'); 
                    $vars = array(
                        'LastLogin' => $TS
                    );

                    $this->ci->db
                        ->where('ID', $user->ID)
                        ->update('go_users', $vars); 


                /**
                 *  Set a cookie here so that we can refer back if someone has known the ?go=key at some point
                 *  within the last 7 days, take them to the login page instead of show_404();
                 */

                    /** Setting is on in application/config/go_config.php */

                        if(!empty($this->ci->config->item('go_admin_login_cookie'))) {

                                $this->ci->input->set_cookie(
                                    "go-vetted-" . md5($this->ci->config->item('go_admin_login_cookie')), 
                                    rand() * rand(), // nothing here, just random value
                                    60*60*24*7*35 // 35 days, needs to be a config
                                );
                        }  

                redirect($this->ci->config->item('go_admin_login_default_route'), 'refresh');
            } 
            else {
                redirect(base_url() . 'admin/login?go=' . $this->ci->config->item('go_login_key'));
            }
        } 
        else {
            redirect(base_url() . 'admin/login?go=' . $this->ci->config->item('go_login_key'));
        }
    }
}