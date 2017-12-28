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

class Pages extends GO_Admin_Controller {

	public function __construct(){
		parent::__construct();

		/** Validate the user should be able to access this resource */
		
	        if(empty($_SESSION['admin']) || $this->input->cookie("go-admin-hash") !== $_SESSION['admin']['hash']) {
	            redirect(base_url() . "admin/login");
	        }

		$this->load->model('pages_model','page');

	}

	// PUT (Create)

		public function page_add() {
			$data = array(
				'page' => $this->page->go_get_one(0)
			);
			$this->go_load_page(array('page'=>'admin/pages/add','title'=>'Add Page','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// GET (Read)

		public function pages() {
			if($_POST && (isset($_POST['save']) || isset($_POST['save-and-new']) || isset($_POST['save-and-close']))) {
				$id = 0;
				if(!empty($this->input->get('id'))) $id = $this->input->get('id'); 
				$this->page->post_data($_POST, $id);
			}
			
			if(($_POST && isset($_POST['menu_activate_inactivate']))) $this->page->activate_inactivate($_POST);  // Toggle Active/Inactive

			$data = array(
				'pages' => $this->page->go_get_all()
			);

			$this->go_load_page(array('page'=>'admin/pages/pages','title'=>'Pages','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// PUT (Update)

		public function page_edit() {
			$data = array(
				'page' => $this->page->go_get_one($this->input->get('id'))
			);
			$this->go_load_page(array('page'=>'admin/pages/edit','title'=>'Edit Page','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// AJAX
		/**
		 *  When updating Active/Inactive menu from Users page
		 */

		public function ajax_update_display_status() {
			if(!go__is_ajax_request()) return;
			echo json_encode($this->page->ajax_update_display_status($this->input->post()));
		}

}
