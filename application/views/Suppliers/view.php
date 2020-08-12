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
         <li><a href="<?= site_url(SUPPLIERS) ?>">Manage Suppliers</a></li>
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
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Name">Name</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data))?$data->FirstName.' '.$data->LastName:'' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="DOB">DOB</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data))?$data->DOB:'' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="GST_No">GST_No</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->GST_No != '')?$data->GST_No:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Email">Email</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->Email != '')?$data->Email:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Mobile">Mobile</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->Mobile != '')?$data->Mobile:'N/A' ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Address">Address</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->Address != '')?$data->Address:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="City">City</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->City != '')?$data->City:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="State">State</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->State != '')?$data->State:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Country">Country</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->Country != '')?$data->Country:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <label class="col-sm-3 control-label pull-left" for="Zip">Zip</label>
                              <div class="col-sm-9 pull-right">
                                 <?= (isset($data) && $data->Zip != '0')?$data->Zip:'N/A' ?>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-9">
                                 <div class="box-footer">
                                    <a href="<?= site_url(SUPPLIERS) ?>"><button class="btn btn-default pull-right" type="button">Back</button></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                           <table class="table table-bordered table-striped example_datatable">
                              <thead>
                                 <tr>
                                 <th>Sr No</th>
                                  <th>Invoice No</th>
                                  <th>Invoice Date</th>
                                  <th>Net Amount</th>
                                  <th>Balance Amount</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                  </div>
                  <!-- /.col -->
               </div>
             </div>
              <!-- /.row -->
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
   var url = "<?= site_url(SUPPLIERS_INVOICE_AJAX.'/'.$data->id) ?>";
   var actioncolumn=7;
</script>