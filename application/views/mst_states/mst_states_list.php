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
                <h3 class="box-title pull-right">
                    <a class="btn btn-primary btn-xs" href="<?= site_url('states_create') ?>" title = "Create"><?= "Create" ?></a> 
                </h3>
              </div>
		<!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                 <table class="table table-bordered table-striped example_datatable">
                    <thead>
                        <tr>
                            <th width="80px">No</th>
                            <th>Country Name</th>
                            <th>State Name</th>
                            <th>State Code</th>
                            <th>Status</th>
                            <th>Actions</th>
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
    var url = "Mst_states/json";
    var actioncolumn=7;
</script>