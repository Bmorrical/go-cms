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
 *  Requires Documentation
 */

function go_flash() {

    if(isset($_SESSION['flashSuccess'])) {
        echo "<div class='flash alert alert-success' role='alert'>" . $_SESSION['flashSuccess'] . "</div>";
    }

    if(isset($_SESSION['flashInfo'])) {
        echo "<div class='flash alert alert-info' role='alert'>" . $_SESSION['flashInfo'] . "</div>";
    }

    if(isset($_SESSION['flashWarning'])) {
        echo "<div class='flash alert alert-warning' role='alert'>" . $_SESSION['flashWarning'] . "</div>";
    }

    if(isset($_SESSION['flashDanger'])) {
        echo "<div class='flash alert alert-danger' role='alert'>" . $_SESSION['flashDanger'] . "</div>";
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
        ->select('MenuItemID, MenuID, MenuItemName, MenuItemURL, Icon, ActiveClass')
        ->where('MenuID', $menu_id)
        ->where('Status', 1)
        ->order_by('Order', "asc")
        ->get('go_menu_items');

        foreach($query->result() as $result){
            if($count == 1) {
                $return .= "<div id='menu-id-" . $result->MenuID . "'>"; // setup parent DIV and UL

                //$return .= "<ul>"; 
                
                if($menu_id == 1){
                    $return .= "<ul class='top_menu_ul'>"; 
                }elseif($menu_id == 2){
                    $return .= "<ul class='side_menu_ul'>"; 
                }else{
                    $return .= "<ul>"; 
                }
                
            }
            $return .= "<li class='menu-" . $result->ActiveClass . "'>";  // set active class for menu
            if($result->MenuItemURL != "") { // setup child LI's
                ($result->MenuItemID == 1) ? $key = '?go=' . $ci->config->item('go_login_key') : $key = "";
                if($result->Icon != "" || !is_null($result->Icon)) {
                    $return .= "<a class='menu-contents menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'><i class='" .  $result->Icon . "'></i> " . $result->MenuItemName . "</a>";
                } else {
                    $return .= "<a class='menu-id-" . $result->MenuID . "' href='" . base_url() . $result->MenuItemURL . $key ."'>" . $result->MenuItemName . "</a>";
                }
            } else {
                $return .= $result->MenuItemName;
            }
            $return .= "</li>";
            $count++;
        }

        $return .= "</div>";

    echo $return;

}
