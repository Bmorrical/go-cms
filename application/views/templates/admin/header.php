	
</head>
<body>
<?php 
	if($this->session->has_userdata('logged_in')) { ?>
		<div id="header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3 welcome">
						<?php echo "Welcome, " . $this->session->userdata('name'); ?>
					</div>
					<div class="col-md-9">
						<div id="toggle-btn">
							<i class="fa fa-bars"></i>
						</div>
						<?php go_get_menu_items(1); ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>