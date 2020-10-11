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
              	<div class="box-header with-border">
                  <form method="post" action="<?= site_url(CUSTOMER_REPORT_EXCEL)?>">
                    <div class="form-group">
                        <select name="months" class="form-control pull-left" style="width:30%" id="customer_ledger">
                            <?php
                                foreach ($customers as $key => $value) {
                                    echo "<option value='".$value->id."'>".$value->FirstName." ".$value->LastName."</option>";
                                }
                            ?>
                        </select> 
                        <div class="pull-right">
                          <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="true"><span class="fa fa-download"></span> Export Tools</button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" class="navi-link" id="export_print">
                                            <span class="fa fa-print"></span> Print
                                    </a></li>
                              <li><a href="#" class="navi-link" id="export_excel">
                                            <span class="fa fa-file-excel-o"></span> Excel
                                    </a></li>
                              <li><a href="#" class="navi-link" id="export_pdf">
                                            <span class="fa fa-file-pdf-o"></span> PDF
                                    </a></li>
                            </ul>
                          </div>
<!--<button type="submit" class="btn btn-success btn-xs"><i class="fa fa-file-excel-o"></i> Export To Excel</button>-->
                        </div>
                    </div>
                  </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                 <table class="table table-bordered table-striped ledger_datatable">
                    <thead>
                        <tr>
                           <!-- <th>Sr No</th> -->
                            <th style="width: 10%;">Transaction Date</th>
                            <th>Description</th>
                            <th>Ref</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
    var url = "<?= site_url(LEDGER_AJAX);?>";
    var actioncolumn=12;
</script>
