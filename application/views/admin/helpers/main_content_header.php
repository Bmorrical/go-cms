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
<?php // $session_key = $_SESSION['admin']['filters']['<<page plural>>-active-inactive']; ?>
<script>
    var display_status = "<?= $session_key; ?>"; // gets set in model get_display_status()

	$(window).on('load', function(){

        $('#status').val(display_status).prop('selected', true); // set Active/Inactive drop down

		$('#toggle-all-master').on('change', function () {
			if($(this).is(':checked')) {
				$('input.check-toggle').each(function () {
					$(this).prop('checked', true)
				})
			} else {
				$('input.check-toggle').each(function () {
					$(this).prop('checked', false)
				})				
			}
		});
		$('.check-toggle, #toggle-all-master').on('change', function() {
			if ($('input[type=checkbox]').is(":checked")) {
				$('#toggleDisplay').removeClass('hidden');
				$('#emailBtn, #printBtn').show();
			} else {
				$('#toggleDisplay').addClass('hidden');	
				$('#emailBtn, #printBtn').hide();							
			}
		});
		$('#status').on('change', function() {
			if($("#status").val() == 0) { var new_value = 0; } else { var new_value = 1; }
			$.ajax({
				url  : '<?= base_url() . $this_page_plural; ?>/update-display-status',
				type : 'POST',
				data: {
					NewValue : new_value
				},
				success: function(d) {
					location.reload();	
				}
			})
		});		
	});
</script>

<div class="row main-content-top-pad">
	<div class="col-md-9">
		<h1>Manage <?= parse_class_name_as_friendly($this_page_plural); ?></h1>
	</div>
	<div class="col-md-3 search">
		<select class="form-control" id="status">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>
<!-- 	<div class="col-md-3 search">
		<form id="form-search" method="post" action="<?php // echo base_url() . 'admin/' . $this_page_plural; ?>">
			<input type="text" class="form-control search-field" placeholder="Search..." name="search-text">
		</form>
	</div> -->
</div>
<div class="row">
    <div class="col-md-12">
        <?php $sef_plural = str_replace("_","-", $this_page_plural); ?>
        <?php $sef_single = str_replace("_", "-", $this_page_singular); ?>

        <a href="<?= base_url(); ?>admin/<?= $sef_single; ?>/add">
            <button type="button" class="btn btn-primary actions">
                Add New <?= parse_class_name_as_friendly($this_page_singular); ?>
            </button>
        </a>
        <?php if($session_key == 1) : ?>
            <button id="toggleDisplay" type="submit" name="toggleDisplay" class="btn btn-danger hidden actions" form="form1">
                Disable <?= parse_class_name_as_friendly($this_page_singular); ?>(s)
            </button>
        <?php else : ?>
            <button id="toggleDisplay" type="submit" name="toggleDisplay" class="btn btn-success hidden actions" form="form1">
                Enable <?= parse_class_name_as_friendly($this_page_singular); ?>(s)
            </button>
        <?php endif; ?>
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
	if(empty($this_page_results['rows'])) { ?>
		<div class="row">
			<div class="col-md-12">
				<p>No records found!</p>
			</div>
		</div>
<?php } ?>
<form id="form1" name="data-list" class="" method="post" action="<?php echo base_url() . 'admin/' . $sef_plural; ?>">