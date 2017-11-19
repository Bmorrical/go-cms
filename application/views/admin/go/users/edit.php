<?php
	//////////////////////////////// core file ///////////////////////////////
	///////////////////////////////// go-cms /////////////////////////////////

		/**
		 *  This is a core go-cms file.  Do not edit if you plan to
		 *  ever update your go-cms version.  Changes would be lost.
		 */

	//////////////////////////////// core file ///////////////////////////////
	///////////////////////////////// go-cms /////////////////////////////////
?>
	<?php
// Start Page Config
    	$this_page_singular = 'user'; // defined for text html
    	$this_page_plural = 'users';
    	$this_page_type = 'edit';
    	$this_page_results = $page; // defined as result array back from controller
// End Page Config
	?>
<div class='container-fluid'>
	<div class='row'>
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class='col-md-9'>
			<?php
				include_once(APPPATH . 'views/admin/go/users/helpers/main_content_add_edit_header.php');
			?>
			<form id="form1" class="" method="post" action="<?php echo base_url() . 'admin/user/edit?id=' . $this->input->get('id'); ?>">			
				<?php include_once(APPPATH . 'views/admin/go/users/form.php'); ?>
			</form>
		</div>
	</div>
</div>
