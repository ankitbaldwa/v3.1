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
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <?php $this->load->view('Common/profile'); ?>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="<?= site_url(PROFILE) ?>">Profile</a></li>
              <li><a href="<?= site_url(TAXES) ?>">Taxes</a></li>
              <li class="active"><a href="<?= site_url(BANK_DETAILS)?>">Bank Details</a></li>
              <li><a href="<?= site_url(SETTINGS) ?>">General Settings</a></li>
              <li><a href="<?= site_url(CHANGEPASSWORD) ?>">Change Password</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Branch</th>
                            <th>IFC Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $sr=1; foreach($bank_data as $data){ ?>
                      <tr>
                        <td><span id="dis_bank_name_<?= $sr; ?>"><?= $data->bank_name ?></span><input type="text" name="<?= $data->id ?>" id="input_bank_name_<?= $sr; ?>" value="<?= $data->bank_name ?>"></td>
                        <td><span id="dis_bank_AC_NO_<?= $sr; ?>"><?= $data->account_no ?></span><input type="text" name="<?= $data->id ?>" id="input_AC_No_<?= $sr; ?>" value="<?= $data->account_no ?>"></td>
                        <td><span id="dis_Branch_<?= $sr; ?>"><?= $data->branch ?></span><input type="text" name="<?= $data->id ?>" id="input_branch_<?= $sr; ?>" value="<?= $data->branch ?>"></td>
                        <td><span id="dis_IFC_Code_<?= $sr; ?>"><?= $data->IFC_code ?></span><input type="text" name="<?= $data->id ?>" id="input_IFC_Code_<?= $sr; ?>" value="<?= $data->IFC_code ?>"></td>
                        <td><input type="hidden" id="id_<?= $sr; ?>" value="<?= $data->id ?>"><button class="btn btn-info btn-xs" id="edit_<?= $sr; ?>" type="button"><i class="fa fa-pencil"></i></button><button class="btn btn-success btn-xs" id="save_<?= $sr; ?>" type="button">Save</button></td>
                      </tr>
                      <?php $sr++; }?>
                    </tbody>
                </table>
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
    var url = "<?= base_url(UPDATE_BANK_DETAILS)?>";
    var actioncolumn='';
</script>
