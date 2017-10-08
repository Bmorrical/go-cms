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
<div class='row'>
	<div class='col-md-1 right'>
		Title
	</div>
	<div class='col-md-5'>
		<input class='form-control' name='Title' type='text' value='<?php if(isset($page['values']['Title'])) echo $page['values']['Title']; ?>'>
	</div>
	<div class='col-md-1 right'>
		Slug
	</div>
	<div class='col-md-5'>
		<input class='form-control' name='Slug' type='text' value='<?php if(isset($page['values']['Slug'])) echo $page['values']['Slug']; ?>'>
	</div>
</div>
<div class='row'>
	<div class='col-md-1 right'>
		Content
	</div>
	<div class='col-md-11'>
		<textarea id="Content" name="Content">
			<?php if(isset($page['values']['Content'])) echo $page['values']['Content']; ?>
		</textarea>
	</div>
</div>