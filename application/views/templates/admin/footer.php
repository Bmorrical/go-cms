<script>
	var showfooter = 0;
	var menuActiveClass = "<?= $this->session->userdata('menu_active_class'); ?>"; // gets set in GO_CONTROLLER/go_load_page()

	$(window).on('load', function(){
		positionFooter();
		$('li[class^="menu-"] .active').removeClass('active');
		if(menuActiveClass != "") $('.menu-' + menuActiveClass).addClass('active');
	});

	$(window).on('resize', function() {
		positionFooter();
	});

	function positionFooter() {
		if(showfooter == 1) {
			var docHeight = $(window).height();
			var footerHeight = $('#footer').height();
			var footerTop = $('#footer').position().top + footerHeight;
			if(footerTop < docHeight) $('#footer').css('margin-top', -24 + (docHeight - footerTop) + 'px');
		}		
	}
</script>

<?php 
	if($this->session->has_userdata('logged_in')) { ?>
	<script>showfooter = 1;</script>
	<br /><br />
		<div id="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3">
					</div>
					<div class="col-md-9 copyright">
						<p>&copy; <?php echo date('Y') . " " . $this->config->item('company_name'); ?> | All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
		
<?php } 

// echo "<pre>";
// var_dump($this->session->userdata);

?>
