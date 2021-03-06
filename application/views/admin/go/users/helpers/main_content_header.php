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

<div class="row main-content-top-pad">
	<div class="col-md-9">
		<h1>Manage <?= ucfirst($this_page_plural); ?></h1>
	</div>
	<div class="col-md-3 search">
		<select class="form-control" id="status">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>
</div>	

<div class="row">
	<div class="col-md-12">
		<a href="<?= base_url(); ?>admin/<?= $this_page_singular; ?>/add">
			<button type="button" class="btn btn-primary actions">
				Add New <?= ucfirst($this_page_singular); ?>
			</button>
		</a>	 

		<?php if($this->input->cookie("go-menu-" . $this->admin->users_page_id() . "-" . md5($this->config->item('go_admin_login_cookie'))) == 1) : ?>

			<button id="menu_activate_inactivate" type="submit" name="menu_activate_inactivate" class="btn btn-danger hidden actions" form="form1">
				Disable <?= ucfirst($this_page_singular); ?>(s)
			</button>	

		<?php else : ?>

			<button id="menu_activate_inactivate" type="submit" name="menu_activate_inactivate" class="btn btn-success hidden actions" form="form1">
				Enable <?= ucfirst($this_page_singular); ?>(s)
			</button>		

		<?php endif; ?>

	</div>					
</div>				

<script>

	var base_url = '<?= base_url(); ?>';

	var menu_active_inactive = '<?= $this->input->cookie("go-menu-" . $this->admin->users_page_id() . "-" . md5($this->config->item('go_admin_login_cookie'))); ?>';

	if(menu_active_inactive == "") location.reload();  // force a reload so the cookie can be picked up, created in model

	$(window).on('load', function(){

		$('#status').val(menu_active_inactive).prop('selected', true); // set Active/Inactive drop down

		$('#toggle-all-master').on('change', function () {
			if($(this).is(':checked')) {
				$('input.check-toggle').each(function () {
					$(this).prop('checked', true)
				})
			} else {
				$('input.check-toggle').each(function () {
					$(this).prop('checked', false)
				})				
			}
		});

		$('.check-toggle, #toggle-all-master').on('change', function() {
			if ($('input[type=checkbox]').is(":checked")) {
				$('#menu_activate_inactivate').removeClass('hidden');
				$('#emailBtn, #printBtn').show();
			} else {
				$('#menu_activate_inactivate').addClass('hidden');	
				$('#emailBtn, #printBtn').hide();							
			}
		});

		$('#status').on('change', function() {
			if($("#status").val() == 0) { var new_value = 0; } else { var new_value = 1; }
			$.ajax({
				url  : base_url + 'admin/ajax_users_update_display_status',
				type : 'POST',
				data: {
					NewValue : new_value
				},
				success: function(d) {
					location.reload();	
				}
			})
		})

	})

</script>