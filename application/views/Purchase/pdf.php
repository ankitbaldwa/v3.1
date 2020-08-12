<?php ob_get_clean(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PURCHASE INVOICE PDF</title>
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
              <table class="table" style="border: 1px solid black;width: 100%" cellspacing="0" cellpadding="3" >
                <tbody>
                  <tr>
                    <td rowspan="3" style="width: 270px;">
                      <address>
                        <b> <?= $data->FirstName ?> <?= $data->LastName ?></b><br>
                        <?= !empty($data->Address)?$data->Address:'N/A' ?>,
                        <?= !empty($data->City)?$data->City:'N/A' ?>, <?= !empty($data->State)?$data->State:'N/A' ?> - <?= !empty($data->Zip)?$data->Zip:'N/A' ?><br>
                        <b>Mobile </b><?= $data->Mobile ?><br>
                        <b>Email </b><?= $data->Email ?><br>
                        <b>GST Number. </b><?= $data->GST_No ?>
                      </address>
                    </td>
                    <td style="width: 125px;">
                      <b>Invoice No. </b><br/>&nbsp;<?= $data->invoice_no ?>
                    </td>
                    <td style="width: 125px;">
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
                    <td rowspan="3" style="width: 270px;">
                      <address>
                          <strong><?= $settings[0]->value ?></strong><br>
                          <?= $settings[1]->value ?><br>
                          <b><?= $settings[2]->name ?>: </b> <?= $settings[2]->value ?><br>
                          <b><?= $settings[3]->name ?>: </b> <?= $settings[3]->value ?><br>
                          <b><?= $settings[4]->name ?>: </b><?= $settings[4]->value ?>
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
              <table style="border: 1px solid black;" class="table2" cellspacing="0" cellpadding="3">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;">
                    <th style="width: 30px;">SL No.</th>
                    <th style="width: 350px;">Description of Goods</th>
                    <th style="width: 30px;">HSN</th>
                    <th style="width: 65px;">Quantity</th>
                    <th style="width: 65px;">Rate</th>
                    <th style="width: 30px;">Per</th>
                    <th style="width: 80px;">Amount</th>
                  </tr>
                <?php $Total_qty = 0; $hsn; $amt; $sr = 0; $cgst =0; $sgst=0; $igst= 0;$Additional_amount = 0;$cess = 0;$tcs = 0; 
                foreach($invoice_details as $details){ ?>
                    <tr>
                      <td><?= ++$sr ?></td>
                      <td><?= $details->Name?></td>
                      <td><?php $hsn[$sr] = $details->Hsn_code; ?><?= $details->Hsn_code?></td>
                      <td><?php $Total_qty += $details->Qty; ?><?= moneyFormatIndia($details->Qty) ?> <b><?= "" ?></b></td>
                      <td style="text-align:right;"><?= moneyFormatIndia($details->Price)?></td>
                      <td><?= "" ?></td>
                      <td style="text-align:right;"><?php $amt[$sr] = $details->Amount; ?><?= moneyFormatIndia($details->Amount) ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td style="text-align:left;font-weight: bold;"> <b>Lorry No. </b>&nbsp;<?= $data->Lorry_no ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <?php if($data->CESS != 0) { ?>
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
                      <td class="border-top"><b><?= moneyFormatIndia($Total_qty) ?> <?= "" ?></b></td>
                      <td class="border-top"></td>
                      <td class="border-top"></td>
                      <td class="border-top" style="text-align:right;"><b>Rs.<?= moneyFormatIndia($data->Netammount) ?></b></td>
                    </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 5px;">
              <b>Amount in words: </b><br/><i><?= convert_number($data->Netammount); ?></i>
              <br/>
            </td>
          </tr>
          <tr>
            <td>
            <table style="border: 1px solid black;width:100%" class="table" cellspacing="0" cellpadding="3">
                <tbody>
                  <tr style="text-align: center;font-weight: bold;border: 1px solid black;">
                    <th style="width: 200px;text-align: center;border: 1px solid black;" rowspan="2">HSN</th>
                    <th style="width: 60px;text-align: center;border: 1px solid black;" rowspan="2">Taxable Value</th>
                    <?php if($data->IGST != 0){ ?>
                    <th style="width: 200px;text-align: center;border: 1px solid black;" colspan="2">IGST</th>
                    <?php } else { ?>
                    <th style="width: 100px;text-align: center;border: 1px solid black;" colspan="2">Central Tax</th>
                    <th style="width: 100px;text-align: center;border: 1px solid black;" colspan="2">State Tax</th>
                    <?php } ?>
                    <th style="width: 60px;text-align: center;border: 1px solid black;" rowspan="2">Total Tax Amount</th>
                  </tr>
                  <tr style="text-align: center;font-weight: bold;">
                    <td style="text-align: center;border: 1px solid black;">Rate</td>
                    <td style="text-align: center;border: 1px solid black;">Amount</td>
                    <?php if($data->IGST == 0){ ?>
                    <td style="text-align: center;border: 1px solid black;">Rate</td>
                    <td style="text-align: center;border: 1px solid black;">Amount</td>
                    <?php } ?>
                  </tr>
                  <?php $tax_value = 0; $cgst = 0; $sgst = 0; $total = 0;$igst = 0; for($i = 1; $i <= count($hsn); $i++){ ?>
                  <tr>
                    <td style="text-align: center;"><?= $hsn[$i] ?></td>
                    <td ><?php $tax_value += $amt[$i] + $Additional_amount; ?><?= moneyFormatIndia($amt[$i] + $Additional_amount) ?></td>
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
                    <td style="text-align: right;">Total</td>
                    <td style="text-align: right;"><?= moneyFormatIndia($tax_value)?></td>
                    <?php if($data->IGST != 0){ ?>
                      <td></td>
                    <td style="text-align: right;"><?= moneyFormatIndia($igst)?></td>
                      <?php } else { ?>
                    <td></td>
                    <td style="text-align: right;"><?= moneyFormatIndia($cgst)?></td>
                    <td></td>
                    <td style="text-align: right;"><?= moneyFormatIndia($sgst)?></td>
                    <?php } ?>
                    <td style="text-align: right;"><?= moneyFormatIndia($total)?></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 5px;">
              <b>Tax Amount (in words): </b><br/><i><?= convert_number($total); ?></i>
              <br/>
            </td>
          </tr>
          <tr>
            <td>
              <table style="border: 0px solid #fff;" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr style="text-align: left;padding: 50px;font-size: 11pt;">
                      <td style="width: 50%;padding: 5px;"><br/>
                        <u>Declaration</u><br/>
                        <?= $settings[5]->value ?>
                      </td>
                      <td style="width: 50%;text-align: right;border: 1px solid black;padding: 5px;font-size: 11pt;">
                        <b>For  <?= $data->FirstName ?> <?= $data->LastName ?> &nbsp; &nbsp; &nbsp;</b><br/><br/>
                        <br/>
                        <b>Authorised Sign / Accountant / Manager &nbsp;</b>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;font-size: 11pt;padding: 5px;">
            <span style="padding: 5px;"><b><?= $settings[8]->value ?></b></span><br/>
            <span style="padding: 5px;"><b>This is a Computer Generated Invoice</b></span>
            </td>
          </tr>
        </tbody>
      </table>
    </header>
  </body>
</html>