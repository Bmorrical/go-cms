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

    /** 
     *  User is verified before rendering page 
     *  User will be redirected if not validated
     */

?>  
<?php if(!empty($_SESSION['admin']) && $this->input->cookie("go-admin-hash") === $_SESSION['admin']['hash']) : ?>
	<div class="col-md-3">
		<div id="side-toggle">
			<i class="fa fa-bars"> Menu</i>
		</div>
		<div id="logo">
			<?php if($this->config->item('go_logo_location') != "") : ?>
				<a href="<?= $this->config->item('base_url'); ?>" target="_blank">
					<img class="img-responsive" style="text-align: center;" src="<?php echo base_url() . 'assets/' . $this->config->item('go_logo_location'); ?>">
				</a>
			<?php endif; ?>
		</div>	
		<?php go_get_menu_items(2); ?>

		<div id="flash-block-container">
			<div id="flashBlock">
				<?= go__flash(); ?>
			</div>
		</div>	

	</div>
<?php endif; ?>	
