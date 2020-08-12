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
      	<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
              	<div class="box-header with-border">
                  <form method="post" action="<?= site_url(PAYMENT_REPORT_EXCEL)?>">
                    <div class="form-group">
                        <select name="months" class="form-control pull-left" style="width:350px" id="customer">
                            <option value="">-- Select Customer --</option>
                            <?php
                                foreach ($customers as $key => $value) {
                                    echo "<option value='".$value->id."'>".$value->FirstName." ".$value->LastName."</option>";
                                }
                            ?>
                        </select> 
                        <div class="input-group pull-left">&nbsp;
                          <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                            <span>
                              <i class="fa fa-calendar"></i> Date Range
                            </span>
                            <i class="fa fa-caret-down"></i>
                          </button>
                        </div>
                        <input type="hidden" name="start" id="start">
                        <input type="hidden" name="end" id="end">
                        <div class="pull-right">
                          <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-file-excel-o"></i> Export To Excel</button>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                 <table class="table table-bordered table-striped customer_reports_datatable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Customer Name</th>
                            <th>Invoice No.</th>
                            <th>Receipt No.</th>
                            <th>Payment Date</th>
                            <th>Billed Amount</th>
                            <th>Payment Amount</th>
                            <th>Balance Amount</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
    var url = "<?= site_url(PAYMENT_REPORT_AJAX);?>";
    var actioncolumn=12;
</script>
