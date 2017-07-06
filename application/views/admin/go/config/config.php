<div class="container-fluid">
	<div class="row">
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class="col-md-9 main-content-top-pad">
			<div class="row">
				<div class="col-md-3">
					<h1>Configuration</h1>
				</div>
				<div class="col-md-9">
					<div class="row">
						<!-- <button name="save" class="btn btn-primary actions" type="submit" form="form1">Save</button> 
						<a href="<?php echo base_url(); ?>admin/dashboard"><button type="button" class="btn btn-primary actions">Cancel</button></a>-->
					</div>
				</div>
			</div>
			<form id="form1" class="" method="post" action="<?php echo base_url() . 'admin/'; ?>">
				<?php // include_once(APPPATH . 'views/admin/go/users/form.php'); ?>
			</form>
		</div>
	</div>
</div>