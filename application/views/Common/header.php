<?php 
if(!$this->session->userdata('logged_in')){
	redirect(LOGIN);
}
?>
<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?= LOGO_MINI ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-sm text-uppercase"><b><?= ucfirst(LOGO) ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="javascript:void(0);" class="dropdown-toggle">
              <img src="<?= base_url() ?>/assets/dist/img/<?= profile ?>" class="user-image" alt="User Image">
              <span class=""><?php echo ucfirst(name); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url() ?>/assets/dist/img/<?= profile ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucfirst(name); ?>
                  <small><?php echo date("d-M-Y h:i A",strtotime(last_login)); ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= site_url(PROFILE)?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= site_url(LOGOUT)?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>