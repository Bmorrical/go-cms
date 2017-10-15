<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan to
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

	/** 
	 *  User is verified before rendering page 
	 *  User will be redirected if not validated
	 */

?>	
<?php if(!empty($_SESSION['admin']) && $this->input->cookie("go-admin-hash") === $_SESSION['admin']['hash']) : ?>

	</head>
	<body>

	<div id="header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 welcome">
					<?php echo "Welcome, " . $_SESSION['admin']['first_name'] . " " . $_SESSION['admin']['last_name']; ?>
				</div>
				<div class="col-md-9">
					<div id="toggle-btn">
						<i class="fa fa-bars"></i>
					</div>
					<?php go_get_menu_items(1); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>