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
                  <form method="post" action="<?= site_url($excel_Report)?>">
                    <div class="form-group">
                        <select name="months" class="form-control pull-left" style="width:30%" id="month">
                            <?php
                                foreach ($months as $key => $value) {
                                    $res = (date('F-Y') == $value->MONTH)?'selected':'';
                                    echo "<option value='".$value->MONTH."' ".$res.">".$value->MONTH."</option>";
                                }
                            ?>
                        </select>
                        <div class="pull-right">
                          <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-file-excel-o"></i> Export To Excel</button>
                        </div>
                    </div>
                  </form>
                
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                 <table class="table table-bordered table-striped reports_datatable">
                    <thead>
                        <tr>
                            <?= $table ?>
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
    var url = "<?= site_url($ajax);?>";
    var actioncolumn=8;
</script>
