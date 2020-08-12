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
        <li><a href="<?= site_url(VOUCHER) ?>">Manage Vouchers</a></li>
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
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Voucher Type <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="radio" class="voucher_type" name="voucher_type" value="Debit">
                              Debit
                              <input type="radio" class="voucher_type" name="voucher_type" value="Credit">
                              Credit
                              <span class="text text-danger" id="errVtype"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Voucher Date <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Voucher Date" id="voucher_date" class="form-control" name="voucher_date" readonly>
                              <span id="errvoucher_date" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Voucher No. <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Voucher No" id="voucher_no" class="form-control" name="voucher_no" value="">
                              <span id="errvoucher_no" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Account Name <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Account Name" id="account_name" class="form-control" name="account_name">
                              <span id="erraccount_name" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="PaymentType">Payment Type <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="radio" class="payment_type" name="payment_type" value="Cash">
                              Cash
                              <input type="radio" class="payment_type" name="payment_type" value="Bank">
                              Bank
                              <span id="errpayment_type" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="paid_to">Paid To <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                            <input type="text" placeholder="Paid To" id="paid_to" class="form-control" name="paidTo">
                              <span id="errpaid_to" class="text text-danger"></span>
                            </div>
                          </div>
                           <div class="form-group">
                            <label class="col-sm-3 control-label" for="amount" id="lblamount">Amount <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Amount" id="amount" class="form-control allow_decimal" name="amount">
                              <span id="erramount" class="text text-danger"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="bank_cheque">
                            <label class="col-sm-3 control-label" for="cheque_no">Cheque No <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Cheque No" id="cheque_no" class="form-control" name="cheque_no">
                              <span id="errcheque_no" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group" id="bank_date">
                            <label class="col-sm-3 control-label" for="cheque_date">Cheque Date <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Cheque Date" id="cheque_date" class="form-control" name="cheque_date" readonly>
                              <span id="errcheque_date" class="text text-danger"></span>
                            </div>
                          </div>
                          <div class="form-group" id="bank_name">
                            <label class="col-sm-3 control-label" for="bank_name">Bank Name <span class="text text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Bank Name" id="bankname" class="form-control" name="bank_name">
                              <span id="errbank_name" class="text text-danger"></span>
                            </div>
                          </div>
                        </div>
                          <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-11">
                              <div class="box-footer">
                                <button class="btn btn-info" type="button" id="voucher_btn">Submit</button>
                                <a href="<?= site_url(VOUCHER) ?>"><button class="btn btn-default" type="button">Cancel</button></a>
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
<input type="hidden" id="site_url" value="<?= site_url(VOUCHER_NO)?>"/>
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
