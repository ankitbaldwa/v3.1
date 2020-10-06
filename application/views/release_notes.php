<?php 
if(!$this->session->userdata('logged_in')){
	redirect(LOGIN);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= TITLE ?> | Release Notes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="https://accordance.co.in/assets/images/favicon.png" type="image/png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-black-light layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand" style="border-right: 0px solid #d2d6de;">
              <span class="logo-sm text-uppercase"><img src="https://accordance.co.in/assets/images/logo2.png"/></span>
          </a>
        </div>
        <!-- Navbar Right Menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Release Notes
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="box box-primary">
          <div class="box-body">
              <div class="attachment-block clearfix">
                <blockquote>
                <div class="attachment-pushed">
                    <h4 class="attachment-heading text-center"><b>- <?= $release_note->name ?> Package v<?= (float)$release_note->version ?> -</b></h4>
                  <div class="attachment-text">
                          <p><?= $release_note->release_notes ?></p>
                  </div>
                  <!-- /.attachment-text -->
                </div>
                </blockquote>
                <!-- /.attachment-pushed -->
              </div>
              <div class="col-md-8">
                <h4><b>Key Notes</b></h4>
                  <p class="versionText"><?= $release_note->key_points?></p>
              </div>
              <div class="col-md-4">
                  <div class="box box-success box-solid direct-chat direct-chat-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Previous Versions</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <!-- Conversations are loaded here -->
                      <div class="direct-chat-messages releated-notes">
                        <!-- Message. Default to the left -->
                        <ul>
                        <?php foreach($all_release_notes as $value) { ?>
                            <li>
                            <a href="<?= 'https://www.accordance.co.in/assets/release_pdf/'.$value->release_notes_pdf ?>" download><?= $value->name.' Package (v'. (float) $value->version.')' ?></a>
                            </li>
                        <?php } ?>
                        </ul>
                        <!-- /.direct-chat-msg -->
                      </div>
                      <!--/.direct-chat-messages-->
                    </div>
                    <!-- /.box-body -->
                  </div>
              </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('Common/footer'); ?>
</div>
<!-- ./wrapper -->
<script>
var url = "";
</script>
<?php $this->load->view('Common/script'); ?>
</body>
</html>
