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
	if($_POST) {
		$this->admin->post_user($_POST);
		return;
	} 
?>
<script>
	$(window).on('load', function(){
		$('#menu-id-1 li:nth-child(2)').css('backgroundColor', '#2674ac');
	});
</script>
<div class="container-fluid">
	<div class="row">
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-3">
					<h1>Add User</h1>
				</div>
				<div class="col-md-9">
					<div class="row actions pull-right">
						<button name="save" class="btn btn-primary" type="submit" form="form1">Save User</button>
						<button name="save-and-new" class="btn btn-primary" type="submit" form="form1">Save and New</button>
						<button name="save-and-close" class="btn btn-primary" type="submit" form="form1">Save and Close</button>
						<a href="<?php echo base_url(); ?>admin/users"><button type="button" class="btn btn-primary">Cancel</button></a>
					</div>
				</div>
			</div>
			<form id="form1" class="" method="post" action="<?php echo base_url() . 'admin/user/add'; ?>">
				<?php include_once(APPPATH . 'views/admin/go/users/form.php'); ?>
			</form>
		</div>
	</div>
</div>

