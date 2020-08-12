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
        <li><a href="<?= site_url(INVOICES) ?>">Manage Invoices</a></li>
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
				    <h3 class="box-title pull-right">
            <?php if($data->Balance_Amount != 0){ ?>
            <a class="btn btn-primary btn-xs" href="<?= site_url(INVOICES_PAYMENT_ADD).'/'.enc_dec(1,$id) ?>" title = "Make Payment"><?= "Make Payment" ?></a> 
            <?php } ?>
            <a class="btn btn-info btn-xs" href="<?= site_url(INVOICES) ?>" title = "Back"><?= "Back" ?></a> 
            </h3>
				  </div>
				  <!-- /.box-header -->
          <div class="box-body">
          <div class="row invoice-info">
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To
                <address>
                  <strong><?= $data->FirstName ?> <?= $data->LastName ?></strong><br>
                  <?= !empty($data->Address)?$data->Address:'N/A' ?><br>
                  <?= !empty($data->City)?$data->City:'N/A' ?>, <?= !empty($data->State)?$data->State:'N/A' ?> <?= !empty($data->Country)?$data->Country:'N/A' ?> - <?= !empty($data->Zip)?$data->Zip:'N/A' ?><br>
                  <b>Phone:</b> <?= $data->Mobile ?><br>
                  <b>Email:</b> <?= $data->Email ?><br>
                  <b>GST No:</b> <?= $data->GST_No ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice </b><?= $data->invoice_no ?><br>
                <b>Order ID:</b> <?= date('d-m-Y', strtotime($data->invoice_date)) ?><br>
                <b>Payment Due:</b> <?php echo date('d-m-Y',strtotime('+30 days',strtotime($data->invoice_date))) . PHP_EOL;?><br>
                <b>Lorry No:</b> <?= $data->Lorry_no ?><br>
                <b>Way bill:</b> <?= $data->waybill ?><br>
                <b>Place:</b> <?= $data->Place ?>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
              </div>
            </div>
            <div class="table-responsive">
                 <table class="table table-bordered table-striped example_datatable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Receipt No</th>
                            <th>Payment Date</th>
                            <th>Billed Amount</th>
                            <th>Payment Amount</th>
                            <th>Balance Amount</th>
                            <th>Status</th>
                            <th>Action</th>
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
    var url = "<?= site_url(INVOICES_PAYMENT_AJAX).'/'.enc_dec(1,$id) ?>";
    var actioncolumn=8;
</script>
