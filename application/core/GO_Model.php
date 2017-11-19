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
                'UserTypeID' => 2,
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

            $this->session->set_flashdata('flashSuccess', 'Record has been successfully created.');

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
     *  Returns the row of the Users Menu, so it can be matched in Active/Inactive cookie toggle on Users Page
     */

    public function users_page_id() {

        $query = $this->db
            ->select('MenuItemID')
            ->where('MenuItemUrl', 'admin/users')
            ->limit(1)
            ->get('go_menu_items');   

        $row = $query->row();
        
        return $row->MenuItemID;

    }

    public function ajax_users_update_display_status($post) {

        $this->input->set_cookie(
            "go-menu-" . $this->admin->users_page_id() . "-" . md5($this->config->item('go_admin_login_cookie')), 
            $post['NewValue'], // New Value
            60*60*24*7*35 // 35 days, needs to be a config
        );
    }

    /**
     *  Query for Users on Admin/Users page
     */

    public function go_get_users($users_page_id) {

        $return = array();
        $return['rows'] = array();

        /**
         *  If there is no cookie for menu preference, set one to Active.  
         */
        if (is_null($this->input->cookie("go-menu-" . $users_page_id . "-" . md5($this->config->item('go_admin_login_cookie'))))) {
            $this->input->set_cookie(
                "go-menu-" . $users_page_id . "-" . md5($this->config->item('go_admin_login_cookie')), 
                1, // New Value
                60*60*24*7*35 // 35 days, needs to be a config
            );
            $status = 1;
        } else {
            $status = $this->input->cookie("go-menu-" . $users_page_id . "-" . md5($this->config->item('go_admin_login_cookie')));
        }


        $query = $this->db
            ->select('u.*, ut.UserType')
            ->join('go_user_types ut', 'ut.UserTypeID = u.UserTypeID')
            ->where('u.Status', $status)
            ->get('go_users u');   

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
                $this->session->set_flashdata('flashWarning', 'Passwords do not match.  Please try again.');
                redirect(base_url() . 'admin/user/add?username=' . $post['username'] . '&firstname=' . $post['firstname'] . '&lastname=' . $post['lastname']);
            }
        }

        $this->db->where('ID', $this->input->get('id'));
        $this->db->update('go_users', $params);

        $this->session->set_flashdata('flashSuccess', 'Record has been successfully updated.');

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

    /*
    *
    * Get Current Version of Go CMS Version
    *
    * @return $currentVersion
    *
    */

    public function go_get_version(){

        $result = $this->db
            ->select()
            ->where('ID', 1)
            ->get('go_version');

        return $result->row();
    }

    /**
     *  Update the go-cms core
     */

    public function go_update($post) {

        $latest_version = (float)$post["latest_version"];

        foreach($post["files"] as $file) {

            $file = preg_replace("/\r|\n/", "", $file);

            // Read

            $the_file = "https://api.go-cms.org/request/get-file?file=" . urlencode($file);
            $new_file = file_get_contents($the_file);

            // Write - Makes directory first if does not exist
            
                // $file_path = explode('.', $the_file);

                // if (!is_dir(FCPATH . $file_path[0])) {
                //   // dir doesn't exist, make it
                //   mkdir(FCPATH . $file_path[0]);
                // }            

            file_put_contents(FCPATH . $file, $new_file);
           
        }

        // update the current version
            
            $this->db->update('go_version', array('Tag' => $latest_version), "id = 1");

            $return = array();
            return $return["message"] = "Success";

    }

    /**
     *  Gets agent IP for request
     */

    public function go_get_agent_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED'])) $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR'])) $ipaddress = $_SERVER['REMOTE_ADDR'];
        else $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }       

    /**
    * Set Version of Go CMS to updated Version
    *
    * @return bool
    */

    public function go_set_version($newVersion){

      $currentVersion = $this->db->where('meta_key','current_version')
        ->update('go_system_info',["meta_value" => $newVersion]);

      return true;
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

    /**
     *  Pages Router for Home
     */
    
    public function go_router() {

        $last = explode("/", $_SERVER['REQUEST_URI']);
        $route = end($last);

        $cleanup = explode("?", $route);
        $cleaned_route = $cleanup[0];

        $query = $this->db
            ->select('ID,Slug,Content,MetaTitle,H1')
            ->where('Status', 1)
            ->where('Slug', $cleaned_route)
            ->limit(1)
            ->get('go_pages');

        $row = $query->row();

        if($row) {
            $h1 = ($row->H1 != "" || !empty($row->H1)) ? "<h1>" . $row->H1 . "</h1>" : "";
            return $h1 . $row->Content;
        }
        else return "<h1>Page Not Found</h1><p>404 error</p>";
    }
        
}
