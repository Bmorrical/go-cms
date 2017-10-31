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

?>
<!DOCTYPE html> 
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon" />

		<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/css/go_normalize.css">	
		<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/dropzone/dropzone.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/css/bootstrap-toggle.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/css/go_default.css">			
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/styles.css">

    	<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="<?php echo base_url(); ?>assets/go/dropzone/dropzone.js"></script>
		<script src="<?php echo base_url(); ?>assets/go/js/bootstrap-toggle.js"></script>
		<script src="<?php echo base_url(); ?>assets/go/js/waiting-dialogue.js"></script>

		<title><?php echo htmlspecialchars($title); ?></title>

		<?php 
			$this->load->view('templates/admin/header'); 
			$this->load->view($page, $queries);
			$this->load->view('templates/admin/footer'); 
		?>
	</body>
</html>