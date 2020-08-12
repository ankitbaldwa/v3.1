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
        <li><a href="<?= site_url(INVOICES_PAYMENT).'/'.enc_dec(1, $id) ?>">Manage Payments</a></li>
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
                    <div class="col-md-12">
                      <form class="form-horizontal" method="post" action="<?= $action ?>" id="Payment_form">
                        <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="Receipt">Receipt No</label>
                                <input type="text" class="form-control" id="rec_no" name="receipt_no" readonly value="<?= $receipt_no ?>" />
                              </div>
                              <div class="form-group">
                                <label for="recDate">Payment Date <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="rec_date" name="payment_date" readonly/>
                                <span class="text text-danger" id="errrec_date"></span>
                              </div>
                              <div class="form-group">
                                <label for="bill_amt">Billed Amount</label>
                                <input readonly type="text" class="form-control" value="<?= ($data->Balance_Amount == 0)?$data->Netammount:$data->Balance_Amount ?>" id="bill_amt" name="billed_amount" value=""/>
                              </div>
                              <div class="form-group">
                                <label for="payed_amount">Payment Amount <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="payed_amount" name="payed_amount" onChange="balance_amt()"/>
                                <span class="text text-danger" id="errpayedamount"></span>
                              </div>
                              <div class="form-group">
                                <label for="balance_amount">Balance Amount</label>
                                <input readonly type="text" class="form-control" id="balance_amount" name="balance_amount"/>
                                <span class="text text-danger" id="errbalamount"></span>
                              </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                              <div class="form-group">
                                  <label for="payment_type">Payment Type <span class="text text-danger">*</span></label>
                                  <div class="radio">
                                    <label class="radio-inline"><input type="radio" id="payment_type" name="payment_type" value="Cash"/> Cash</label>
                                    <label class="radio-inline"><input type="radio" id="payment_type" name="payment_type" value="Bank"/> Bank</label>
                                  </div>
                                  <span class="text text-danger" id="errpaymenttype"></span>
                              </div>
                              <div class="form-group">
                                <label for="payment_description">Payment Description</label>
                                <textarea class="form-control" rows="5" id="payment_description" name="payment_description"></textarea>
                              </div>
                              <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>"/>
                              <input type="hidden" name="invoice_id" value="<?= $data->id ?>"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                              <div class="box-footer">
                                <button class="btn btn-info" type="submit" id="btn_bill">Submit</button>
                                <a href="<?= site_url(INVOICES_PAYMENT).'/'.enc_dec(1, $id) ?>"><button class="btn btn-default" type="button">Cancel</button></a>
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
<input type="hidden" id="product_url" value="<?= site_url(INVOICES_PAYMENT_AJAX) ?>">
<script>
    var url = "";
    var actioncolumn="";
    var x = 1; //Initial field counter is 1
     //New input field html 
     var next =x+parseFloat(1);
    var fieldHTML = '';
</script>