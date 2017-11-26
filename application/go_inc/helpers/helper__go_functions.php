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

/**
 *  If not a valid session, take user to login page
 */

function go_verify_user_session($route = "admin") {

    $ci = get_instance();

    switch($route) {
        case 'admin' : // Admin Route
            if(empty($_SESSION['admin']) || $ci->input->cookie("go-admin-hash") !== $_SESSION['admin']['hash']) {
                redirect(base_url() . "admin/login");
            }
            break;
        case 'home' : // Home route
            if(empty($_SESSION['home']) || $ci->input->cookie("go-home-hash") !== $_SESSION['home']['hash']) {
                redirect(base_url() . $config['go_home_login_route']);
            } 
            break;
        default : 
            show_404();
    }

}

/**
 *  Creates a var_dump to the browser of debug data
 * 
 *  @param $exit string | Should the script exit() after the arguments or continue parsing
 *  @param $config string | config['go_debug'] is on or off in go_config.php
 *  @param $args array | Associative array of values to be returned to the browser
 *  @return array data
 */

function go_debug($on, $exit, $args) {
    $ci = get_instance();
    if($ci->config->item('go_debug') == true && $on == true) {
        echo (true == $ci->config->item('go_debug_white_bg')) ? "<div style='background-color: #fff; color: #000;'>" : "<div>";
            echo "<pre>";
                echo "<br /><hr /><br />";
                foreach ($args as $key => $arg) {
                    echo "<h1>Array Key: " . $key . "</h1>";
                    var_dump($arg);
                    echo "<br /><hr /><br />";
                }
                if($exit == true) exit();
            echo "</pre>";
        echo "</div>";
    }
}

/**
 *  Sets the go_flash function for Codeigniter flashdata
 *
 *  Ensure you use 'refresh' in your redirect, else it won't work
 *
 *  Step 1) $this->session->set_flashdata('flashSuccess', 'Email has been sent.');
 *  Step 2) redirect(base_url() . 'my-account', 'refresh');
 *  Step 3) <?= go__flash(); ?>
 *
 *  @return string
 */

function go__flash() {

    if(isset($_SESSION['flashSuccess'])) {
        return "<div class='flash alert alert-success' role='alert'>" . $_SESSION['flashSuccess'] . "</div>";
    }

    if(isset($_SESSION['flashInfo'])) {
        return "<div class='flash alert alert-info' role='alert'>" . $_SESSION['flashInfo'] . "</div>";
    }

    if(isset($_SESSION['flashWarning'])) {
        return "<div class='flash alert alert-warning' role='alert'>" . $_SESSION['flashWarning'] . "</div>";
    }

    if(isset($_SESSION['flashDanger'])) {
        return "<div class='flash alert alert-danger' role='alert'>" . $_SESSION['flashDanger'] . "</div>";
    }
}    

/**
 *  Requires Documentation
 */
function go_get_menu_items($menu_id) {
    $ci = get_instance();
    $return = "";
    $count = 1;
    $query = $ci->db
        ->select('MenuItemID, MenuID, MenuItemName, MenuItemURL, Level, Icon, ActiveClass')
        ->where('MenuID', $menu_id)
        ->where('Status', 1)
        ->order_by('Order', "asc")
        ->get('go_menu_items');

        foreach($query->result() as $result){
            if($count == 1) {
                $return .= "<div id='menu-id-" . $result->MenuID . "'>"; // setup parent DIV and UL
                if($menu_id == 1){
                    $return .= "<ul class='top_menu_ul'>"; 
                }elseif($menu_id == 2){
                    $return .= "<ul class='side_menu_ul'>"; 
                }else{
                    $return .= "<ul>"; 
                }
            }

            if($result->Level >= $_SESSION['admin']['session_type']) { // Page has miniumum level to restrict or allows acceess

                $return .= "<li class='menu-" . $result->ActiveClass . "'>";  // set active class for menu

                if($result->MenuItemURL != "") { // setup child LI's


                    /** START LOGOUT TAB */

                        /** Add go-cms ?key to the href if this iteration is for the Logout row */

                        if ($result->MenuItemID == 1) {
                            $key = '?go=' . $ci->config->item('go_login_key');
                        } else {
                            $key = "";
                        } 


                    /** START USERS TAB */

                        /** Users Tab for Super Admin */

                            if ($result->MenuItemID == 3 && $_SESSION['admin']['session_type'] == 1) {

                                if(!empty($result->Icon)) {

                                    $return .= "<a class='menu-contents menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'><i class='" .  $result->Icon . "'></i> " . $result->MenuItemName . "</a>";

                                } else {

                                    $return .= "<a class='menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'>" . $result->MenuItemName . "</a>";

                                }              

                                continue;          

                            } 

                        /** Users Tab for Admin User */

                            elseif ($result->MenuItemID == 3 && $_SESSION['admin']['session_type'] == 2) {

                                /** ?id=<user_id> not required here, because we handle the user id from the $_SESSION in GO_CONTROLLER */

                                    $route = 'admin/user/edit';

                                if(!empty($result->Icon)) {

                                    $return .= "<a class='menu-contents menu-id-" . $result->MenuID . "' href='" . base_url() . $route . "'><i class='" .  $result->Icon . "'></i> " . $result->MenuItemName . "</a>";

                                } else {

                                    $return .= "<a class='menu-id-" . $result->MenuID . "' href='" . base_url() . $route . "'>" . $result->MenuItemName . "</a>";

                                }  

                                continue;

                            }


                    /** Show Icon Span or not based on whether its set or not */

                    if(!empty($result->Icon)) {

                        $return .= "<a class='menu-contents menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'><i class='" .  $result->Icon . "'></i> " . $result->MenuItemName . "</a>";

                    } else {

                        $return .= "<a class='menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'>" . $result->MenuItemName . "</a>";

                    }

                } else {
                    $return .= $result->MenuItemName;
                }
                $return .= "</li>";
            }
            $count++;
        }

        $return .= "</div>";

    echo $return;

}

/**
 *  Protects AJAX requests to ensure that the request is AJAX
 *
 *  @return bool
 */

function go__is_ajax_request() {

    /** Is AJAX? **/

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;  
    
    else return false;

}
