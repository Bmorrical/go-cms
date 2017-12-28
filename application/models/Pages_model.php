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
				$data['CreatedBy'] = $_SESSION['admin']['user_id'];
				$this->db->insert('go_pages', $data);
				$id = $this->db->insert_id();
			} else { // PUT (Update)
				$data['Updated']   = date('Y-m-d H:i:s');
				$data['UpdatedBy'] = $_SESSION['admin']['user_id'];
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
			if(!isset($_SESSION['admin']['filters']['Pages-active-inactive'])) 
				$_SESSION['admin']['filters']['Pages-active-inactive'] = 1;

			$return = array();
			$return['rows'] = array();
			$return['keys'] = array();
			$return['keys']['key'] = array('Title','Slug');
			$return['keys']['col'] = array('1', '4','2'); // quantitiy for cols should be 1 more than keys, max 12

			$query = $this->db
				->select('ID,Title,Slug')
				->where('Status', $_SESSION['admin']['filters']['Pages-active-inactive'])
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

			$new_status = ($_SESSION['admin']['filters']['Pages-active-inactive'] == 1) ? 0 : 1;
			
			foreach ($post as $key => $value) {
				$data = array(
					'Status'    => $new_status,
					'Updated'   => date('Y-m-d H:i:s'),
					'UpdatedBy' => $_SESSION['admin']['user_id']
				);
				$this->db->where('ID', $key);
				$this->db->update('pages', $data);
			}

			$this->session->set_flashdata('flashSuccess', 'Record(s) have been successfully updated.');

			redirect(base_url() . 'admin/pages');
		}

	// AJAX

		public function update_display_status($post) {

			$_SESSION['admin']['filters']['Pages-active-inactive'] = $post['NewValue'];

		}

	// DESTROY (Delete)

}
