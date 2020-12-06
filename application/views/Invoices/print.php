<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= TITLE ?> | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!--<link rel="stylesheet" href="<?= base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">-->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <!--<link rel="stylesheet" href="<?= base_url()?>assets/dist/css/AdminLTE.min.css">-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
  table{
    width: 100%;
  }
  .table tr td{
      border: 1px solid black;
      padding: 0px !important;
      padding-left: 5px !important;
      padding-right: 5px !important;
    }
    .table tr td {
      line-height: 1.4 !important;
    }
    .table2 tr th{
      border: 1px solid black;
      padding-left: 5px !important;
      padding-right: 5px !important;
    }
    .table2 td{
      border-right: 1px solid black;
      border-left: 1px solid black;
    }
    .border-top{
      border-top: 1px solid black;
    }
    .spaceing {
      letter-spacing:0.254mm;
      font-stretch: 100%;
      text-align: justify;
    }
    .m0 {
      margin: 0px;
    }
    .border-0 {
      border: 0px solid #fff;
    }
    .border-1 {
      border: 1px solid black;
    }
    .w-100-per{
      width:100%;
    }
    .text-bold {
      font-weight: bold;
    }
    .text-center {
      text-align: center;
    }
    .text-right {
      text-align:right;
      padding: 5px !important;
    }
    .font-size-14 {
      font-size: 14pt;
    }
    .w200 {
      width: 40%;
    }
    .border-1-white{
      border-right: 1px solid #fff !important;
    }
    .w11 {
      width: 10%;
    }
    .border-left-1-white {
      border-left: 1px solid #fff !important;
    }
    .w125 {
      width: 25%;
    }
    .w100 {
      width: 100%;
    }
    </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();" style="line-height:1.4 !important;">
    <table class="border-0 w-100-per" cellspacing="0" cellpadding="0">
      <tbody>
          <tr>
            <td class="text-center font-size-14"><b>Tax Invoice</b></td>
          </tr>
          <tr>
            <td>
              <table class="table w-100-per border-1" cellspacing="0" cellpadding="8">
                <tbody>
                  <tr>
                    <td rowspan="3" class="w200 border-1-white">
                      <address>
                          <strong><?= strtoupper($settings[0]->value) ?></strong><br>
                          <?= $settings[1]->value ?><br>
                          <b><?= $settings[2]->name ?>:</b> <?= $settings[2]->value ?><br>
                          <b><?= $settings[3]->name ?>:</b> <?= $settings[3]->value ?><br>
                          <b><?= $settings[4]->name ?>:</b><?= $settings[4]->value ?>
                      </address>
                    </td>
                    <td rowspan="3" class="w11 border-left-1-white text-center">
                        <?php if($data->Qr_code != ""){ ?>
                          <?php $company_code = $this->session->userdata('logged_in')['company_code']; ?>
                            <img src="<?= base_url() ?>/assets/Qr_code/<?= $company_code.'/'.$data->Qr_code ?>" style="width:80%;margin-top: 2px;"/>
                        <?php } ?>
                    </td>
                    <td class="w125">
                      <b>Invoice No. </b><br/><?= $data->invoice_no ?>
                    </td>
                    <td class="w125">
                      <b>Dated </b><br/><?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="w125">
                      <b>Delivery Note </b> <br/><?php echo 'NA';?>
                    </td>
                    <td class="w125">
                      <b>Mode of Payment </b> <br/><?= 'Credit' ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="w125">
                      <b>Supplier's Ref. </b> <br/><?= 'NA' ?>
                    </td>
                    <td class="w125">
                      <b>Other Reference(s)</b> <br/><?= 'NA' ?>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3" colspan="2" style="width: 50%;">
                      <address>
                        <b> <?= $data->FirstName ?> <?= $data->LastName ?></b><br>
                        <?= !empty($data->Address)?$data->Address:'N/A' ?>,
                        <?= !empty($data->City)?$data->City:'N/A' ?>, <?= !empty($data->State)?$data->State:'N/A' ?> - <?= !empty($data->Zip)?$data->Zip:'N/A' ?><br>
                        <b>Mobile </b><?= $data->Mobile ?><br>
                        <b>Email </b><?= $data->Email ?><br>
                        <b>GST No. </b><?= $data->GST_No ?>
                      </address>
                    </td>
                    <td class="w125">
                      <b>Buyer's Order No. </b><br/><?= 'NA' ?>
                    </td>
                    <td class="w125">
                      <b>Dated </b><br/><?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="w125">
                      <b>Despatch Through </b> <br/><?php echo "Road";?>
                    </td>
                    <td class="w125">
                      <b>Destination / Place:</b> <br/><?= $data->Place ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="w125">
                      <b>E-Way Bill no. </b><br/><?= $data->waybill ?>
                    </td>
                    <td class="w125">
                      <b>Vehicle No. </b> <br/><?= str_replace(' ','',$data->Lorry_no) ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table class="table2 w100 border-1" cellspacing="0" cellpadding="1">
                <tbody>
                  <tr class="text-center text-bold">
                    <th style="width: 5%;">Sl No.</th>
                      <th style="width: 40%;">Description of Goods</th>
                      <th style="width: 8%;">HSN / SAC</th>
                      <th style="width: 15%;">Quantity</th>
                      <th style="width: 8%;">Rate</th>
                      <th style="width: 5%;">Per</th>
                      <th style="width: 16%;">Amount</th>
                  </tr>
                <?php $Total_qty = 0; $hsn; $amt; $sr = 0; $cgst =0; $sgst=0; $igst= 0;$Additional_amount = 0;$cess = 0;$tcs = 0;
                foreach($invoice_details as $details){ ?>
                    <tr>
                      <td class="text-center"><?= ++$sr ?></td>
                      <td><?= $details->Name?></td>
                      <td><?php $hsn[$sr] = $details->Hsn_code; ?><?= $details->Hsn_code?></td>
                      <td><?php $Total_qty += $details->Qty; ?><?= moneyFormatIndia($details->Qty) ?> <b><?= $details->Unit?></b></td>
                      <td class="text-right"><?= moneyFormatIndia($details->Price)?></td>
                      <td><?= $details->Unit?></td>
                      <td class="text-right"><?php $amt[$sr] = $details->Amount; ?><?= moneyFormatIndia($details->Amount) ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <!--<td></td>
                    <td style="text-align:left;font-weight: bold;"> <b>Lorry No. </b>&nbsp;<?= $data->Lorry_no ?></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                  </tr>-->
              <?php if($data->Additional_amount != 0) { ?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">Additional Amount</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?php $Additional_amount = $data->Additional_amount; ?><?= moneyFormatIndia($data->Additional_amount) ?></td>
                    </tr>
                <?php } ?>
                    <?php if($data->IGST != 0){?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">Output IGST <?= moneyFormatIndia($data->IGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?= moneyFormatIndia($data->IGST_percentage) ?></td>
                      <td>%</td>
                      <td class="text-right"><?= moneyFormatIndia($data->IGST) ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">Output CGST <?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?= moneyFormatIndia($data->CGST_percentage) ?></td>
                      <td>%</td>
                      <td class="text-right"><?= moneyFormatIndia($data->CGST) ?></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">Output SGST <?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?= moneyFormatIndia($data->SGST_percentage) ?></td>
                      <td>%</td>
                      <td class="text-right"><?= moneyFormatIndia($data->SGST) ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data->CESS != 0 ){ ?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">GST Compensation Cess (Rs. <?= $data->CESS_value ?> Per Tons )</td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?= $data->CESS_value ?></td>
                      <td></td>
                      <td class="text-right"><?php $cess = $data->CESS; ?><?= moneyFormatIndia($data->CESS) ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data->TCS != 0 ){ ?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">TCS (<?= moneyFormatIndia($data->TCS_percentage) ?> %)</td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?= moneyFormatIndia($data->TCS_percentage) ?></td>
                      <td>%</td>
                      <td class="text-right"><?php $tcs = $data->TCS; ?><?= moneyFormatIndia($data->TCS) ?></td>
                    </tr>
                  <?php } ?>
                    <?php 
                      $round_off_val = number_format($data->Roundoff - floor($data->Roundoff),2);
                      if($round_off_val < 0.5){
                        $round_off = $round_off_val;
                      } else {
                        $round_off = $round_off_val - 1;
                      }
                       ?>
                    <?php if($round_off_val != 0){ ?>
                    <tr>
                      <td></td>
                      <td class="text-right text-bold">Round Off (<?php echo ($round_off_val < 0.5)?'-':'+'; ?>)</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-right"><?php echo moneyFormatIndia(abs($round_off)); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td class="border-top"></td>
                      <td class="border-top text-bold text-right">Total</td>
                      <td class="border-top"></td>
                      <td class="border-top"><b><?= moneyFormatIndia($Total_qty) ?> <?= $details->Unit?></b></td>
                      <td class="border-top"></td>
                      <td class="border-top"></td>
                      <td class="border-top text-right"><b>Rs. <?= moneyFormatIndia($data->Netammount) ?></b></td>
                    </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <b>Amount in words: </b><br/><i><?= convert_number($data->Netammount); ?></i>
            </td>
          </tr>
          <tr>
            <td>
            <table style="border: 1px solid black;width: 100%;" class="table" cellspacing="0" cellpadding="3">
                <tbody>
                <tr class="text-center text-bold">
                    <td class="text-center text-bold" style="width: 200px;" rowspan="2">HSN/SAC</td>
                    <td class="text-center text-bold" style="width: 60px;" rowspan="2">Taxable Value</td>
                    <?php if($data->IGST != 0){ ?>
                    <td class="text-center text-bold" style="width: 200px;" colspan="2">IGST</td>
                    <?php } else { ?>
                    <td class="text-center text-bold" style="width: 100px;" colspan="2">Central Tax</td>
                    <td class="text-center text-bold" style="width: 100px;" colspan="2">State Tax</td>
                    <?php } ?>
                    <td class="text-center text-bold" style="width: 60px;" rowspan="2">Total Tax Amount</td>
                  </tr>
                  <tr>
                    <td class="text-center text-bold">Rate</td>
                    <td class="text-center text-bold">Amount</td>
                    <?php if($data->IGST == 0){ ?>
                    <td class="text-center text-bold">Rate</td>
                    <td class="text-center text-bold">Amount</td>
                    <?php } ?>
                  </tr>
                  <?php $tax_value = 0; $cgst = 0; $sgst = 0; $total = 0;$igst = 0; for($i = 1; $i <= count($hsn); $i++){ ?>
                  <tr>
                    <td class="text-center"><?= $hsn[$i] ?></td>
                    <td class="text-right"><?php $tax_value += $amt[$i] + $Additional_amount; ?><?= moneyFormatIndia($amt[$i] + $Additional_amount) ?></td>
                    <?php if($data->IGST != 0){ ?>
                      <td class="text-right"><?= moneyFormatIndia($data->IGST_percentage) ?>%</td>
                    <td class="text-right"><?php $igst += $data->IGST ?><?= moneyFormatIndia($data->IGST) ?></td>
                    <td class="text-right"><?php $total += ($data->IGST) ?><?= moneyFormatIndia($data->IGST)?></td>
                      <?php } else { ?>
                    <td class="text-right"><?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                    <td class="text-right"><?php $cgst += $data->CGST ?><?= moneyFormatIndia($data->CGST) ?></td>
                    <td class="text-right"><?= moneyFormatIndia($data->SGST_percentage) ?>%</td>
                    <td class="text-right"><?php $sgst += $data->SGST ?><?= moneyFormatIndia($data->SGST) ?></td>
                    <td class="text-right"><?php $total += ($data->CGST + $data->SGST) ?><?= moneyFormatIndia($data->CGST + $data->SGST)?></td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                  <tr style="line-height: 1 !important;">
                    <td class="text-right text-bold">Total</td>
                    <td class="text-right text-bold"><?= moneyFormatIndia($tax_value)?></td>
                    <?php if($data->IGST != 0){ ?>
                      <td></td>
                    <td class="text-right text-bold"><?= moneyFormatIndia($igst)?></td>
                      <?php } else { ?>
                    <td></td>
                    <td class="text-right text-bold"><?= moneyFormatIndia($cgst)?></td>
                    <td></td>
                    <td class="text-right text-bold"><?= moneyFormatIndia($sgst)?></td>
                    <?php } ?>
                    <td class="text-right text-bold"><?= moneyFormatIndia($total)?></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <b>Tax Amount (in words): </b><br/><i><?= convert_number($total); ?></i>
            </td>
          </tr>
          <tr>
            <td>
              <table style="border: 0px solid #fff;" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr style="text-align: left;">
                    <?php foreach($bank_details as $bank ){ ?>
                      <?php if($bank->bank_name != '') { ?>
                        <td style="width: 50%;">
                          <b>Company's Bank Details</b><br/>
                          <b>Bank Name:</b> <?= $bank->bank_name?><br/>
                          <b>A/c No.:</b> <?= $bank->account_no?><br/> 
                          <b>Branch & IFS Code:</b> <?= $bank->branch ?> & <?= $bank->IFC_code ?><br/>
                        </td>
                      <?php } ?>
                    <?php } ?>
                    </tr>
                    <tr class="text-left" style="font-size: 11pt;">
                      <td style="width: 50%;padding: 5px;" rowspan="2"><br/>
                        <u>Declaration</u><br/>
                        <?= $settings[5]->value ?>
                      </td>
                      <td class="text-right" style="width: 50%;border: 1px solid black;padding: 5px;font-size: 11pt;" colspan="2">
                        <b>For  <?= $settings[0]->value ?> &nbsp; &nbsp; &nbsp;</b><br/><br/>
                        <br/>
                        <b>Authorised Sign / Accountant / Manager &nbsp;</b>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class="text-center" style="font-size: 11pt;">
            <br/><b><?= $settings[8]->value ?></b><br/>
            <b>This is a Computer Generated Invoice</b>
            </td>
          </tr>
        </tbody>
      </table>
</body>
</html>
