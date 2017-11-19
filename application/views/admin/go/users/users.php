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

	/** THIS PAGE IS ONLY ACCESSIBLE IF USER IS SUPER ADMIN, PROTECTED IN GO_CONTROLLER */

	$this_page_singular = 'user'; // defined for text html
	$this_page_plural = 'users'; 
	$this_page_results = $users; // defined as result array back from controller
?>
<div class="container-fluid">
	<div class="row">
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class="col-md-9">

			<?php include_once(APPPATH . 'views/admin/go/users/helpers/main_content_header.php'); ?>
			
			<form id="form1" name="data-list" class="" method="post" action="<?php echo base_url() . 'admin/' . $this_page_plural; ?>">	

				<?php if(empty($this_page_results['rows'])) : ?>

					<div class="row">
						<div class="col-md-12">
							<p>No records found!</p>
						</div>
					</div>

				<?php else : ?>

					<div class='row detailRow'>

						<div class='col-md-1 center'>
							<input id="toggle-all-master" type="checkbox" name="check-toggle-master" value="0">
						</div>

						<div class='col-md-2'>
							Username
						</div>	

						<div class='col-md-2'>
							First Name
						</div>

						<div class='col-md-2'>
							Last Name
						</div>

						<div class='col-md-2'>
							User Type
						</div>							
									
						<div class='col-md-3'>
							Last Login
						</div>

					</div>	

					<?php $count = 1; ?>

					<?php foreach($users['rows'] as $user) :  ?>

						<div class='row<?php if($count % 2) {echo " even";} ?>'>

							<div class='col-md-1 center'>
								<input class="check-toggle" type="checkbox" name="<?= $user['ID']; ?>">
							</div>

							<div class='col-md-2'>
								<a href='<?= base_url() . "admin/user/edit?id=" . $user['ID']; ?>'> <?= $user['Username']; ?></a>
							</div>

							<div class='col-md-2'>
								<?= $user['Firstname']; ?>
							</div>

							<div class='col-md-2'>
								<?= $user['Lastname']; ?>
							</div>

							<div class='col-md-2'>
								<?= $user['UserType']; ?>
							</div>

							<div class='col-md-3'>

								<?php if($user['LastLogin']) : ?>
								 	<?= date('F d, Y -- h:i A', strtotime($user['LastLogin'])); ?>
								<?php else : ?>
								 	<?= "Never"; ?>
								<?php endif; ?>

							</div>

						</div>

						<?php $count++; ?>

					<?php endforeach; ?>

				<?php endif; ?>

			</form>
		</div>
	</div>
</div>

<script>

	var userID = "<?= $this->session->userdata('user_id'); ?>";
	var base_url = '<?= base_url(); ?>';

	$(window).on("load", function() {

		$('.status').on('click', function() {

			$('#flashBlock').empty();
			
			var id = $(this).attr('id').split('-');
			
			if(id[1] == userID) {

				$('#flashBlock').append(
					$('<div>', {
						class: 'flash alert alert-warning', 
						text: 'You are not allowed to disable your own user account.  Please contact a site administrator for assistance.'
					}
				))

			} else {

				if($(this).hasClass('published')) {var status = 0 } else { var status = 1};
				
				$.ajax({
					url : base_url + 'admin/ajax_set_user_status',
					type : 'POST',
					dataType : 'JSON',
					data : {
						UserID : id[1],
						Status : status
					},
					success 	: function(d) {	
						location.reload(); 
					}
				})
			}
		})
	})
</script>