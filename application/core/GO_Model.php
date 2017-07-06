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