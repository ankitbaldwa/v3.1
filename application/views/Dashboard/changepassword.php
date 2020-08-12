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
              <li><a href="<?= site_url(PROFILE) ?>">Profile</a></li>
              <li><a href="<?= site_url(TAXES) ?>">Taxes</a></li>
              <li><a href="<?= site_url(BANK_DETAILS)?>">Bank Details</a></li>
              <li><a href="<?= site_url(SETTINGS) ?>">General Settings</a></li>
              <li class="active"><a href="<?= site_url(CHANGEPASSWORD) ?>">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
              <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= $action ?> ">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Current Password <span style="color:red;">*</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="password" id="cpassword" placeholder="Current Password" class="form-control" name="password" value=""/> 
                            </div>
                        </div>
                        <span class="text text-danger" id="current_password_err"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">New Password <span style="color:red;">*</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="password" id="npassword" placeholder="New Password" class="form-control" name="n_password" value=""/>
                            </div>
                        </div>
                        <span class="text text-danger" id="new_password_err"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Confirm Password<span style="color:red;">*</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="password" id="cnpassword" placeholder="Confirm Password" class="form-control" name="cn_password" value=""/>  
                            </div>  
                        </div>
                        <span class="text text-danger" id="confirm_new_password_err"></span>
                    </div>
                </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" onclick="return ChangePassword();" class="btn btn-primary">Submit</button>
                      <button type="submit" style="display:none;" id="changePassbtn">Submit</button>
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
<script>
var url="<?= site_url(CHECKCORRECTPASSWORD) ?>";
</script>