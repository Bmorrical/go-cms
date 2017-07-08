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
    }	  
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 login-border">
			<div class="login-padding">		
				<div class="logo">
					<img class="img-responsive" src="<?php echo base_url() . 'assets/' . $this->config->item('logo_location'); ?>">
				</div>
				<form class="" method="post" action="<?php echo base_url() . 'admin/login?go=' . $this->config->item('go_login_key'); ?>">
					<fieldset class="form-group">
						<label class="" for="username">Username</label>
						<input id="username" name="username" class="form-control" type="text" autofocus="" placeholder="Username" value="<?php if($this->config->item('environment') == 'DEVELOPMENT' && null != $this->config->item('dev_admin_login_username')) echo $this->config->item('dev_admin_login_username'); ?>" required="">
					</fieldset>
					<fieldset class="form-group">
						<label class="" for="password">Password</label>
						<input id="password" name="password" class="form-control" type="password" placeholder="Password" value="<?php if($this->config->item('environment') == 'DEVELOPMENT' && null != $this->config->item('dev_admin_login_username')) echo $this->config->item('dev_admin_login_password'); ?>" required="">		
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
			<p>&copy; <?php echo date('Y') . " " . $this->config->item('company_name'); ?> | All Rights Reserved</p>
			<?php if($this->config->item('environment') == 'DEVELOPMENT') echo "<p><a href='https://github.com/bcit-ci/CodeIgniter' target='_blank'>CodeIgniter version " . CI_VERSION . "</a></p>"; ?>
		</div>
	</div>
</div>
<!-- <div id="footer">fixing jquery bug, only shows for login, leave this code  </div> -->

<script>
	function calc_height() {
		var windowHeight = $(document).height();
		var loginHeight = $('.login-border').height();
		var loginMargin = ((windowHeight - loginHeight) / 2) - 40;
		$('.login-border').css("margin-top", loginMargin);	
	}
	$(window).resize(function() {
		calc_height();
	});
	$(window).on('load', function() {
		calc_height();
	});
</script>