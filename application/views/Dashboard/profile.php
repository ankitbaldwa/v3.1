<div class="wrapper">

  <?php $this->load->view('Common/header'); ?>
  <?php $this->load->view('Common/sidemenu'); ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $heading ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url(DASHBOARD) ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <li class="active"><?= $heading ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
      <?php $this->load->view('Common/profile'); ?>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="<?= site_url(PROFILE) ?>">Profile</a></li>
              <li><a href="<?= site_url(TAXES) ?>">Taxes</a></li>
              <li><a href="<?= site_url(BANK_DETAILS)?>">Bank Details</a></li>
              <li><a href="<?= site_url(SETTINGS) ?>">General Settings</a></li>
              <li><a href="<?= site_url(CHANGEPASSWORD) ?>">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
              <form class="form-horizontal" enctype="multipart/form-data" action="<?= $action?>" method="post">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">User Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Name" value="<?= $userdata->username ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $userdata->email ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Mobile</label>

                    <div class="col-sm-10">
                      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?= $userdata->mobile ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Profile</label>

                    <div class="col-sm-5">
                      <input type="file" class="" id="profile" name="profile" placeholder="Profile">
                      <input type="hidden" name="profile" value="<?php echo $userdata->profile; ?>">
                      <span class="text text-danger" id="error_image"><span class="msghide"><?php echo $this->session->userdata('image_error') <> '' ? $this->session->userdata('image_error') : ''; ?></span></span>
                      <div>
                        <strong>Note :</strong>
                        <span class="blue">Please select image type jpg,png,jpeg </span>
                      </div>
                      <?php echo form_error('file','<span class="text text-danger">','</span>'); ?>
                    </div>
                    <div class="col-sm-5">
                      <img class="profile-user-img img-responsive img-circle" src="<?= base_url() ?>/assets/dist/img/<?= $userdata->profile ?>" alt="User profile picture">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('Common/footer'); ?>
</div>
<!-- ./wrapper -->
