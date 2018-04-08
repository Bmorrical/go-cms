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
<?php $sef_plural = str_replace("_","-", $this_page_plural); ?>
<?php $sef_single = str_replace("_", "-", $this_page_singular); ?>
<?php $lang_single = str_replace("_", " ", $this_page_singular); ?>
<div class="row main-content-top-pad">
    <div class="col-md-4">
        <h1><?= ucwords($this_page_type) . " " . ucwords($lang_single); ?></h1>
    </div>
    <div class="col-md-8">
        <a href="<?= base_url(); ?>admin/<?= $sef_plural; ?>">
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
        <button type="submit" name="save" class="btn btn-primary actions" form="form1">
            Save <?= ucfirst($lang_single); ?>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="flashBlock">
            <?php go__flash(); ?>
        </div>
    </div>
</div>
<?php 
	$save_route = (!empty($this->input->get('id'))) ? "?id=" . $this->input->get('id') : "";
?>
<form id="form1" name="data-list" class="" method="post" action="<?php echo base_url() . 'admin/' . $sef_plural . $save_route; ?>">