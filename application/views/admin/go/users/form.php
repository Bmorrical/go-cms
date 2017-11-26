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
<div class="row">
	<div class="col-md-2">
		Username
	</div>
	<div class="col-md-6">
		<input 
			class='form-control required' 
			name='Username' 
			type='text' 
			value='<?php if(isset($user['Username'])) echo $user['Username']; ?>'

			<?php if($_SESSION['admin']['session_type'] != 1) : ?>	
				disabled='true'
			<?php endif; ?>
		>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Password
	</div>
	<div class="col-md-6">
		<input id="password" class="form-control" name="Password" type="password">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Verify Password
	</div>
	<div class="col-md-6">
		<input id="verify-password" class="form-control" name="Verify-Password" type="password">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		First Name
	</div>
	<div class="col-md-6">
		<input class='form-control required' name='Firstname' type='text' value='<?php if(isset($user['Firstname'])) echo $user['Firstname']; ?>'>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Last Name
	</div>
	<div class="col-md-6">
		<input class='form-control required' name='Lastname' type='text' value='<?php if(isset($user['Lastname'])) echo $user['Lastname']; ?>'>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Email
	</div>
	<div class="col-md-6">
		<input class='form-control' name='Email' type='text' value='<?php if(isset($user['Email'])) echo $user['Email']; ?>'>
	</div>
</div>

<input type="hidden" id="post-action" name='Dynamic'>

<?php 
// var_dump($_SESSION);
