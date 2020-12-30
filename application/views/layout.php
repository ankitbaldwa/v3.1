<!DOCTYPE HTML>
<html>
	<head>
		<title><?= TITLE ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta property="og:image" itemprop="image" content="<?= base_url() ?>/assets/dist/img/Accordance_logo.png" />
		<meta name="description" content="Increase your output, minimize mistakes and save time with ACCORDANCE Features">
		<meta name="author" content="Accordance">
                <!--====== Favicon Icon ======-->
                <link rel="shortcut icon" href="https://accordance.co.in/assets/images/favicon.png" type="image/png">
		<!-- Bootstrap 3.3.7 -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
		  <!-- iCheck -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/square/blue.css">
		  <!-- AdminLTE Skins. Choose a skin from the css/skins
		       folder instead of downloading all of them to reduce the load. -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/jquery-confirm.min.css">
		  <!-- Morris chart -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/morris.js/morris.css">
		  <!-- jvectormap -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
		  <!-- Date Picker -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		  <!-- Daterange picker -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
		  <!-- bootstrap wysihtml5 - text editor -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
		  <!-- DataTables -->
			<link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
			<!-- Select2 -->
  			<link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
			  <!-- Theme style -->
		  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
		  <!-- Google Font -->
  			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<body class="<?= $body_class ?>">
		<?php $this->load->view($file); ?>
		<?php $this->load->view('Common/script'); ?>
	</body>
</html>