<div class="col-md-3">
	<div id="logo">
		<?php if($this->config->item('logo_location') != "") : ?>
			<a href="<?= base_url() . $this->config->item('logo_default_route'); ?>">
				<img class="img-responsive" style="margin-left: 0px;" src="<?php echo base_url() . 'assets/' . $this->config->item('logo_location'); ?>">
			</a>
		<?php endif; ?>
	</div>	
	<?php go_get_menu_items(2); ?>
</div>