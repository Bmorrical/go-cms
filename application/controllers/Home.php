<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends GO_Home_Controller {

	public function __construct(){
		parent::__construct();
		// if(!$this->session->has_userdata('client_logged_in')) show_404();
		$this->load->model('home_model','home');
	}

	public function my_photos() {	
		$this->verify_session(2);
		if($_POST) {
            $_SESSION['home']['continue_clicked'] = $_POST['ContinueClicked'];                              
            $_SESSION['home']['payment_option']   = $_POST['PaymentOption'];
            $_SESSION['home']['shipping_option']  = $_POST['ShippingOption'];
            $_SESSION['home']['first_name']       = $_POST['FirstName'];
            $_SESSION['home']['last_name']        = $_POST['LastName'];
            $_SESSION['home']['address']          = $_POST['Address'];
            $_SESSION['home']['address_2']        = $_POST['Address_2'];
            $_SESSION['home']['city']             = $_POST['City'];
            $_SESSION['home']['state']            = $_POST['State'];
            $_SESSION['home']['zip']              = $_POST['Zip'];
            $_SESSION['home']['phone']            = $_POST['Phone'];
            $_SESSION['home']['email']            = $_POST['Email'];			
            redirect(base_url() . 'client/my-photos');
		}
		$data = array(
			'gallery_data' => $this->home->get_gallery_data(),
			'options_data' => $this->home->get_options_data(),
			'cart_data'    => $this->home->get_cart_data()
		);
		$this->go_load_page(array('page'=>'home/dashboard/my_photos','title'=>'AMHphoto - My Photos','template'=>'home','activeClass'=>'my-photos','data'=>$data));
	}

	public function my_photos_2() {	
		$this->verify_session(2);
		if($_POST) {
            $_SESSION['home']['continue_clicked'] = $_POST['ContinueClicked'];                              
            $_SESSION['home']['payment_option']   = $_POST['PaymentOption'];
            $_SESSION['home']['shipping_option']  = $_POST['ShippingOption'];
            $_SESSION['home']['first_name']       = $_POST['FirstName'];
            $_SESSION['home']['last_name']        = $_POST['LastName'];
            $_SESSION['home']['address']          = $_POST['Address'];
            $_SESSION['home']['address_2']        = $_POST['Address_2'];
            $_SESSION['home']['city']             = $_POST['City'];
            $_SESSION['home']['state']            = $_POST['State'];
            $_SESSION['home']['zip']              = $_POST['Zip'];
            $_SESSION['home']['phone']            = $_POST['Phone'];
            $_SESSION['home']['email']            = $_POST['Email'];			
            redirect(base_url() . 'client/my-photos');
		}
		$data = array(
			'gallery_data' => $this->home->get_gallery_data(),
			'options_data' => $this->home->get_options_data(),
			'cart_data'    => $this->home->get_cart_data()
		);
		$this->go_load_page(array('page'=>'home/dashboard/my_photos','title'=>'AMHphoto - My Photos','template'=>'home','activeClass'=>'my-photos','data'=>$data));
	}

	public function cart() {
		$this->verify_session(2);
		$data = array(
			'gallery_data' => $this->home->get_gallery_data(),
			'options_data' => $this->home->get_options_data(),			
			'cart_data'    => $this->home->get_cart_data()
		);
		$this->go_load_page(array('page'=>'home/cart/cart','title'=>'AMHphoto - Cart','template'=>'home','activeClass'=>'cart','data'=>$data));		
	}

	public function confirmation() {
		$this->verify_session(2);
		$data = array();
		$this->go_load_page(array('page'=>'home/confirmation','title'=>'AMHphoto - Order Confirmation','template'=>'home','activeClass'=>'confirmation','data'=>$data));		
	}	

	// Ajax

	public function save_cart_to_server() {
		$this->verify_session(2);
		echo json_encode($this->home->save_cart_to_server($this->input->post()));
	}

	public function ajax_get_session() {
		$this->verify_session(2);
		echo json_encode($this->home->ajax_get_session($this->input->post()));
	}

	public function save_order_to_server() {
		$this->verify_session(2);
		echo json_encode($this->home->save_order_to_server($this->input->post()));
	}

}