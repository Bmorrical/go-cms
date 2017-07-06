<div class="row">
	<div class="col-md-2">
		Username
	</div>
	<div class="col-md-6">
		<input class="form-control" name="username" type="text" value="<?php 
			if(isset($user[0]['Username'])) {
				echo $user[0]['Username']; 
			} else if (null !== $this->input->get('username')) {
				echo $this->input->get('username');
			}
		?>">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Password
	</div>
	<div class="col-md-6">
		<input class="form-control" name="password" type="password">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Verify Password
	</div>
	<div class="col-md-6">
		<input class="form-control" name="verify-password" type="password">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		First Name
	</div>
	<div class="col-md-6">
		<input class="form-control" name="firstname" type="text" value="<?php 
			if(isset($user[0]['Firstname'])) {
				echo $user[0]['Firstname']; 
			} else if (null !== $this->input->get('firstname')) {
				echo $this->input->get('firstname');
			}
		?>">
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Last Name
	</div>
	<div class="col-md-6">
		<input class="form-control" name="lastname" type="text" value="<?php 
			if(isset($user[0]['Lastname'])) {
				echo $user[0]['Lastname']; 
			} else if (null !== $this->input->get('lastname')) {
				echo $this->input->get('lastname');
			}
		?>">
	</div>
</div>