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
        <li><a href="<?= site_url(CUSTOMERS) ?>">Manage Customers</a></li>
        <li class="active"><?= $heading ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-12">
                      <form class="form-horizontal" method="post" action="<?= $action ?>">
                       <input type="hidden" id="GSTIN_AJAX" value="<?= site_url(GSTIN_AJAX) ?>" />
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="GST_No">GST_No <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="GST_No" id="GST_No" class="form-control" name="GST_No" value="<?= (isset($data))?$data->GST_No:'' ?>">
                              <span id="errGST_No" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">First Name <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="First Name" id="FirstName" class="form-control" name="FirstName" value="<?= (isset($data))?$data->FirstName:'' ?>">
                              <span class="text text-danger" id="errfname"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Last Name <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Last Name" id="LastName" class="form-control" name="LastName" value="<?= (isset($data))?$data->LastName:'' ?>">
                              <span id="errLastName" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="DOB">Date of registeration <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="DOB" id="DOB" class="form-control DOB" name="DOB" readonly>
                              <input type="hidden" id="dateofbirth" value="<?= (isset($data))?$data->DOB:'' ?>">
                              <span id="errDOB" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Email">Email </label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Email" id="Email" class="form-control" name="Email" value="<?= (isset($data))?$data->Email:'' ?>">
                              <span id="errEmail" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Mobile">Mobile </label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Mobile" id="Mobile" class="form-control" name="Mobile" value="<?= (isset($data))?$data->Mobile:'' ?>" maxlength="10">
                              <span id="errMobile" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Opening_balance">Opening Balance<span class="text text-danger">*</span></label>
                            <div class="col-sm-3">
                              <select class="form-control" name="Type">
                                <option value="Dr">Dr</option>
                                <option value="Cr">Cr</option>
                              </select>
                            </div>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Opening Balance" id="Opening_balance" class="form-control" name="Opening_balance" value="<?= (isset($data))?$data->Opening_balance:'' ?>" onkeypress="return isNumberKey(event)">
                              <span id="errOpening_balance" class="text text-danger"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Address">Address <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <textarea rows="3" id="Address" class="form-control" name="Address" placeholder="Address"><?= (isset($data))?$data->Address:'' ?></textarea>
                              <span id="errAddress" class="text text-danger"></span>
                            </div>
                          </div>
                           <div class="form-group">
                            <label class="col-sm-3 control-label" for="Country">Country <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <select class="form-control select2 country"  id="Country" name="Country" onChange="showStates(this.value)"></select>
                              <input type="hidden" id="Country_update" value="<?= (isset($data))?$data->Country:'' ?>">
                              <span id="errCountry" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="State">State <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <select class="form-control select2 State"  id="State" name="State" onChange="showCities(this.value)"></select>
                              <input type="hidden" id="State_update" value="<?= (isset($data))?$data->State:'' ?>">
                              <span id="errState" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="City">City <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <select class="form-control select2 Cities"  id="Cities" name="City"></select>
                              <input type="hidden" id="City_update" value="<?= (isset($data))?$data->City:'' ?>">
                              <span id="errCities" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Zip">Zip <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Zip" id="Zip" class="form-control" name="Zip" value="<?= (isset($data))?$data->Zip:'' ?>" maxlength="6">
                              <span id="errZip" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Balance_As_On">Balance As On <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Balance as on" id="Balance_as_on" class="form-control Balance_dt" name="Balance_as_on" value="<?= (isset($data))?$data->Balance_as_on:'' ?>" readonly>
                              <span id="errBalance_as_on" class="text text-danger"></span>
                            </div>
                          </div>

                        </div>
                        <?php if(isset($data)){?>
                          <input type="hidden" id="id" class="form-control" name="id" value="<?= (isset($data))?$data->id:'' ?>">
                        <?php }?>
                          <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                              <div class="box-footer">
                                <button class="btn btn-info" type="button" id="customer_btn">Submit</button>
                                <a href="<?= site_url(CUSTOMERS) ?>"><button class="btn btn-default" type="button">Cancel</button></a>
                              </div>
                              <!-- /.box-footer -->
                            </div>
                          </div>
                        <!-- /.box-body -->
                      </form>
                    </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
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
    var url = "<?= site_url() ?>";
    var actioncolumn="";
</script>
