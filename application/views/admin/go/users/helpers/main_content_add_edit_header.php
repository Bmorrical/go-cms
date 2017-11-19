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
				<button type="button" name="save" class="btn btn-primary actions" form="form1">
					Cancel
				</button>
			</a>
			<button type="submit" name="save-and-close" class="btn btn-primary actions" form="form1">
				Save and Close
			</button>	
			<button type="submit" name="save-and-new" class="btn btn-primary actions" form="form1">
				Save and New
			</button>		

		<?php endif; ?>

		<button type="submit" name="save" class="btn btn-primary actions" form="form1">
			Save <?= ucfirst($this_page_singular); ?>
		</button>	

	</div>					
</div>				
<div class="clear"></div>
