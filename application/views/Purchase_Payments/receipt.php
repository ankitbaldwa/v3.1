<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Receipt</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url()?>assets/dist/css/AdminLTE.min.css">
        <style>
            .head{width: 865px; margin: 0px auto;}
            .logo{width: 20%;margin-top:50px;}
            .com_name{width: 40%;margin-top:50px;}
            .receipt{width: 35%;text-align:right;}
            .font_wt{font-weight: 700;}
            .name1{width:26%;font-weight:bold;}
            .name2{width:2%;font-weight:bold;}
            .name3{width:72%;}
            .name4{width:22%}
            .margin_b{margin-bottom:5px;}
            .table > tbody > tr > td, .table > tfoot > tr > td, .table > tbody > tr > th, .table > tfoot > tr > th{padding: 0px 25px;}
            .name5{}
            .border{border-bottom:1px dotted #000;}
            @media(min-width: 1024px)  and 	(max-width: 1279px)
            {.head{width:70%;}}
            @media(min-width: 768px)  and 	(max-width: 1023px)
            {.head{width:85%;}}
            @media(min-width: 480px)  and 	(max-width: 767px)
            {.head{width:95%;}.name1{width:45%;}.name4{width:53%;}.name3{width:53%;} }
            @media(min-width: 320px)  and 	(max-width: 479px)
            {.head{width:95%;}.name1{width:45%;}.name4{width:53%;}.name3{width:53%;}.com_name{width: 80%;}.receipt{width: 100%;text-align:right;} }
            @media(min-width: 240px)  and 	(max-width: 319px)
            {.head{width:95%;}.name1{width:45%;}.name4{width:53%;}.name3{width:53%;}.com_name{width: 80%;}.receipt{width: 100%;text-align:right;} }
        </style>
   </head>
   <body>
      <div class="app">
         <div class="head">
            <div></div>
            <div>
               <div class="table-responsive">
                  <table class="table table-bordered bg-white">
                     <tr>
                        <td colspan="6" >
                           <div class="pull-left logo">
                              <img class="img-responsive rounded" src="#" alt="" width="100px;">
                           </div>
                           <div class="pull-left com_name">
                              <div style="text-align:center">
                                 <b>
                                 <?= $settings[0]->value ?><br /><?= $settings[1]->value ?>	
                                 <br /><br />
                                 </b>
                              </div>
                           </div>
                           <div class="pull-right receipt">
                              <div class="text-center">
                                    <h3>Receipt</h3>
                              </div>
                              <div>
                                 <div class="table-responsive">
                                    <table class="table table-bordered bg-white">
                                       <tr>
                                          <td style="width:83px;padding:0px 0px;"><b>Receipt No.</b></td>
                                          <td style="width:100px;padding:0px 0px;"> <?= $receipt->receipt_no ?> </td>
                                       </tr>
                                       <tr>
                                          <td style="width:83px;padding:0px 0px;"><b>Date</b></td>
                                          <td style="width:100px;padding:0px 0px;"><?= date('d-M-Y', strtotime($receipt->payment_date)) ?></td>
                                       </tr>
                                       <tr>
                                          <td style="width:83px;padding:0px 0px;"><b>Invoice No.</b></td>
                                          <td style="width:100px;padding:0px 0px;"><?= $invoice_details->invoice_no ?></td>
                                       </tr>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <br/>
                           <div class="margin_b">
                              <div class="pull-left name1">Name</div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left name3 border" style="border-bottom:1px dotted #000;">&nbsp;<?= $invoice_details->FirstName ?> &nbsp; <?= $invoice_details->LastName ?></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="margin_b">
                              <div class="pull-left name1">Mobile No.</div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left name3 border">&nbsp;<?= $invoice_details->Mobile ?></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="margin_b">
                              <div class="pull-left name1">Amount Paid </div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left name4 border">&nbsp;<i class='fa fa-inr'>&nbsp;</i> <?= moneyFormatIndia($receipt->payed_amount) ?></div>
                              <div class="pull-left name1">Payment Type</div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left  name4 border ">&nbsp;<?= $receipt->payment_type?></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="margin_b">
                              <div class="pull-left name1">Billed Amount </div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left name4 border">&nbsp;<i class='fa fa-inr'>&nbsp;</i><?= moneyFormatIndia($receipt->billed_amount) ?></div>
                              <div class="pull-left name1">Balance Amount</div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left  border name4">&nbsp;<i class='fa fa-inr'>&nbsp;</i><?= moneyFormatIndia($receipt->balance_amount) ?></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="margin_b">
                              <div class="pull-left name1">Amount in words</div>
                              <div class="pull-left name2">:</div>
                              <div class="pull-left name3 border">&nbsp;<?= convert_number($receipt->payed_amount); ?></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="margin_b" style="margin-top:4em">
                              <div class="pull-left"><b>Receiver's Signature</b></div>
                              <div class="pull-right"><b>For,&nbsp;</b><?= $settings[0]->value ?></div>
                              <div class="clearfix"></div>
                           </div>
                        </td>
                     </tr>
                     <tr >
                     </tr>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <script src="<?= base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

      <!-- jQuery UI 1.11.4 -->

      <script src="<?= base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.7 -->

      <script src="<?= base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
        $('document').ready(function(){ 
            window.print();
        });
        </script>
   </body>
</html>