<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= TITLE ?> | Invoice</title>
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
  <style>
  table{
    width: 100%;
  }
  .table {
      margin-bottom: 5px !important;
  }
    .table tr td{
      border: 1px solid black;
    }
    .table2 tr th{
      border: 1px solid black;
    }
    .table2 td{
      border-right: 1px solid black;
      border-left: 1px solid black;
      padding: 5px;
    }
    .border-top{
      border-top: 1px solid black;
    }
    </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();" style="line-height:1.4 !important;">
  <table style="border: 0px solid #fff;" cellspacing="0" cellpadding="0" >
      <tbody>
          <tr>
            <td style="text-align: center;font-size: 14pt;"><b>Tax Invoice</b></td>
          </tr>
          <tr>
            <td>
              <table class="table" style="border: 1px solid black;" cellspacing="0" cellpadding="1" >
                <tbody>
                  <tr>
                    <td rowspan="3" style="width: 200px;border-top: 1px solid black;border-right: 1px solid #fff;">
                      <address>
                          <strong><?= $settings[0]->value ?></strong><br>
                          <?= $settings[1]->value ?><br>
                          <b><?= $settings[2]->name ?>:</b> <?= $settings[2]->value ?><br>
                          <b><?= $settings[3]->name ?>:</b> <?= $settings[3]->value ?><br>
                          <b><?= $settings[4]->name ?>:</b><?= $settings[4]->value ?>
                      </address>
                    </td>
                    <td rowspan="3" style="border-left: 1px solid #fff;width: 70px;border-top: #000000;">
                        <?php if($data->Qr_code != ""){ ?>
                          <?php $company_code = $this->session->userdata('logged_in')['company_code']; ?>
                            <img src="<?= base_url() ?>/assets/Qr_code/<?= $company_code.'/'.$data->Qr_code ?>" class="img-thumbnail img-responsive" style="width:150px;margin-top: 2px;"/>
                        <?php } ?>
                    </td>
                    <td style="width: 125px;border-top: 1px solid black;">
                      <b>Invoice No. </b><br/>&nbsp;<?= $data->invoice_no ?>
                    </td>
                    <td style="width: 125px;border-top: 1px solid black;">
                      <b>Dated </b><br/>&nbsp;<?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 125px;">
                      <b>Delivery Note </b> <br/>&nbsp;<?php echo 'NA';?>
                    </td>
                    <td style="width: 125px;">
                      <b>Mode of Payment </b> <br/>&nbsp;<?= 'Credit' ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 125px;">
                      <b>Supplier's Ref. </b> <br/>&nbsp;<?= 'NA' ?>
                    </td>
                    <td style="width: 125px;">
                      <b>Other Reference(s)</b> <br/>&nbsp;<?= 'NA' ?>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3" colspan="2" style="width: 270px;">
                      <address>
                        <b> <?= $data->FirstName ?> <?= $data->LastName ?></b><br>
                        <?= !empty($data->Address)?$data->Address:'N/A' ?>,
                        <?= !empty($data->City)?$data->City:'N/A' ?>, <?= !empty($data->State)?$data->State:'N/A' ?> - <?= !empty($data->Zip)?$data->Zip:'N/A' ?><br>
                        <b>Mobile </b><?= $data->Mobile ?><br>
                        <b>Email </b><?= $data->Email ?><br>
                        <b>GST No. </b><?= $data->GST_No ?>
                      </address>
                    </td>
                    <td style="width: 125px;">
                      <b>Buyer's Order No. </b><br/>&nbsp;<?= 'NA' ?>
                    </td>
                    <td style="width: 125px;">
                      <b>Dated </b><br/>&nbsp;<?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Despatch Through </b> <br/>&nbsp;<?php echo "Road";?>
                    </td>
                    <td>
                      <b>Destination / Place:</b> <br/>&nbsp;<?= $data->Place ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>E-Way Bill no. </b><br/>&nbsp;<?= $data->waybill ?>
                    </td>
                    <td>
                      <b>Lorry No. </b> <br/>&nbsp;<?= $data->Lorry_no ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="border: 1px solid black;margin-top:-5px;" class="table2" cellspacing="0" cellpadding="1">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;">
                    <th style="width: 30px;" class="text-center">SL No.</th>
                    <th class="text-center">Description of Goods</th>
                    <th style="width: 50px;" class="text-center">HSN / SAC</th>
                    <th class="text-center" style="width: 100px;">Quantity</th>
                    <th style="width: 80px;" class="text-center">Rate</th>
                    <th style="width: 30px;" class="text-center">Per</th>
                    <th class="text-center" style="width: 120px;">Amount</th>
                  </tr>
                <?php $Total_qty = 0; $hsn; $amt; $sr = 0; $cgst =0; $sgst=0; $igst= 0;$Additional_amount = 0;$cess = 0;$tcs = 0;
                foreach($invoice_details as $details){ ?>
                    <tr>
                      <td><?= ++$sr ?></td>
                      <td><?= $details->Name?></td>
                      <td><?php $hsn[$sr] = $details->Hsn_code; ?><?= $details->Hsn_code?></td>
                      <td><?php $Total_qty += $details->Qty; ?><?= moneyFormatIndia($details->Qty) ?> <b><?= $details->Unit?></b></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($details->Price)?></td>
                      <td><?= $details->Unit?></td>
                      <td style="text-align:right;"><?php $amt[$sr] = $details->Amount; ?><?= moneyFormatIndia($details->Amount) ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td style="text-align:left;font-weight: bold;"> <b>Lorry No. </b>&nbsp;<?= $data->Lorry_no ?></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                  </tr>
              <?php if($data->Additional_amount != 0) { ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Additional Amount</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?php $Additional_amount = $data->Additional_amount; ?><?= moneyFormatIndia($data->Additional_amount) ?></td>
                    </tr>
                <?php } ?>
                    <?php if($data->IGST != 0){?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Output IGST <?= moneyFormatIndia($data->IGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->IGST_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?php $igst = $data->IGST; ?><?= moneyFormatIndia($data->IGST) ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Output CGST <?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->CGST_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?php $cgst = $data->CGST; ?><?= moneyFormatIndia($data->CGST) ?></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Output SGST <?= moneyFormatIndia($data->SGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->SGST_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?php $sgst = $data->SGST; ?><?= moneyFormatIndia($data->SGST) ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data->CESS != 0 ){ ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">GST Compensation Cess (Rs. <?= moneyFormatIndia($data->CESS_value) ?> Per Tons )</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->CESS_value) ?></td>
                      <td></td>
                      <td style="text-align:right;"><?php $cess = $data->CESS; ?><?= moneyFormatIndia($data->CESS) ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data->TCS != 0 ){ ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">TCS (<?= moneyFormatIndia($data->TCS_percentage) ?> %)</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->TCS_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?php $tcs = $data->TCS; ?><?= moneyFormatIndia($data->TCS) ?></td>
                    </tr>
                  <?php } ?>
                    <?php 
                      if($igst == 0){
                        $round_off = ($data->Gross_amount + $data->Additional_amount + $data->CGST + $data->SGST + $data->CESS + $data->TCS) - $data->Netammount;
                      } else {
                        $round_off = moneyFormatIndia(
                        ($data->Gross_amount + $data->Additional_amount + $data->IGST + $data->CESS + $data->TCS) - $data->Netammount );
                      } 
                       ?>
                    <?php if($round_off != 0){ ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Round Off (<?php echo ($round_off > 0)?'-':'+'; ?>)</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?php echo moneyFormatIndia(abs($round_off)); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td class="border-top"></td>
                      <td class="border-top" style="text-align:right;">Total</td>
                      <td class="border-top"></td>
                      <td class="border-top"><b><?= moneyFormatIndia($Total_qty) ?> <?= $details->Unit?></b></td>
                      <td class="border-top"></td>
                      <td class="border-top"></td>
                      <td class="border-top" style="text-align:right;"><b>Rs. <?= moneyFormatIndia($data->Netammount) ?></b></td>
                    </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <b>Amount in words: </b><br/><i><?= convert_number($data->Netammount); ?></i>
              <br/>
            </td>
          </tr>
          <tr>
            <td>
            <table style="border: 1px solid black;line-height: 1 !important;" class="table" cellspacing="0" cellpadding="1">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;line-height: 1 !important;">
                    <td style="width: 200px;border-top: 1px solid black;" rowspan="2">HSN/SAC</td>
                    <td style="width: 60px;border-top: 1px solid black;" rowspan="2">Taxable Value</td>
                    <?php if($data->IGST != 0){ ?>
                    <td style="width: 100px;border-top: 1px solid black;" colspan="2">IGST</td>
                    <?php } else { ?>
                    <td style="width: 100px;border-top: 1px solid black;" colspan="2">Central Tax</td>
                    <td style="width: 100px;border-top: 1px solid black;" colspan="2">State Tax</td>
                    <?php } ?>
                    <td style="width: 60px;border-top: 1px solid black;" rowspan="2">Total Tax Amount</td>
                  </tr>
                  <tr style="text-align: center;font-weight: bold;line-height: 1 !important;">
                    <td>Rate</td>
                    <td>Amount</td>
                    <?php if($data->IGST == 0){ ?>
                    <td>Rate</td>
                    <td>Amount</td>
                    <?php } ?>
                  </tr>
                  <?php $tax_value = 0; $cgst = 0; $sgst = 0; $total = 0;$igst = 0; for($i = 1; $i <= count($hsn); $i++){ ?>
                  <tr>
                    <td><?= $hsn[$i] ?></td>
                    <td><?php $tax_value += $amt[$i] + $Additional_amount; ?><?= moneyFormatIndia($amt[$i] + $Additional_amount) ?></td>
                    <?php if($data->IGST != 0){ ?>
                      <td style="text-align: right;"><?= moneyFormatIndia($data->IGST_percentage) ?>%</td>
                    <td style="text-align: right;"><?php $igst += $data->IGST ?><?= moneyFormatIndia($data->IGST) ?></td>
                    <td style="text-align: right;"><?php $total += ($data->IGST) ?><?= moneyFormatIndia($data->IGST)?></td>
                      <?php } else { ?>
                    <td style="text-align: right;"><?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                    <td style="text-align: right;"><?php $cgst += $data->CGST ?><?= moneyFormatIndia($data->CGST) ?></td>
                    <td style="text-align: right;"><?= moneyFormatIndia($data->SGST_percentage) ?>%</td>
                    <td style="text-align: right;"><?php $sgst += $data->SGST ?><?= moneyFormatIndia($data->SGST) ?></td>
                    <td style="text-align: right;"><?php $total += ($data->CGST + $data->SGST) ?><?= moneyFormatIndia($data->CGST + $data->SGST)?></td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                  <tr style="font-weight: bold;text-align: right;line-height: 1 !important;">
                    <td>Total</td>
                    <td><?= moneyFormatIndia($tax_value)?></td>
                    <?php if($data->IGST != 0){ ?>
                      <td></td>
                    <td><?= moneyFormatIndia($igst)?></td>
                      <?php } else { ?>
                    <td></td>
                    <td><?= moneyFormatIndia($cgst)?></td>
                    <td></td>
                    <td><?= moneyFormatIndia($sgst)?></td>
                    <?php } ?>
                    <td><?= moneyFormatIndia($total)?></td>
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
                            Bank Name: <?= $bank->bank_name?><br/>
                            A/c No.: <?= $bank->account_no?><br/> 
                            Branch & IFS Code: <?= $bank->branch ?> &nbsp; & <?= $bank->IFC_code ?><br/>
                        </td>
                      <?php } ?>
                    <?php } ?>
                    </tr>
                    <tr style="text-align: left;font-size: 11pt;">
                      <td style="width: 50%;padding: 5px;" rowspan="2"><br/>
                        <u>Declaration</u><br/>
                        <?= $settings[5]->value ?>
                      </td>
                      <td style="font-size: 11pt;text-align: right;border:1px solid black;border-bottom: none;">
                        <b>For  <?= $settings[0]->value ?> &nbsp; &nbsp; &nbsp;</b>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size: 11pt;text-align: right;border:1px solid black;border-top: none;">
                        <b>Authorised Sign / Accountant / Manager &nbsp;</b>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;font-size: 10pt;">
            <b><?= $settings[8]->value ?></b><br/>
            <b>This is a Computer Generated Invoice</b>
            </td>
          </tr>
        </tbody>
      </table>
</body>
</html>
