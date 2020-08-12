<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?= strtoupper($data->voucher_type) ?> VOUCHER</title>
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
            .table1 {
                border-radius: 5px;
                width: 100%;
                margin: 0px auto;
                float: none;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
            }
            .border{border-bottom:1px dotted #000;}
            .border-none{ border-bottom: none !important;}
            .border-box { border: 1px solid #000; }
            .font-size{ font-size: 12pt; }
            .bold { font-weight: Bold; }
            .w15 { width: 15%;}
            .w5 { width: 5%;}
            .w20 { width: 20%;}
            .table1>tbody>tr>td, .table1>tbody>tr>th, .table1>tfoot>tr>td, .table1>tfoot>tr>th, .table1>thead>tr>td, .table1>thead>tr>th {
                padding: 3px;
                line-height: 1.42857143;
                vertical-align: top;
            }
        </style>
   </head>
   <body>
      <div class="container">
        <table class="table1">
            <tbody>
            <tr>
                <td colspan="5">
                    <h1 class="text-center"><?= $settings[0]->value ?></h1>
                    <p class="text-center"><?= $settings[1]->value ?></p>
                    <p class="text-center"><b>Mobile:</b> <?= $settings[2]->value ?>, <b>Email:</b> <?= $settings[3]->value ?></p>
                    <p class="text-center"><b>GSTIN:</b> <?= $settings[4]->value ?></p>
                    <h3 class="text-center"><u><?= strtoupper($data->voucher_type) ?> VOUCHER</u></h3>
                </td>
            </tr>
            <tr class="font-size">
                <td><p class="pull-left bold">No: <?= $data->voucher_no ?></p></td>
                <td colspan="3">
                    <p class="pull-right bold">Date:</p>
                </td>
                <td class="border w15"><?= date('d-M-Y',strtotime($data->voucher_date)) ?></td>
            </tr>
            <tr>
                <td class="w20 bold"><?= strtoupper($data->voucher_type) ?></td>
                <td class="border"><?= $data->account_name ?></td>
                <td class="w5 border-none bold">A/C</td>
                <td class="w20 border-none bold text-right">Payment Mode:</td>
                <td class="border w20"><?= $data->payment_type ?> </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <?php if($data->payment_type == 'Bank'){ ?>
            <tr>
                <td class="bold">Cheque Date</td>
                <td class="border"><?= date('d-M-Y',strtotime($data->cheque_date)) ?></td>
                <td colspan="2" class="text-right"></b>Cheque No./Bank Name</b></td>
                <td class="border"><?= $data->cheque_no ?> / <?= $data->bank_name ?></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="w15 bold">Paid to</td>
                <td class="border" colspan="4"><?= $data->paidTo ?></td>
            </tr>
            <tr>
                <td class="w15 bold">Towards</td>
                <td class="border" colspan="3"></td>
                <td class="w20 border-box bold">Rs.<?php echo ($data->voucher_type == 'Debit')?moneyFormatIndia($data->debit_amount):moneyFormatIndia($data->credit_amount); ?></td>
            </tr>
            <tr>
                <td class="border bold" colspan="5"><?= convert_number(($data->voucher_type == 'Debit')?$data->debit_amount:$data->credit_amount);?></td>
            </tr>
            <tr>
                <td colspan="5"><br/><br/></td>
            </tr>
            <tr>
                <td class="bold" colspan="2">Reciver's Signature</td>
                <td></td>
                <td class="text-right bold" colspan="2">Authorised Signature</td>
            </tr>
            </tbody>
        </table>
      </div>
      <script src="<?= base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
      <script src="<?= base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
        $('document').ready(function(){ 
           window.print();
        });
        </script>
   </body>
</html>