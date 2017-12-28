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
	<div class="col-md-4">
		<h1><?= ucfirst($this_page_type) . " " . ucfirst($this_page_singular); ?></h1>
	</div>
	<div class="col-md-8">

		<?php if($_SESSION['admin']['session_type'] == 1) : ?>

			<a href="<?= base_url(); ?>admin/<?= $this_page_plural; ?>">
				<button type="button" name="save" class="btn btn-primary actions">
					Cancel
				</button>
			</a>

			<button type="button" name="save-and-close" class="btn btn-primary actions btn-validate">
				Save and Close
			</button>	

			<button type="button" name="save-and-new" class="btn btn-primary actions btn-validate">
				Save and New
			</button>		

		<?php endif; ?>

		<button type="button" name="save" class="btn btn-primary actions btn-validate">
			Save <?= ucfirst($this_page_singular); ?>
		</button>	

	</div>					
</div>				
<div class="clear"></div>

<script>
	$(window).on("load", function() {

		$(".btn-validate").on('click', function(e) {

			$('.has-error').removeClass('has-error');			

			if( ($("#password").val() != "" || $("#verify-password").val() != "") 
			 &&	$("#password").val() !== $("#verify-password").val()
			){
				$("#password, #verify-password").addClass('has-error');
			}

			$('.required').each(function() {

				if($(this).val() == "") $(this).addClass('has-error');

			})

			if($('.has-error').length == 0) {

				switch($(this).attr('name')) {
					case "save-and-close" :
						$('#post-action').attr("name", "save-and-close");
						break;
					case "save-and-new" :
						$('#post-action').attr("name", "save-and-new");
						break;
					case "save" :
						$('#post-action').attr("name", "save");
						break;
				}

				$("#form-users").submit();
			}

		})
		
	})
</script>