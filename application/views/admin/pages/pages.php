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
	<?php
// Start Page Config
    	$this_page_singular = 'page'; // defined for text html
    	$this_page_plural = 'pages';
    	$this_page_results = $pages; // defined as result array back from controller
// End Page Config

	?>
<div class='container-fluid'>
	<div class='row'>
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class='col-md-9'>
			<?php
				include_once(APPPATH . 'views/admin/pages/helpers/main_content_header.php');
				if(!empty($this_page_results['rows'])) { ?>
					<div class='row detailRow'>
						<div class='col-md-1 center'>
							<input id='toggle-all-master' type='checkbox' value='0'>
						</div>
						<?php
						// HEADER
							// This loop looks in the Key and Col array from Model to handle Bootstrap column HTML
							$column_count = 1; // starts at 1 to skip the checkbox col
							foreach($this_page_results['keys']['key'] as $val) {  ?>
								<div class="col-md-<?= $this_page_results['keys']['col'][$column_count]; ?>">
									<?= $val; ?>
								</div>
							<?php
								$column_count++;
							}
						?>
					</div>
					<?php
					// RESULTS
					$row_count = 1;
					foreach($this_page_results['rows'] as $key => $val) {
						$array_keys = array_keys($val); // allows calling associative array by keys
						?>
						<div class="row<?php if($row_count % 2) {echo ' even';} ?>">
							<div class='col-md-1 center'>
								<input class='check-toggle' type='checkbox' name="<?= $val['ID']; ?>">
							</div>
								<?php
									// This loop looks in the Key and Col array from Model to handle Bootstrap column HTML
									$column_count = 1; // starts at 1 to skip the checkbox col
									foreach($this_page_results['keys']['key'] as $val2) {  ?>
										<div class="truncate col-md-<?= $this_page_results['keys']['col'][$column_count]; ?>">
											<?php
												if($column_count == 1) {
													echo '<a href="' . base_url() . 'admin/' . $this_page_singular . '/edit?id=' .  $val['ID'] . '">';
														echo $val[$array_keys[$column_count]];
													echo '</a>';
												} else {
													if(is_null($val[$array_keys[$column_count]]) || $val[$array_keys[$column_count]] == '') {
														echo '';
													} else {
														echo $val[$array_keys[$column_count]];
													}
												}
											?>
										</div>
									<?php
										$column_count++;
									}
						echo '</div>'; // close row
					$row_count++;
					}
				}
			?>
			</form>
		</div>
	</div>
</div>
