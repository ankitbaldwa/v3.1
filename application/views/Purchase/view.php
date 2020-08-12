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

        <li><a href="<?= site_url(PURCHASE) ?>">Manage Purchase Bills</a></li>

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

                    <div class="row invoice-info">

                      <div class="col-sm-4 invoice-col">

                        From 

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

                        To

                        <address>

                          <strong><?= $settings[0]->value ?></strong><br>

                          <?= $settings[1]->value ?><br>

                          <b><?= $settings[2]->name ?>:</b> <?= $settings[2]->value ?><br>

                          <b><?= $settings[3]->name ?>:</b> <?= $settings[3]->value ?><br>

                          <b><?= $settings[4]->name ?>:</b><?= $settings[4]->value ?>

                        </address>

                      </div>

                      <!-- /.col -->

                      <div class="col-sm-4 invoice-col">

                        <b>Invoice </b><?= $data->invoice_no ?><br>

                        <b>Invoice Date:</b> <?= date('d-m-Y', strtotime($data->invoice_date)) ?><br>

                        <b>Lorry No:</b> <?= $data->Lorry_no ?><br>

                        <b>Way bill:</b> <?= $data->waybill ?><br>

                        <b>Place:</b> <?= $data->Place ?>

                      </div>

                      <!-- /.col -->

                    </div>

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

                            <td><?= $details->Qty?> </td>

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

                            <label for="PaymentMode">Amount in words: <i><?= $Net_amt_words; ?></i>

                            </label>

                        </div>

                      </div>

                      <!-- /.col -->

                      <div class="col-xs-6">

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

                              <th>CESS (<i class="fa fa-inr"></i> <?= $data->CESS_value ?>)</th>

                              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->CESS) ?></td>

                            </tr>
                            <?php if($data->TCS != '' || $data->TCS != 0){ ?>
                            <tr>

                              <th>TCS (<?= $data->TCS_percentage ?>%)</th>

                              <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($data->TCS) ?></td>

                            </tr>
                          <?php } ?>

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



                    <!-- this row will not appear when printing -->

                    <div class="row no-print">

                      <div class="col-xs-12">

                        <a href="<?= site_url(PURCHASE_PRINT.'/'.base64_encode($data->id))?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                        

                        <a href="<?= site_url(PURCHASE_PDF.'/'.$data->id)?>" class="btn btn-primary pull-right" style="margin-right: 5px;">

                          <i class="fa fa-download"></i> Generate PDF

                        </a>

                      </div>

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

    var url = "";

    var actioncolumn="";

    var x = 1; //Initial field counter is 1

     //New input field html 

     var next =x+parseFloat(1);

    var fieldHTML = '';

</script>