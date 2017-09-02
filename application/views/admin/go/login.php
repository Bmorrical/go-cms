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
<style>
	body {
		background-color: #f5f5f4;
	} 
    .login-border {
        border: 1px solid #cccccc;
        border-radius: 10px;
        background-color: #fff;
    }
    .login-padding {
        padding: 20px 50px 50px 50px;
    }
    .login-copyright {
        text-align: center;
        margin-top: 15px;
    }	  
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 login-border">
			<div class="login-padding">		
				<div class="logo">
					<?php if($this->config->item('go_logo_location') != "") : ?>						
						<img class="img-responsive" src="<?php echo base_url() . 'assets/' . $this->config->item('go_logo_location'); ?>">
					<?php endif; ?>					
				</div>
				<form method="post" action="<?php echo base_url() . 'admin/login?go=' . $this->config->item('go_login_key'); ?>">
					<fieldset class="form-group">
						<label class="" for="username">Username</label>
						<input id="username" name="username" class="form-control" type="text" autofocus="" placeholder="Username" value="<?php if($this->config->item('go_environment') == 'DEVELOPMENT' && null != $this->config->item('go_dev_admin_login_username')) echo $this->config->item('go_dev_admin_login_username'); ?>" required="">
					</fieldset>
					<fieldset class="form-group">
						<label class="" for="password">Password</label>
						<input id="password" name="password" class="form-control" type="password" placeholder="Password" value="<?php if($this->config->item('go_environment') == 'DEVELOPMENT' && null != $this->config->item('go_dev_admin_login_username')) echo $this->config->item('go_dev_admin_login_password'); ?>" required="">		
					</fieldset>
					<fieldset class="form-group">
						<button class="btn btn-primary" type="submit">Sign in</button>
					</fieldset>
				</form>
			</div><!-- end login-padding -->
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class="col-md-4 col-md-offset-4 login-copyright">
			<p>&copy; <?php echo date('Y') . " " . $this->config->item('go_company_name'); ?> | All Rights Reserved</p>
			<?php echo "<p>Powered by <a href='http://go-cms.org' target='_blank'>go-cms</a> built on <a href='https://github.com/bcit-ci/CodeIgniter' target='_blank'>CodeIgniter</a></p>"; 
			?>
		</div>
	</div>
</div>
<script>

	/**
	 *	Vertical aligns login to the middle of the page minus 60 pixels
	 */

	function calc_height() {
		var windowHeight = $(document).height();
		var loginHeight = $('.login-border').height();
		var loginMargin = ((windowHeight - loginHeight) / 2) - 60;
		$('.login-border').css("margin-top", loginMargin);	
	}

	$(window).resize(function() {
		calc_height();
	});

	$(window).on('load', function() {
		calc_height();
	});

</script>