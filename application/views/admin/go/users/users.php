<?php
	$this_page_singular = 'user'; // defined for text html
	$this_page_plural = 'users'; 
	$this_page_results = $users; // defined as result array back from controller
?>
<script>
	var userID = "<?= $this->session->userdata('user_id'); ?>";
	var base_url = '<?= base_url(); ?>';
	$(window).on("load", function(){
		$('.status').on('click', function() {
			$('#flashBlock').empty();
			var id = $(this).attr('id').split('-');
			if(id[1] == userID) {
				$('#flashBlock').append($('<div>', {class: 'flash alert alert-warning', text: 'You are not allowed to disable your own user account.  Please contact a site administrator for assistance.'}));
			} else {
				if($(this).hasClass('published')) {var status = 0 } else { var status = 1};
				$.ajax({
					url 		: base_url + 'admin/ajax_set_user_status',
					type 		: 'POST',
					dataType 	: 'JSON',
					data 		: {
									UserID : id[1],
									Status : status
					},
					success 	: function(d) {	
						location.reload(); 
					}
				})
			}
		});
	});
</script>
<div class="container-fluid">
	<div class="row">
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class="col-md-9">
			<?php include_once(APPPATH . 'views/admin/go/users/helpers/main_content_header.php'); ?>

			<?php
				if(!empty($this_page_results)) { ?>	
					<div class='row detailRow'>
						<div class='col-md-1 center'>
							<input id="toggle-all-master" type="checkbox" name="check-toggle-master" value="0">
						</div>						
						<div class='col-md-3'>
							Username
						</div>						
						<div class='col-md-3'>
							Name
						</div>
						<div class='col-md-3'>
							Last Login
						</div>
					</div>	
					<?php
						$count = 1;
						foreach($users['rows'] as $u) {  ?>
							<div class='row<?php if($count % 2) {echo " even";} ?>'>
								<div class='col-md-1 center'>
									<input class="check-toggle" type="checkbox" name="<?= $u['ID']; ?>">
								</div>
								<div class='col-md-3'>
									<a href='<?= base_url() . "admin/user/edit?id=" . $u['ID']; ?>'> <?= $u['Username']; ?></a>
								</div>
								<div class='col-md-3'>
									<?= $u['Firstname'] . " " . $u['Lastname']; ?>
								</div>
								<div class='col-md-3'>
									<?php
									 	if($u['LastLogin']) {
									 		echo date('F d, Y -- h:i A', strtotime($u['LastLogin']));
									 	} else {
									 		echo "Never";
									 	}
									?>
								</div>
							</div>
							<?php
							$count++;
						}
				}
			?>
		</div>
	</div>
</div>
<?php
// echo "<pre>";
// var_dump($users);
?>