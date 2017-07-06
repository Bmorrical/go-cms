<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

class GO_model extends CI_Model 
{

    /**
     *  Construct
     */ 

    public function __construct(){
        parent::__construct();
    }
    
}

class GO_Admin_model extends GO_model 
{ 

    /**
     *  Construct
     */ 

    public function __construct(){
        parent::__construct();
    }    
    

    /**
     *  Requires Documentation
     */

    public function post_user($post) {

        $query = $this->db
            ->select('ID')
            ->where('Username', $post['username'])
            ->get('go_users');        

        if($query->num_rows() > 0) {
            $this->session->set_flashdata('flashWarning', 'Username is already in use.  Please try again.');
                redirect(base_url() . 'admin/user/add?firstname=' . $post['firstname'] . '&lastname=' . $post['lastname']);
        } else {

            $params = array(
                'Username'  => $post['username'],
                'Firstname' => $post['firstname'],
                'Lastname'  => $post['lastname'],
                'Type'      => 1,
                'Status'    => 1,
                'Created'   => date('Y-m-d H:i:s'),
                'Updated'   => date('Y-m-d H:i:s')
            );

            if($post['password'] != "" || $post['verify-password'] != "") {
                if($post['password'] === $post['verify-password']) {
                    $params['Password'] = password_hash($post['password'], PASSWORD_BCRYPT);
                } else {
                    $this->session->set_flashdata('flashWarning', 'Passwords do not match.  Please try again.');
                    redirect(base_url() . 'admin/user/add?username=' . $post['username'] . '&firstname=' . $post['firstname'] . '&lastname=' . $post['lastname']);
                }
            }

            $this->db->insert('go_users', $params);

            $this->session->set_flashdata('flashSuccess', 'User: ' . $post['username'] . '<br /><br />Record has been successfully created.');

            if(array_key_exists('save', $post)) {
                redirect(base_url() . 'admin/user/edit?id=' . $this->db->insert_id());
            }
            if(array_key_exists('save-and-new', $post)) {
                redirect(base_url() . 'admin/user/add');
            }
            if(array_key_exists('save-and-close', $post)) {
                redirect(base_url() . 'admin/users');
            }     
        }
    }            

    /**
     *  Requires Documentation
     */

    public function go_get_users() {
        $return = array();
        $return['rows'] = array();

        $query = $this->db
            ->select('ID, Username, Firstname, Lastname, Status, LastLogin')
            ->where('UserTypeID', 1)
            ->or_where('UserTypeID', 2)
            ->get('go_users');   

            foreach($query->result() as $result) {
                $return['rows'][$result->ID] = get_object_vars($result);
            }

     return $return;
    }

    /**
     *  Requires Documentation
     */

    public function go_get_user($id) {
        $return = array();
        $query = $this->db
            ->select('ID, Username, Firstname, Lastname')
            ->where('ID', $id)
            ->get('go_users');   

            foreach($query->result() as $result) {
                $return[] = get_object_vars($result);
            }

     return $return;
    }

    /**
     *  Requires Documentation
     */

    public function put_user($post) {
       
        $params = array(
            'Username'  => $post['username'],
            'Firstname' => $post['firstname'],
            'Lastname'  => $post['lastname'],
            'Updated'   => date('Y-m-d H:i:s')
        );

        if($post['password'] != "" || $post['verify-password'] != "") {
            if($post['password'] === $post['verify-password']) {
                $params['Password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            } else {
                // passwords don't match
            }
        }

        $this->db->where('ID', $this->input->get('id'));
        $this->db->update('go_users', $params);

        $this->session->set_flashdata('flashSuccess', 'User: ' . $post['username'] . '<br /><br />Record has been successfully updated.');

        if(array_key_exists('save', $post)) {
            redirect(base_url() . 'admin/user/edit?id=' . $this->input->get('id'));
        }
        if(array_key_exists('save-and-new', $post)) {
            redirect(base_url() . 'admin/user/add');
        }
        if(array_key_exists('save-and-close', $post)) {
            redirect(base_url() . 'admin/users');
        }       

    }    

    /**
     *  Requires Documentation
     */

    public function verify_login($post, $admin) {

        if($admin == 1) { // admin area login

            $query = $this->db
                ->select('ID, Firstname, Lastname, Username, Password, UserTypeID')
                ->where('Username', $post['username'])
                ->group_start()
                    ->where('UserTypeID', 1)
                    ->or_where('UserTypeID', 2)
                ->group_end()
                ->where('Status', 1)            
                ->get('go_users');

            if($query->num_rows() == 1){ 

                $array = array();

                foreach($query->result() as $result) {
                    $array[] = get_object_vars($result);
                }   

                if(password_verify($post['password'], $array[0]['Password'])) {
                    $this->session->set_userdata(array(
                        'session_id' => session_id(),                        
                        'logged_in' => true,
                        'user_id'   => $array[0]['ID'],
                        'name'      => $array[0]['Firstname'] . " " . $array[0]['Lastname'],
                        'user_type' => $array[0]['UserTypeID']
                    ));

                    $TS = date('Y-m-d H:i:s'); 
                    $vars = array(
                        'LastLogin' => $TS
                    );
                    $this->db
                        ->where('ID', $array[0]['ID'])
                        ->update('go_users', $vars); 

                    redirect($this->config->item('go_admin_login_default_route'), 'refresh');
                } else {
                    redirect(base_url() . 'login?go=' . $this->config->item('go_login_key'));
                }
            } else {
                redirect(base_url() . 'login?go=' . $this->config->item('go_login_key'));
            }
        } else { // non-admin area login

            $query = $this->db
                ->select('ID, FirstName, LastName, UserName, Password, Address, Address_2, City, State, Zip, Phone, Email')
                ->where('Username', $post['username'])
                ->where('Status', 1)
                ->limit(1)           
                ->get('clients');

            if($query->num_rows() == 1){ 

                $array = array();

                foreach($query->result() as $result) {
                    $array[] = get_object_vars($result);
                }   

                if($post['password'] == $array[0]['Password']) {

                    // query to see if they have any sessions available to view  
                        $query = $this->db
                            ->select('ID, UserTypeID')
                            ->where('ClientID', $array[0]['ID'])
                            ->where('Status', 1)
                            ->group_start()
                                ->where('LoginExpiration >= CURDATE()')
                                ->or_where('LoginExpiration IS NULL')
                            ->group_end()
                            ->order_by('SessionDate', 'desc')
                            ->get('photo_sessions');

                        if($query->num_rows() > 0) {

                            $return = array();
                            foreach ($query->result() as $result) { $return[] = get_object_vars($result); }   

                            $this->session->set_userdata(array(
                                'session_id' => session_id(),
                                'home' => array(
                                    'current_photo_session' => $return[0]['ID'],   // set session variable to latest session on login, for use in sessions drop down
                                    'client_logged_in' => true,
                                    'client_id'        => $array[0]['ID'],
                                    'continue_clicked' => '0',                              
                                    'payment_option'   => '0',
                                    'shipping_option'  => '0',
                                    'first_name'       => $array[0]['FirstName'],
                                    'last_name'        => $array[0]['LastName'],
                                    'address'          => $array[0]['Address'],
                                    'address_2'        => $array[0]['Address_2'],
                                    'city'             => $array[0]['City'],
                                    'state'            => $array[0]['State'],
                                    'zip'              => $array[0]['Zip'],
                                    'phone'            => $array[0]['Phone'],
                                    'email'            => $array[0]['Email'],
                                    'session_type'     => $return[0]['UserTypeID']
                                )
                            ));

                            $this->db
                                ->where('ID', $array[0]['ID'])
                                ->update('clients', array('LastLogin' => date('Y-m-d H:i:s'))); 

                            redirect(base_url() . $this->config->item('go_home_login_default_route')); // Good, login                            

                        } else {
                            redirect(base_url() . 'login', 'refresh'); // no photo sessions
                        }                    
                } else {
                    redirect(base_url() . 'login', 'refresh'); // bad password
                }
            } else {
                redirect(base_url() . 'login', 'refresh'); // no such user
            }
        }
    }    

    /**
     *  Requires Documentation
     */

    public function lab_get_menus() {
        $return = array();
        $query = $this->db
            ->select('MenuID, MenuName')
            ->where('Status', 1)
            ->get('go_menus');

        foreach ($query->result() as $result) {
            $return[] = get_object_vars($result);
        }

        return $return;
    }    

}

class GO_Home_model extends GO_model 
{ 

    /**
     *  Construct
     */ 

    public function __construct(){
        parent::__construct();
    }    
}