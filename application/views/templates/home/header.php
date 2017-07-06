	
</head>
<body>
<div class="container">
	<div class="row margin-top-30">
		<?php 
			if(isset($_SESSION['home']['client_logged_in'])) { ?>
			<div class="col-md-12 center">
				<img src="<?= base_url(); ?>assets\images\banner-logo.png" alt="banner logo - AMHphoto" class="img-fluid">
			</div>
		<?php } else { ?>
			<div class="col-md-9">
				<img src="<?= base_url(); ?>assets\images\banner-logo.png" alt="banner logo - AMHphoto" class="img-fluid">
			</div>
			<div class="col-md-3">
				<div id="navigation_panel">
					<div id="topmenu">				
						<ul>				
							<li><a href="http://www.amhphoto.com/portfolio" >PORTFOLIO</a></li>
							<li><a href="http://www.amhphoto.com/pricing" >PRICING</a></li>
							<li class="active"><a href="http://client.amhphoto.com" >CLIENT</a></li>
							<li><a href="http://www.amhphoto.com/contact" >CONTACT</a></li>
							<li><a href="http://www.amhphoto.com/about" >ABOUT</a></li></ul>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>