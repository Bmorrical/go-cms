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
<div class="container-fluid">
	<div class="row">
		<?php include_once(APPPATH . 'views/admin/helpers/sidebar.php'); ?>
		<div class="col-md-9 main-content-top-pad lab">
			<div class="row">
				<div class="col-md-3">
					<h1>Lab</h1>
				</div>
				<div class="col-md-9">
					<div class="row">
						<button name="save" class="btn btn-primary actions" type="submit" form="form1">Save</button>
						<a href="<?php echo base_url(); ?>admin/dashboard"><button type="button" class="btn btn-primary actions">Cancel</button></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div id="flashBlock">
						<?= go__flash(); ?>
					</div>
				</div>
			</div>			
			<form id="form1" class="" method="post" action="<?php echo base_url() . 'admin/lab'; ?>">
			<div class="row" style="margin-top: -35px;">
				<div class="col-md-12">
					<hr />
					<h2>Class Config</h2>
				</div>
			</div>				
				<div class="row">
					<div class="col-md-6">
						Class Name Plural<br /><span class="micro-1">(lowercase)</span>
					</div>
					<div class="col-md-6">
						<input name="class-name-plural" class="form-control" placeholder="clients" value="" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						Class Name Singular<br /><span class="micro-1">(lowercase)</span>
					</div>
					<div class="col-md-6">
						<input name="class-name-singular" class="form-control" placeholder="client" value="" />
					</div>
				</div>
			<div class="row">
				<div class="col-md-12">
					<hr />
					<h2>Database Config</h2>
				</div>
			</div>						
				<div class="row">
					<div class="col-md-6">
						DB Table Name<br /><span class="micro-1">(lowercase)</span>
					</div>
					<div class="col-md-6">
						<input name="table-name" class="form-control" placeholder="clients" value="" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						SQL Table Columns<br /><span class="micro-1">(no spaces after Comma)</span>
					</div>
					<div class="col-md-6">
						<input name="sql-table-columns" class="form-control" placeholder="UserName,Password,FirstName,LastName,Address,Address_2,City,State,Zip,Phone,Email" value="" />
					</div>
				</div>		
				<div class="row">
					<div class="col-md-6">
						SQL Table Columns - Friendly Names<br /><span class="micro-1">(space after comma doesn't matter)</span>
					</div>
					<div class="col-md-6">
						<input name="table-column-labels" class="form-control" placeholder="'User Name','Password','First Name','Last Name','Address','Address 2','City','State','Zip','Phone','Email'" value="" />
					</div>
				</div>		
			<div class="row">
				<div class="col-md-12">
					<hr />
					<h2>Overview Page</h2>
				</div>
			</div>		
				<div class="row">
					<div class="col-md-6">
						Overview Page Column Layout - Bootstrap<br /><span class="micro-1">(11 Available)</span>
					</div>
					<div class="col-md-6">
						<input name="column-layout" class="form-control" placeholder="'3', '3', '3'" value="" />
					</div>
				</div>		
				<div class="row">
					<div class="col-md-6">
						Overview Page SQL Table Columns<br /><span class="micro-1">(space after comma doesn't matter)</span>
					</div>
					<div class="col-md-6">
						<input name="overview-sql-cols" class="form-control" placeholder="UserName, FirstName, LastName" value="" />
					</div>
				</div>				
				<div class="row">
					<div class="col-md-6">
						Overview Page Columns - Friendly Names<br /><span class="micro-1">(space after comma doesn't matter)</span>
					</div>
					<div class="col-md-6">
						<input name="overiew-fields" class="form-control" placeholder="'User Name', 'First Name', 'Last Name'" value="" />
					</div>
				</div>		
			<div class="row">
				<div class="col-md-12">
					<hr />
					<h2>Menu Config</h2>
				</div>
			</div>
				<div class="row">
					<div class="col-md-6">
						Assigned Menu<br />&nbsp;
					</div>
					<div class="col-md-6">
						<select class="form-control" name="assigned-menu">
							<option value="0">Select</option>
							<?php
								foreach ($menus as $value) {
									echo "<option value='" . $value['MenuID'] . "'>" . $value['MenuName'] . "</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						Menu Name<br /><span class="micro-1">(Capitalize)</span>
					</div>
					<div class="col-md-6">
						<input name="menu-name" class="form-control" placeholder="Clients" value="" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						Menu URL<br />&nbsp;
					</div>
					<div class="col-md-6">
						<input name="menu-url" class="form-control" placeholder="admin/clients" value="" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						Icon<br />&nbsp;
					</div>
					<div class="col-md-6">
						<input name="menu-icon" class="form-control" placeholder="fa fa-users" value="" />
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						Active Class<br /><br /><br /><br />&nbsp;
					</div>
					<div class="col-md-6">
						<input name="active-class" class="form-control" placeholder="clients" value="" />
					</div>
				</div>					
			</form>
		</div>
	</div>
</div>

<?php

// echo "<pre>";
// var_dump($menus);

?>