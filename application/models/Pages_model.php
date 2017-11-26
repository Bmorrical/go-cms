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

class Pages_model extends GO_Admin_model {

	public function __construct(){
		parent::__construct();

	}

	// POST (Create), PUT (Update)

		public function post_data($post, $id) {

				$data = array();
				$count = 1;
				foreach ($post as $key => $value) {
					if($count == 1) {
						$return_route = $key;
						$data['ID'] = $id;
						$count++;
						continue;
					}
					$data[$key] = $value;
					$count++;
				}
			if($id == 0) { // POST (Create)
				$data['Created']   = date('Y-m-d H:i:s');
				$data['CreatedBy'] = $this->session->userdata('user_id');
				$this->db->insert('go_pages', $data);
				$id = $this->db->insert_id();
			} else { // PUT (Update)
				$data['Updated']   = date('Y-m-d H:i:s');
				$data['UpdatedBy'] = $this->session->userdata('user_id');
				$this->db->where('ID', $id);
				$this->db->update('go_pages', $data);
			}

			switch($return_route) {
				case 'save':
					redirect(base_url() . 'admin/page/edit?id=' . $id);
					break;
				case 'save-and-close':
					redirect(base_url() . 'admin/pages');
					break;
				case 'save-and-new':
					redirect(base_url() . 'admin/page/add');
					break;
				default:
					redirect(base_url() . 'admin/pages');
					break;
			}

		}

	// GET (Read)

    public function activate_inactivate($post) {

        ($this->input->cookie("go-menu-" . $this->users_page_id() . "-" . md5($this->config->item('go_admin_login_cookie'))) == 1) ? $new_status = 0 : $new_status = 1;

        foreach ($post as $key => $value) {
            $data = array(
                'Status'    => $new_status,
                'Updated'   => date('Y-m-d H:i:s'),
                'UpdatedBy' => $_SESSION['admin']['user_id']
            );
            $this->db->where('ID', $key);
            $this->db->update('go_users', $data);
        }

        $this->session->set_flashdata('flashSuccess', 'Records have been successfully updated.');

        redirect(base_url() . 'admin/users');
    }  

    public function ajax_update_display_status($post) {

        $this->input->set_cookie(
            "go-menu-" . $this->users_page_id() . "-" . md5($this->config->item('go_admin_login_cookie')), 
            $post['NewValue'], // New Value
            60*60*24*7*35 // 35 days, needs to be a config
        );
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

		public function go_get_all() {
			$return = array();
			$return['rows'] = array();
			$return['keys'] = array();
			$return['keys']['key'] = array('Title','Slug');
			$return['keys']['col'] = array('1', '4','2'); // quantitiy for cols should be 1 more than keys, max 12

	        /**
	         *  If there is no cookie for menu preference, set one to Active.  
	         */

	        $page_id = $this->users_page_id(); 

	        if (is_null($this->input->cookie("go-menu-" . $page_id . "-" . md5($this->config->item('go_admin_login_cookie'))))) {
	            $this->input->set_cookie(
	                "go-menu-" . $page_id . "-" . md5($this->config->item('go_admin_login_cookie')), 
	                1, // New Value
	                60*60*24*7*35 // 35 days, needs to be a config
	            );
	            $status = 1;
	        } else {
	            $status = $this->input->cookie("go-menu-" . $page_id . "-" . md5($this->config->item('go_admin_login_cookie')));
	        }

			$query = $this->db
				->select('ID,Title,Slug')
				->where('Status', $status)
				->get('go_pages');

				foreach($query->result() as $d) {
					$return['rows'][] = get_object_vars($d);
				}

			return $return;
		}

		public function go_get_one($id) {
			$return = array();
			$return['values'] = array();

			if($id != 0) {
			$query = $this->db
				->select('ID,Title,MetaTitle,H1,Slug,Content')
				->where('ID', $id)
				->limit(1)
				->get('go_pages');

				foreach($query->result() as $d) {
					$return['values'] = get_object_vars($d);
				}
			}

			return $return;
		}

	// MISC

		public function toggle_display($post) {

			($this->session->userdata('display_status') == 1) ? $new_status = 0 : $new_status = 1;
			foreach ($post as $key => $value) {
				$data = array(
					'Status'    => $new_status,
					'Updated'   => date('Y-m-d H:i:s'),
					'UpdatedBy' => $this->session->userdata('user_id')
				);
				$this->db->where('ID', $key);
				$this->db->update('go_pages', $data);
			}

			redirect(base_url() . 'admin/pages');
		}

	// AJAX

		public function update_display_status($post) {

			$data = array(
				'DisplayStatus' => $post['NewValue']
			);
			$this->db->where('MenuItemID', $post['ID']);
			$this->db->update('go_menu_items', $data);

		}

	// DESTROY (Delete)

}
