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
        <li><a href="<?= site_url(SETTINGS) ?>">Manage Settings</a></li>
        <li class="active"><?= $heading ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <?php $this->load->view('Common/profile'); ?>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="<?= site_url(PROFILE) ?>">Profile</a></li>
              <li><a href="<?= site_url(TAXES) ?>">Taxes</a></li>
              <li><a href="<?= site_url(BANK_DETAILS)?>">Bank Details</a></li>
              <li class="active"><a href="<?= site_url(SETTINGS) ?>">General Settings</a></li>
              <li><a href="<?= site_url(CHANGEPASSWORD) ?>">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <form class="form-horizontal" method="post" action="<?= $action ?>">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Name</label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Name" id="Name" class="form-control" name="Name" value="<?= (isset($data))?$data->name:'' ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Value">Value <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <textarea cols="5" rows="3" class="form-control" name="value"><?= (isset($data))?$data->value:'' ?></textarea>
                              <span id="errLastName" class="text text-danger"></span>
                            </div>
                          </div>
                        </div>
                        <?php if(isset($data)){?>
                          <input type="hidden" id="id" class="form-control" name="id" value="<?= (isset($data))?$data->id:'' ?>">
                        <?php }?>
                          <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                              <div class="box-footer">
                                <button class="btn btn-info" type="submit" id="setting_btn">Submit</button>
                                <a href="<?= site_url(SETTINGS) ?>"><button class="btn btn-default" type="button">Cancel</button></a>
                              </div>
                              <!-- /.box-footer -->
                            </div>
                          </div>
                        <!-- /.box-body -->
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
    var url = "";
    var actioncolumn="";
</script>
