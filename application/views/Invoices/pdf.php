<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>INVOICE PDF</title>
    <style>
    .table tr td{
      border: 1px solid black;
    }
    .table2 tr th{
      border: 1px solid black;
    }
    .table2 td{
      border-right: 1px solid black;
      border-left: 1px solid black;
    }
    .border-top{
      border-top: 1px solid black;
    }
    </style>
  </head>
  <body style="margin: 0px;">
    <table style="border: 0px solid #fff;" cellspacing="0" cellpadding="0" >
      <tbody>
          <tr>
            <td style="text-align: center;font-size: 14pt;"><b>Tax Invoice</b></td>
          </tr>
          <tr>
            <td>
              <table class="table" style="border: 1px solid black;" cellspacing="0" cellpadding="3" >
                <tbody>
                  <tr>
                    <td rowspan="3" style="width: 200px;border-right: 1px solid #fff;">
                      <address>
                          <strong><?= $settings[0]->value ?></strong><br>
                          <?= $settings[1]->value ?><br>
                          <b><?= $settings[2]->name ?>: </b> <?= $settings[2]->value ?><br>
                          <b><?= $settings[3]->name ?>: </b> <?= $settings[3]->value ?><br>
                          <b><?= $settings[4]->name ?>: </b><?= $settings[4]->value ?>
                      </address>
                    </td>
                    <td rowspan="3" style="border-left: 1px solid #fff;width: 70px;">
                        <?php if($data->Qr_code != ""){ ?>
                          <?php $company_code = $this->session->userdata('logged_in')['company_code']; ?>
                            <img src="<?= base_url() ?>/assets/Qr_code/<?= $company_code.'/'.$data->Qr_code ?>" class="img-thumbnail img-responsive" style="width:150px;margin-top: 2px;"/>
                        <?php } ?>
                    </td>
                    <td style="width: 125px;">
                      <b style="padding-left: 2px;">Invoice No. </b><br/><?= $data->invoice_no ?>
                    </td>
                    <td style="width: 125px;">
                      <b>Dated </b><br/><?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 125px;">
                      <b>Delivery Note </b> <br/><?php echo 'NA';?>
                    </td>
                    <td style="width: 125px;">
                      <b>Mode of Payment </b><br/><?= 'Credit' ?>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 125px;">
                      <b>Supplier's Ref. </b><br/><?= 'NA' ?>
                    </td>
                    <td style="width: 125px;">
                      <b>Other Reference(s)</b> <br/><?= 'NA' ?>
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3" style="width: 270px;" colspan="2">
                      <address>
                        <b><?= $data->FirstName ?> <?= $data->LastName ?></b><br>
                        <?= !empty($data->Address)?$data->Address:'N/A' ?>,
                        <?= !empty($data->City)?$data->City:'N/A' ?>, <?= !empty($data->State)?$data->State:'N/A' ?> - <?= !empty($data->Zip)?$data->Zip:'N/A' ?><br>
                        <b>Mobile </b><?= $data->Mobile ?><br>
                        <b>Email </b><?= $data->Email ?><br>
                        <b>GST Number. </b><?= $data->GST_No ?>
                      </address>
                    </td>
                    <td style="width: 125px;">
                      <b>Buyer's Order No. </b><br/><?= 'NA' ?>
                    </td>
                    <td style="width: 125px;">
                      <b>Dated </b><br/><?= date('d-M-Y', strtotime($data->invoice_date)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Despatch Through </b><br/><?php echo "Road";?>
                    </td>
                    <td>
                      <b>Destination / Place:</b><br/><?= $data->Place ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>E-Way Bill no. </b><br/><?= $data->waybill ?>
                    </td>
                    <td>
                      <b>Vehicle No. </b> <br/><?= $data->Lorry_no ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="border: 1px solid black;" class="table2" cellspacing="0" cellpadding="3">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;">
                    <th style="width: 30px;">SL No.</th>
                    <th style="width: 230px;">Description of Goods</th>
                    <th style="width: 60px;">HSN / SAC</th>
                    <th style="width: 60px;">Quantity</th>
                    <th style="width: 35px;">Rate</th>
                    <th style="width: 30px;">Per</th>
                    <th>Amount</th>
                  </tr>
                <?php $Total_qty = 0; $hsn; $amt; $sr = 0;$cess = 0;$tcs = 0;$Additional_amount = 0; foreach($invoice_details as $details){ ?>
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
                <!--<tr>
                    <td></td>
                    <td style="text-align:left;font-weight: bold;"> <b>Lorry No. </b>&nbsp;<?= $data->Lorry_no ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;"></td>
                  </tr>-->
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
                      <td style="text-align:right;"><?= moneyFormatIndia($data->IGST) ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Output CGST <?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->CGST_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->CGST) ?></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">Output SGST <?= moneyFormatIndia($data->CGST_percentage) ?>%</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->SGST_percentage) ?></td>
                      <td>%</td>
                      <td style="text-align:right;"><?= moneyFormatIndia($data->SGST) ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data->CESS != 0 ){ ?>
                    <tr>
                      <td></td>
                      <td style="text-align:right;font-weight: bold;">GST Compensation Cess (Rs. <?= $data->CESS_value ?> Per Tons )</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;"><?= $data->CESS_value ?></td>
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
                      if($data->IGST == 0){
                        $round_off = moneyFormatIndia(($data->Gross_amount + $data->Additional_amount + $data->CGST + $data->SGST + $data->CESS + $data->TCS) - $data->Roundoff);
                      } else {
                        $round_off = moneyFormatIndia(
                        ($data->Gross_amount + $data->Additional_amount + $data->IGST + $data->CESS + $data->TCS) - $data->Roundoff - $data->Additional_amount );
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
            <td><br/><br/>
              <b>Amount in words: </b><br/><i><?= convert_number($data->Netammount); ?></i>
              <br/>
            </td>
          </tr>
          <tr>
            <td>
            <table style="border: 1px solid black;" class="table" cellspacing="0" cellpadding="3">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;">
                    <td style="width: 200px;" rowspan="2">HSN/SAC</td>
                    <td style="width: 60px;" rowspan="2">Taxable Value</td>
                    <?php if($data->IGST != 0){ ?>
                    <td style="width: 200px;" colspan="2">IGST</td>
                    <?php } else { ?>
                    <td style="width: 100px;" colspan="2">Central Tax</td>
                    <td style="width: 100px;" colspan="2">State Tax</td>
                    <?php } ?>
                    <td style="width: 60px;" rowspan="2">Total Tax Amount</td>
                  </tr>
                  <tr style="text-align: center;font-weight: bold;">
                    <td>Rate</td>
                    <td>Amount</td>
                    <?php if($data->IGST == 0){ ?>
                    <td>Rate</td>
                    <td>Amount</td>
                    <?php } ?>
                  </tr>
                  <?php $tax_value = 0; $cgst = 0; $sgst = 0; $total = 0;$igst = 0; for($i = 1; $i <= count($hsn); $i++){ ?>
                  <tr>
                    <td style="text-align: center;"><?= $hsn[$i] ?></td>
                    <td style="text-align: right;"><?php $tax_value += $amt[$i]+ $Additional_amount ?><?= moneyFormatIndia($amt[$i] + $Additional_amount) ?></td>
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
                  <tr style="font-weight: bold;text-align: right;">
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
            <td><br/><br/>
              <b>Tax Amount (in words): </b><br/><i><?= convert_number($total); ?></i>
              <br/>
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
                          Branch & IFS Code: <?= $bank->branch ?> & <?= $bank->IFC_code ?><br/>
                      </td>
                      <?php } ?>
                      <?php } ?>
                    </tr>
                    <tr style="text-align: left;padding: 50px;font-size: 11pt;">
                      <td style="width: 50%;padding: 5px;"><br/>
                        <u>Declaration</u><br/>
                        <?= $settings[5]->value ?>
                      </td>
                      <td style="width: 50%;text-align: right;border: 1px solid black;padding: 5px;font-size: 11pt;">
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
            <td style="text-align: center;font-size: 11pt;">
            <br/><br/><b><?= $settings[8]->value ?></b><br/>
            <b>This is a Computer Generated Invoice</b>
            </td>
          </tr>
        </tbody>
      </table>
    </header>
  </body>
</html>