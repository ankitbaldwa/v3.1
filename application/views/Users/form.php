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
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <li><a href="<?= site_url('users') ?>">Manage Companies</a></li>
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
                    <div class="col-md-7">
                      <form class="form-horizontal" method="post" action="<?= $action ?>">
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="Username">Username</label>
                            <div class="col-sm-10">
                              <input type="text" placeholder="Username" id="username" class="form-control" name="username" value="<?= (isset($data))?$data->username:'' ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="Email">Email</label>
                            <div class="col-sm-10">
                              <input type="email" placeholder="Email" id="email" class="form-control" name="email" value="<?= (isset($data))?$data->email:'' ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="Mobile">Mobile</label>
                            <div class="col-sm-10">
                              <input type="tel" placeholder="Mobile" id="mobile" class="form-control" name="mobile" value="<?= (isset($data))?$data->mobile:'' ?>">
                            </div>
                          </div>
                          <?php if(!isset($data)){?>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="Password">Password</label>
                            <div class="col-sm-10">
                              <input type="password" placeholder="Password" id="password" class="form-control" name="password">
                            </div>
                          </div>
                        <?php } else { ?>
                          <input type="hidden" id="id" class="form-control" name="id" value="<?= (isset($data))?$data->id:'' ?>">
                        <?php }?>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <div class="box-footer">
                                <button class="btn btn-info" type="submit">Submit</button>
                                <a href="<?= site_url('users') ?>"><button class="btn btn-default" type="button">Cancel</button></a>
                              </div>
                              <!-- /.box-footer -->
                            </div>
                          </div>
                        <!-- /.box-body -->
                      </form>
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
