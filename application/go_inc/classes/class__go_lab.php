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
    
class GO_Lab extends GO_Controller 
{

    public $ci;
    public $post;

    /**
     *  Construct
     */    

    public function __construct($post){
        $this->ci = get_instance();
        $this->post = $post;
        $this->ci->config->load('go_config');
        $this->ci->load->helper('url'); 
        $this->ci->load->dbforge();
        $this->go_lab();
    }   

    /**
     *  Requires Documentation
     */
    public function go_lab() {

        // Routes         
            $file = fopen(APPPATH . "/config/routes.php", "a"); // a for append
                $sef_plural = str_replace("_","-", $this->post['class-name-plural']);
                $sef_single = str_replace("_", "-", $this->post['class-name-singular']);
                $txt  = "\r\n";
                $txt .= "$" . "route['admin/" . $sef_plural . "'] = '" . $this->post['class-name-plural'] . "/" . $this->post['class-name-plural'] . "';\r\n";
                $txt .= "$" . "route['admin/" . $sef_single . "/add'] = '" . $this->post['class-name-plural'] . "/" . $this->post['class-name-singular'] . "_add';\r\n";
                $txt .= "$" . "route['admin/" . $sef_single . "/edit'] = '" . $this->post['class-name-plural'] . "/" . $this->post['class-name-singular'] . "_edit';\r\n";
            fwrite($file, $txt);
            fclose($file);        

        // Make SQL

            // ********** temporarily set if SQL is commented out, also remember to comment out routes while developing *********// 
            // $menu_item_id = 14;
            
            $query = $this->ci->db
                ->select('MenuItemID')
                ->where('MenuID', $this->post['assigned-menu'])
                ->get('go_menu_items');
            $order = $query->num_rows() + 1;

            $data = array(
                'MenuID'       => $this->post['assigned-menu'],
                'MenuItemName' => $this->post['menu-name'],
                'MenuItemURL'  => $this->post['menu-url'],
                'Level'        => 1,
                'Order'        => $order,
                'Icon'         => $this->post['menu-icon'],
                'ActiveClass'  => $this->post['active-class'],
                'Status'       => 1
            );
            $this->ci->db->insert('go_menu_items', $data);
            $menu_item_id = $this->ci->db->insert_id();

            $fields = array(
                'ID' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'auto_increment' => TRUE
                )    
            );

            $sqlCols = explode(',', $this->post['sql-table-columns']);
            foreach ($sqlCols as $value) {
                // $value = substr($value,1,-1); // remove first and last quotes:  '{key}' = {key}
                $fields[$value] = array(
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                );
            }

            $fields['Status'] = array(
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1
            );     
            $fields['Order'] = array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE 
            );              
            $fields['Created'] = array(
                'type' => 'DATETIME',
                'null' => TRUE            
            );   
            $fields['CreatedBy'] = array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE               
            );   
            $fields['Updated'] = array(
                'type' => 'DATETIME',
                'null' => TRUE               
            );   
            $fields['UpdatedBy'] = array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE               
            );                         

            $this->ci->dbforge->add_field($fields);
            $this->ci->dbforge->add_key('ID', TRUE);
            $attributes = array('ENGINE' => 'InnoDB');
            $this->ci->dbforge->create_table($this->post['table-name'], FALSE, $attributes); // TRUE adds an “IF NOT EXISTS” clause into the definition        

        // Make Folders
            if (!file_exists(APPPATH . 'views/admin/' . $this->post['class-name-plural'])) {
                mkdir(APPPATH . 'views/admin/' . $this->post['class-name-plural'], 0775, true);
            }

            if (!file_exists(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . '/helpers')) {
                mkdir(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . '/helpers', 0775, true);
            }

            $content = file_get_contents(APPPATH . 'views/admin/helpers/main_content_add_edit_header.php');
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/helpers/main_content_add_edit_header.php", "w");
            fwrite($file, $content);
            fclose($file);

            $content = file_get_contents(APPPATH . 'views/admin/helpers/main_content_header.php');
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/helpers/main_content_header.php", "w");
            fwrite($file, $content);
            fclose($file);

            $sef_plural = str_replace("_","-", $this->post['class-name-plural']);
            $sef_single = str_replace("_", "-", $this->post['class-name-singular']);

        // Make index.html
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/index.html", "w");
                $txt  = "";
                $txt .= "<!DOCTYPE html>\r\n";
                $txt .= "<html>\r\n";
                $txt .= "<head>\r\n";
                $txt .=     "\t<title>403 Forbidden</title>\r\n";
                $txt .= "</head>\r\n";
                $txt .= "<body>\r\n";
                $txt .=     "\t<p>Directory access is forbidden.</p>\r\n";
                $txt .= "</body>\r\n";
                $txt .= "</html>\r\n";
            fwrite($file, $txt);
            fclose($file);

        // Make View 1 (Overview Page)
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/" . $this->post['class-name-plural'] . ".php", "w");
                $txt  = "";
                $txt .=     "\t<?php\r\n";
                $txt .= "// Start Page Config\r\n";
                $txt .= "    \t$" . "this_page_singular = '" . $this->post['class-name-singular'] . "'; // defined for text html\r\n";
                $txt .= "    \t$" . "this_page_plural = '" . $this->post['class-name-plural'] . "';\r\n";
                $txt .= "    \t$" . "this_page_results = $" . $this->post['class-name-plural'] . "; // defined as result array back from controller\r\n";
                $txt .= "// End Page Config\r\n";
                $txt .=     "\t?>\r\n";
                $txt .= "<div class='container-fluid'>\r\n";
                $txt .=     "\t<div class='row'>\r\n";
                $txt .=         "\t\t<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>\r\n";
                $txt .=         "\t\t<div class='col-md-9'>\r\n";
                $txt .=             "\t\t\t<?php\r\n";
                $txt .=                 "\t\t\t\tinclude_once(APPPATH . 'views/admin/" . $this->post['class-name-plural'] . "/helpers/main_content_header.php');\r\n";
                $txt .=                 "\t\t\t\tif(!empty($" . "this_page_results['rows'])) { ?>\r\n";
                $txt .=                     "\t\t\t\t\t<div class='row detailRow'>\r\n";
                $txt .=                         "\t\t\t\t\t\t<div class='col-md-1 center'>\r\n";
                $txt .=                             "\t\t\t\t\t\t\t<input id='toggle-all-master' type='checkbox' value='0'>\r\n";
                $txt .=                         "\t\t\t\t\t\t</div>\r\n";                          
                $txt .=                         "\t\t\t\t\t\t<?php\r\n";
                $txt .=                         "\t\t\t\t\t\t// HEADER\r\n";
                $txt .=                             "\t\t\t\t\t\t\t// This loop looks in the Key and Col array from Model to handle Bootstrap column HTML\r\n";
                $txt .=                             "\t\t\t\t\t\t\t$" . "column_count = 1; // starts at 1 to skip the checkbox col\r\n";
                $txt .=                             "\t\t\t\t\t\t\tforeach($" . "this_page_results['keys']['key'] as $" . "val) {  ?>\r\n";
                $txt .=                                 "\t\t\t\t\t\t\t\t<div class=\"col-md-<?= $" . "this_page_results['keys']['col'][$" . "column_count]; ?>\">\r\n"; 
                $txt .=                                     "\t\t\t\t\t\t\t\t\t<?= $" . "val; ?>\r\n";
                $txt .=                                 "\t\t\t\t\t\t\t\t</div>\r\n";  
                $txt .=                             "\t\t\t\t\t\t\t<?php\r\n";
                $txt .=                                 "\t\t\t\t\t\t\t\t$" . "column_count++;\r\n";
                $txt .=                             "\t\t\t\t\t\t\t}\r\n";   
                $txt .=                         "\t\t\t\t\t\t?>\r\n";
                $txt .=                     "\t\t\t\t\t</div>\r\n"; 
                $txt .=                     "\t\t\t\t\t<?php\r\n";       
                $txt .=                     "\t\t\t\t\t// RESULTS\r\n";     
                $txt .=                     "\t\t\t\t\t$" . "row_count = 1;\r\n";
                $txt .=                     "\t\t\t\t\tforeach($" . "this_page_results['rows'] as $" . "key => $" . "val) {\r\n"; 
                $txt .=                         "\t\t\t\t\t\t$" . "array_keys = array_keys($" . "val); // allows calling associative array by keys\r\n";  
                $txt .=                         "\t\t\t\t\t\t?>\r\n";
                $txt .=                         "\t\t\t\t\t\t<div class=\"row<?php if($" . "row_count % 2) {echo ' even';} ?>\">\r\n";
                $txt .=                             "\t\t\t\t\t\t\t<div class='col-md-1 center'>\r\n";
                $txt .=                                 "\t\t\t\t\t\t\t\t<input class='check-toggle' type='checkbox' name=\"<?= $" . "val['ID']; ?>\">\r\n";
                $txt .=                             "\t\t\t\t\t\t\t</div>\r\n";
                $txt .=                                 "\t\t\t\t\t\t\t\t<?php\r\n";
                $txt .=                                     "\t\t\t\t\t\t\t\t\t// This loop looks in the Key and Col array from Model to handle Bootstrap column HTML\r\n";
                $txt .=                                     "\t\t\t\t\t\t\t\t\t$" . "column_count = 1; // starts at 1 to skip the checkbox col\r\n";
                $txt .=                                     "\t\t\t\t\t\t\t\t\tforeach($" . "this_page_results['keys']['key'] as $" . "val2) {  ?>\r\n";
                $txt .=                                         "\t\t\t\t\t\t\t\t\t\t<div class=\"truncate col-md-<?= $" . "this_page_results['keys']['col'][$" . "column_count]; ?>\">\r\n";
                $txt .=                                             "\t\t\t\t\t\t\t\t\t\t\t<?php\r\n"; 
                $txt .=                                                 "\t\t\t\t\t\t\t\t\t\t\t\tif($" . "column_count == 1) {\r\n";
                $txt .=                                                     "\t\t\t\t\t\t\t\t\t\t\t\t\techo '<a href=\"' . base_url() . 'admin/' . $" . "this_page_singular . '/edit?id=' .  $" . "val['ID'] . '\">';\r\n";
                $txt .=                                                         "\t\t\t\t\t\t\t\t\t\t\t\t\t\techo $" . "val[$" . "array_keys[$" . "column_count]];\r\n";
                $txt .=                                                     "\t\t\t\t\t\t\t\t\t\t\t\t\techo '</a>';\r\n";
                $txt .=                                                 "\t\t\t\t\t\t\t\t\t\t\t\t} else {\r\n";
                $txt .=                                                     "\t\t\t\t\t\t\t\t\t\t\t\t\tif(is_null($" . "val[$" . "array_keys[$" . "column_count]]) || $" . "val[$" . "array_keys[$" . "column_count]] == '') {\r\n";
                $txt .=                                                         "\t\t\t\t\t\t\t\t\t\t\t\t\t\techo '';\r\n";
                $txt .=                                                     "\t\t\t\t\t\t\t\t\t\t\t\t\t} else {\r\n";
                $txt .=                                                         "\t\t\t\t\t\t\t\t\t\t\t\t\t\techo $" . "val[$" . "array_keys[$" . "column_count]];\r\n";
                $txt .=                                                     "\t\t\t\t\t\t\t\t\t\t\t\t\t}\r\n";
                $txt .=                                                 "\t\t\t\t\t\t\t\t\t\t\t\t}\r\n";
                $txt .=                                             "\t\t\t\t\t\t\t\t\t\t\t?>\r\n";
                $txt .=                                         "\t\t\t\t\t\t\t\t\t\t</div>\r\n";  
                $txt .=                                     "\t\t\t\t\t\t\t\t\t<?php\r\n";
                $txt .=                                         "\t\t\t\t\t\t\t\t\t\t$" . "column_count++;\r\n";
                $txt .=                                     "\t\t\t\t\t\t\t\t\t}\r\n"; 
                $txt .=                         "\t\t\t\t\t\techo '</div>'; // close row\r\n"; 
                $txt .=                         "\t\t\t\t\t$" . "row_count++;\r\n";
                $txt .=                     "\t\t\t\t\t}\r\n";
                $txt .=                 "\t\t\t\t}\r\n";
                $txt .=             "\t\t\t?>\r\n";
                $txt .=             "\t\t\t</form>\r\n";
                $txt .=         "\t\t</div>\r\n";
                $txt .=     "\t</div>\r\n";
                $txt .= "</div>\r\n";

            fwrite($file, $txt);
            fclose($file);            

        // Make View 2 (Add Page)
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/add.php", "w");
                $txt  = "";
                $txt .=     "\t<?php\r\n";
                $txt .= "// Start Page Config\r\n";
                $txt .= "    \t$" . "this_page_singular = '" . $this->post['class-name-singular'] . "'; // defined for text html\r\n";
                $txt .= "    \t$" . "this_page_plural = '" . $this->post['class-name-plural'] . "';\r\n";
                $txt .= "    \t$" . "this_page_type = 'add';\r\n";
                $txt .= "// End Page Config\r\n";
                $txt .=     "\t?>\r\n";
                $txt .= "<div class='container-fluid'>\r\n";
                $txt .=     "\t<div class='row'>\r\n";
                $txt .=         "\t\t<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>\r\n";
                $txt .=         "\t\t<div class='col-md-9'>\r\n";
                $txt .=             "\t\t\t<?php\r\n";
                $txt .=                 "\t\t\t\tinclude_once(APPPATH . 'views/admin/" . $this->post['class-name-plural'] . "/helpers/main_content_add_edit_header.php');\r\n";
                $txt .=                 "\t\t\t\tinclude_once(APPPATH . 'views/admin/" . $this->post['class-name-plural'] . "/form.php');\r\n";
                $txt .=             "\t\t\t?>\r\n";
                $txt .=                "\t\t\t\t</form>\r\n";
                $txt .=         "\t\t</div>\r\n";
                $txt .=     "\t</div>\r\n";
                $txt .= "</div>\r\n";                

            fwrite($file, $txt);
            fclose($file);               

        // Make View 3 (Edit Page)
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/edit.php", "w");
                $txt  = "";
                $txt .=     "\t<?php\r\n";
                $txt .= "// Start Page Config\r\n";
                $txt .= "    \t$" . "this_page_singular = '" . $this->post['class-name-singular'] . "'; // defined for text html\r\n";
                $txt .= "    \t$" . "this_page_plural = '" . $this->post['class-name-plural'] . "';\r\n";
                $txt .= "    \t$" . "this_page_type = 'edit';\r\n";
                $txt .= "    \t$" . "this_page_results = $" . $this->post['class-name-singular'] . "; // defined as result array back from controller\r\n";
                $txt .= "// End Page Config\r\n";
                $txt .=     "\t?>\r\n";
                $txt .= "<div class='container-fluid'>\r\n";
                $txt .=     "\t<div class='row'>\r\n";
                $txt .=         "\t\t<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>\r\n";
                $txt .=         "\t\t<div class='col-md-9'>\r\n";
                $txt .=             "\t\t\t<?php\r\n";
                $txt .=                 "\t\t\t\tinclude_once(APPPATH . 'views/admin/" . $this->post['class-name-plural'] . "/helpers/main_content_add_edit_header.php');\r\n";
                $txt .=                 "\t\t\t\tinclude_once(APPPATH . 'views/admin/" . $this->post['class-name-plural'] . "/form.php');\r\n";
                $txt .=             "\t\t\t?>\r\n";
                $txt .=                "\t\t\t\t</form>\r\n";
                $txt .=         "\t\t</div>\r\n";
                $txt .=     "\t</div>\r\n";
                $txt .= "</div>\r\n";                  
            fwrite($file, $txt);
            fclose($file);               

        // Make View 4 (Form Include Page)
            $file = fopen(APPPATH . 'views/admin/' . $this->post['class-name-plural'] . "/form.php", "w");
                $txt  = "";
                $count = 0;
                $form_names = explode(",", $this->post['sql-table-columns']);
                $form_labels = explode(",", $this->post['table-column-labels']);

                foreach ($form_names as $key => $value) {
                    $txt .= "<div class='row'>\r\n";
                        $txt .= "\t<div class='col-md-3'>\r\n";
                            $trimmed_label = substr($form_labels[$count],1,-1);
                            $txt .= "\t\t" . $trimmed_label . "\r\n";
                        $txt .= "\t</div>\r\n";
                        $txt .= "\t<div class='col-md-6'>\r\n";
                            $txt .= "\t\t<input class='form-control' name='" . $value . "' type='text' value='";
                            $txt .= "<?php if(isset($" . $this->post['class-name-singular'] . "['values']['" . $value . "'])) echo $" . $this->post['class-name-singular'] . "['values']['" . $value . "']; ?>";
                            $txt .= "'>\r\n";
                        $txt .= "\t</div>\r\n";
                    $txt .= "</div>\r\n";
                    $count++;
                }

            fwrite($file, $txt);
            fclose($file);               

        // Make Model
            $file = fopen(APPPATH . 'models/' . ucfirst($this->post['class-name-plural']) . "_model.php", "w");
                $txt  = "";
                $txt .=  "<?php\r\n";
                $txt .=  "defined('BASEPATH') OR exit('No direct script access allowed');\r\n\r\n";
                $txt .= "class " . ucfirst($this->post['class-name-plural']) . "_model extends GO_Admin_model {\r\n\r\n";
                $txt .=      "\tpublic function __construct(){\r\n";
                $txt .=          "\t\tparent::__construct();\r\n\r\n";      
                $txt .=      "\t}\r\n\r\n";
                $txt .=      "\t// POST (Create), PUT (Update)\r\n\r\n";
                $txt .=          "\t\tpublic function post_data($" . "post, $" . "id) {\r\n\r\n";
                $txt .=             "\t\t\t\t$" . "data = array();\r\n";
                $txt .=             "\t\t\t\t$" . "count = 1;\r\n";
                $txt .=             "\t\t\t\tforeach ($" . "post as $" . "key => $" . "value) {\r\n";
                $txt .=             "\t\t\t\t\tif($" . "count == 1) {\r\n";
                $txt .=             "\t\t\t\t\t\t$" . "return_route = $" . "key;\r\n";
                $txt .=             "\t\t\t\t\t\t$" . "data['ID'] = $" . "id;\r\n";
                $txt .=             "\t\t\t\t\t\t$" . "count++;\r\n";
                $txt .=             "\t\t\t\t\t\tcontinue;\r\n";
                $txt .=             "\t\t\t\t\t}\r\n";
                $txt .=             "\t\t\t\t\t$" . "data[$" . "key] = $" . "value;\r\n";
                $txt .=             "\t\t\t\t\t$" . "count++;\r\n";
                $txt .=             "\t\t\t\t}\r\n";
                $txt .=          "\t\t\tif($" . "id == 0) { // POST (Create)\r\n";
                $txt .=          "\t\t\t\tunset($" . "data['ID']);\r\n";

                $txt .=             "\t\t\t\t$" . "data['Created']   = date('Y-m-d H:i:s');\r\n";
                $txt .=             "\t\t\t\t$" . "data['CreatedBy'] = $" . "this->session->userdata('user_id');\r\n";
                $txt .=             "\t\t\t\t$" . "this->db->insert('" . $this->post['table-name'] . "', $" . "data);\r\n";
                $txt .=             "\t\t\t\t$" . "id = $" . "this->db->insert_id();\r\n";
                $txt .=          "\t\t\t} else { // PUT (Update)\r\n";
                $txt .=             "\t\t\t\t$" . "data['Updated']   = date('Y-m-d H:i:s');\r\n";
                $txt .=             "\t\t\t\t$" . "data['UpdatedBy'] = $" . "this->session->userdata('user_id');\r\n";
                $txt .=             "\t\t\t\t$" . "this->db->where('ID', $" . "id);\r\n";
                $txt .=             "\t\t\t\t$" . "this->db->update('" . $this->post['table-name'] . "', $" . "data);\r\n";
                $txt .=          "\t\t\t}\r\n\r\n";
                $txt .=          "\t\t\t$" . "this->session->set_flashdata('flashSuccess', 'Record has been successfully updated.');\r\n\r\n";
                $txt .=          "\t\t\tswitch($" . "return_route) {\r\n";
                $txt .=          "\t\t\t\tcase 'save':\r\n";
                $txt .=          "\t\t\t\t\tredirect(base_url() . 'admin/" . $sef_single . "/edit?id=' . $" . "id);\r\n";
                $txt .=          "\t\t\t\t\tbreak;\r\n";
                $txt .=          "\t\t\t\tcase 'save-and-close':\r\n";
                $txt .=          "\t\t\t\t\tredirect(base_url() . 'admin/" . $sef_plural . "');\r\n";
                $txt .=          "\t\t\t\t\tbreak;\r\n";
                $txt .=          "\t\t\t\tcase 'save-and-new':\r\n";
                $txt .=          "\t\t\t\t\tredirect(base_url() . 'admin/" . $sef_single . "/add');\r\n";
                $txt .=          "\t\t\t\t\tbreak;\r\n";
                $txt .=          "\t\t\t\tdefault:\r\n";
                $txt .=          "\t\t\t\t\tredirect(base_url() . 'admin/" . $sef_plural . "');\r\n";
                $txt .=          "\t\t\t\t\tbreak;\r\n";
                $txt .=          "\t\t\t}\r\n\r\n";               
                $txt .=          "\t\t}\r\n\r\n";

                $txt .=          "\t// GET (Read)\r\n\r\n";
                $txt .=          "\t\tpublic function go_get_all() {\r\n";

                $txt .=              "\t\t\t if(!isset($" . "_SESSION['admin']['filters']['" . $this->post['class-name-plural'] . "-active-inactive']))\r\n";
                $txt .=              "\t\t\t\t$" . "_SESSION['admin']['filters']['" . $this->post['class-name-plural'] . "-active-inactive'] = 1;\r\n\r\n";

                $txt .=              "\t\t\t$" . "return = array();\r\n";
                $txt .=              "\t\t\t$" . "return['rows'] = array();\r\n";
                $txt .=              "\t\t\t$" . "return['keys'] = array();\r\n";
                $txt .=              "\t\t\t$" . "return['keys']['key'] = array(" . $this->post['overiew-fields'] . ");\r\n"; 
                $txt .=              "\t\t\t$" . "return['keys']['col'] = array('1', " . $this->post['column-layout'] . "); // quantitiy for cols should be 1 more than keys, max 12\r\n\r\n";
                $txt .=              "\t\t\t$" . "query = $" . "this->db\r\n";            
                $txt .=                  "\t\t\t\t->select('ID," . $this->post['overview-sql-cols'] . "')\r\n";
                $txt .=                  "\t\t\t\t->where('Status', $" . "_SESSION['admin']['filters']['" . $this->post['class-name-plural'] . "-active-inactive'])\r\n";
                $txt .=                  "\t\t\t\t->get('" . $this->post['table-name'] . "');\r\n\r\n"; 
                $txt .=                  "\t\t\t\tforeach($" . "query->result() as $" . "d) {\r\n";
                $txt .=                      "\t\t\t\t\t$" . "return['rows'][] = get_object_vars($" . "d);\r\n";
                $txt .=                  "\t\t\t\t}\r\n\r\n";
                $txt .=              "\t\t\treturn $" . "return;\r\n";
                $txt .=          "\t\t}\r\n\r\n";             
                $txt .=          "\t\tpublic function go_get_one($" . "id) {\r\n";
                $txt .=              "\t\t\t$" . "return = array();\r\n";
                $txt .=              "\t\t\t$" . "return['values'] = array();\r\n\r\n";                  
                $txt .=              "\t\t\tif($" . "id != 0) {\r\n";
                $txt .=              "\t\t\t$" . "query = $" . "this->db\r\n";
                $txt .=                  "\t\t\t\t->select('ID," . $this->post['sql-table-columns'] . "')\r\n";
                $txt .=                  "\t\t\t\t->where('ID', $" . "id)\r\n";
                $txt .=                  "\t\t\t\t->limit(1)\r\n";       
                $txt .=                  "\t\t\t\t->get('" . $this->post['table-name'] . "');\r\n\r\n";   
                $txt .=                  "\t\t\t\tforeach($" . "query->result() as $" . "d) {\r\n";
                $txt .=                      "\t\t\t\t\t$" . "return['values'] = get_object_vars($" . "d);\r\n";
                $txt .=                  "\t\t\t\t}\r\n";
                $txt .=              "\t\t\t}\r\n\r\n";
                $txt .=              "\t\t\treturn $" . "return;\r\n";
                $txt .=          "\t\t}\r\n\r\n";
                $txt .=      "\t// MISC\r\n\r\n";
                $txt .=          "\t\tpublic function toggle_display($" . "post) {\r\n\r\n";
                $txt .=          "\t\t\t$" . "new_status = ($" . "_SESSION['admin']['filters']['" . $this->post['class-name-plural'] . "-active-inactive'] == 1) ? 0 : 1;\r\n";
                $txt .=          "\t\t\tforeach ($" . "post as $" . "key => $" . "value) {\r\n";
                $txt .=          "\t\t\t\t$" . "data = array(\r\n";
                $txt .=          "\t\t\t\t\t'Status'    => $" . "new_status,\r\n";
                $txt .=          "\t\t\t\t\t'Updated'   => date('Y-m-d H:i:s'),\r\n";
                $txt .=          "\t\t\t\t\t'UpdatedBy' => $" . "this->session->userdata('user_id')\r\n";           
                $txt .=          "\t\t\t\t);\r\n";
                $txt .=          "\t\t\t\t$" . "this->db->where('ID', $" . "key);\r\n";
                $txt .=          "\t\t\t\t$" . "this->db->update('" . $this->post['table-name'] . "', $" . "data);\r\n";
                $txt .=          "\t\t\t}\r\n\r\n";
                $txt .=          "\t\t\t$" . "this->session->set_flashdata('flashSuccess', 'Record(s) have been successfully updated.');\r\n\r\n";
                $txt .=          "\t\t\tredirect(base_url() . 'admin/" . $sef_plural . "');\r\n";
                $txt .=          "\t\t}\r\n\r\n";
                $txt .=     "\t// AJAX\r\n\r\n";
                $txt .=         "\t\tpublic function update_display_status($" . "post) {\r\n\r\n";
                $txt .=             "\t\t\t$" . "_SESSION['admin']['filters']['" . $this->post['class-name-plural'] . "-active-inactive'] = $" . "post['NewValue'];\r\n";
                $txt .=         "\t\t}\r\n\r\n";
                $txt .=      "\t// DESTROY (Delete)\r\n\r\n";                          
                $txt .=  "}\r\n";
            fwrite($file, $txt);
            fclose($file);  

        // Make Controller
            $file = fopen(APPPATH . 'controllers/' . ucfirst($this->post['class-name-plural']) . ".php", "w");
                $txt  = "";
                $txt .= "<?php\r\n";
                $txt .= "defined('BASEPATH') OR exit('No direct script access allowed');\r\n\r\n";
                $txt .= "class " . ucfirst($this->post['class-name-plural']) . " extends GO_Admin_Controller {\r\n\r\n";

                $txt .=     "\tpublic function __construct(){\r\n";
                $txt .=         "\t\tparent::__construct();\r\n\r\n";
                $txt .=         "\t\t/** Validate the user should be able to access this resource */\r\n\r\n";
                $txt .=         "\t\t\tif(empty($" . "_SESSION['admin']) || $" . "this->input->cookie('go-admin-hash') !== $" . "_SESSION['admin']['hash']) {\r\n";
                $txt .=         "\t\t\t\tredirect(base_url() . 'admin/login');\r\n";
                $txt .=         "\t\t\t}\r\n\r\n";
                $txt .=         "\t\t$" . "this->load->model('" . $this->post['class-name-plural'] . "_model','" . $this->post['class-name-singular'] . "');\r\n\r\n";
                $txt .=     "\t}\r\n\r\n";

                $txt .=     "\t// PUT (Create)\r\n\r\n";
                $txt .=         "\t\tpublic function " . $this->post['class-name-singular'] . "_add() {\r\n";    
                $txt .=             "\t\t\t$" . "data = array(\r\n";
                $txt .=                 "\t\t\t\t'" . $this->post['class-name-singular'] . "' => $" . "this->" . $this->post['class-name-singular'] . "->go_get_one(0)\r\n";
                $txt .=             "\t\t\t);\r\n";  
                $txt .=             "\t\t\t$" . "this->go_load_page(array('page'=>'admin/" . $this->post['class-name-plural'] . "/add','title'=>'Add " . ucfirst($this->post['class-name-singular']) . "','template'=>'admin','activeClass'=>'" . $this->post['active-class'] . "','queries'=>$" . "data));\r\n";
                $txt .=         "\t\t}\r\n\r\n";

                $txt .=     "\t// GET (Read)\r\n\r\n"; 
                $txt .=         "\t\tpublic function " . $this->post['class-name-plural'] . "() {\r\n";
                $txt .=             "\t\t\tif($" . "_POST && (isset($" . "_POST['save']) || isset($" . "_POST['save-and-new']) || isset($" . "_POST['save-and-close']))) {\r\n";
                $txt .=             "\t\t\t\t$" . "id = 0;\r\n";
                $txt .=             "\t\t\t\tif(!empty($" . "this->input->get('id'))) $" . "id = $" . "this->input->get('id'); \r\n";
                $txt .=             "\t\t\t\t$" . "this->" . $this->post['class-name-singular'] . "->post_data($" . "_POST, $" . "id);\r\n";
                $txt .=             "\t\t\t}\r\n";

                $txt .=             "\t\t\tif(($" . "_POST && isset($" . "_POST['toggleDisplay']))) $" . "this->" . $this->post['class-name-singular'] . "->toggle_display($" . "_POST);  // Toggle Active/Inactive\r\n";

                $txt .=             "\t\t\t$" . "data = array(\r\n";
                $txt .=                 "\t\t\t\t'" . $this->post['class-name-plural'] . "' => $" . "this->" . $this->post['class-name-singular'] . "->go_get_all()\r\n";
                $txt .=             "\t\t\t);\r\n";

                $txt .=             "\t\t\t$" . "this->go_load_page(array('page'=>'admin/" . $this->post['class-name-plural'] . "/" . $this->post['class-name-plural'] . "','title'=>'" . ucfirst($this->post['class-name-plural']) . "','template'=>'admin','activeClass'=>'" . $this->post['active-class'] . "','queries'=>$" . "data));\r\n";     
                $txt .=         "\t\t}\r\n\r\n";

                $txt .=     "\t// PUT (Update)\r\n\r\n";
                $txt .=         "\t\tpublic function " . $this->post['class-name-singular'] . "_edit() {\r\n";   
                $txt .=             "\t\t\t$" . "data = array(\r\n";
                $txt .=                 "\t\t\t\t'" . $this->post['class-name-singular'] . "' => $" . "this->" . $this->post['class-name-singular'] . "->go_get_one($" . "this->input->get('id'))\r\n";
                $txt .=             "\t\t\t);\r\n"; 
                $txt .=             "\t\t\t$" . "this->go_load_page(array('page'=>'admin/" . $this->post['class-name-plural'] . "/edit','title'=>'Edit " . ucfirst($this->post['class-name-singular']) . "','template'=>'admin','activeClass'=>'" . $this->post['active-class'] . "','queries'=>$" . "data));\r\n";
                $txt .=         "\t\t}\r\n\r\n";

                $txt .=     "\t// AJAX\r\n\r\n";
                $txt .=         "\t\tpublic function update_display_status() {\r\n";
                $txt .=         "\t\t\tif(!go__is_ajax_request()) return;\r\n";
                $txt .=             "\t\t\techo json_encode($" . "this->" . $this->post['class-name-singular'] . "->update_display_status($" . "this->input->post()));\r\n";
                $txt .=         "\t\t}\r\n\r\n";
                $txt .= "}\r\n";
            fwrite($file, $txt);
            fclose($file); 


        $this->ci->session->set_flashdata('flashSuccess', 'Class has been generated.');
        redirect(base_url() . 'admin/lab');

    }   

}
