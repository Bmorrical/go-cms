<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html> 
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />

		<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/css/go_normalize.css">		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/go/css/go_default.css">			

    	<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>

		<title><?php echo htmlspecialchars($title); ?></title>

		<?php 
			$this->load->view('templates/home/header'); 
			$this->load->view($page, $queries);
			$this->load->view('templates/home/footer'); 
		?>

	</body>
</html>