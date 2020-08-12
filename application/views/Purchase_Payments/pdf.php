<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> <?= $user_data->username ?>
          <small class="pull-right">Date: <?= date('d-m-Y', strtotime($data->invoice_date)) ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
          <address>
            <strong><?= $user_data->username ?></strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            <b>Phone:</b> <?= $user_data->mobile ?><br>
            <b>Email:</b> <?= $user_data->email ?>
          </address>
      </div>
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
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Product</th>
            <th>HSN Code</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($invoice_details as $details){ ?>
            <tr>
              <td><?= $details->Name?></td>
              <td><?= $details->Hsn_code?></td>
              <td><?= $details->Qty?> <b><?= $details->Unit?></b></td>
              <td><i class="fa fa-inr"></i> <?= $details->Price?></td>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($details->Amount) ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <div class="form-group">
          <label for="PaymentMode">Payment Mode : <i><?= $data->PaymentMode ?></i></label>
        </div>
        <div class="form-group">
          <label for="PaymentMode">Payment Description : <i class="text-muted">
          <?= $data->PaymentDescription ?>
          </i></label>
        </div>
        <div class="form-group">
            <label for="PaymentMode">Amount in words: <i><?= convert_number($data->Netammount); ?></i>
            </label>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Amount Due <b><?php echo date('d-m-Y',strtotime('+30 days',strtotime($data->invoice_date))) . PHP_EOL;?></b></p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Gross Amount</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->Gross_amount) ?></td>
            </tr>
            <tr>
              <th>Additional Amount</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->Additional_amount) ?></td>
            </tr>
            <tr>
              <th>CGST (<?= $data->CGST_percentage ?>%)</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->CGST) ?></td>
            </tr>
            <tr>
              <th>SGST (<?= $data->SGST_percentage ?>%)</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->SGST) ?></td>
            </tr>
            <tr>
              <th>IGST (<?= $data->IGST_percentage ?>%)</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->IGST) ?></td>
            </tr>
            <tr>
              <th>Roundoff</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->Roundoff) ?></td>
            </tr>
            <tr>
              <th>Net Amount</th>
              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->Netammount) ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
