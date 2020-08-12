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
        <li><a href="<?= site_url(PRODUCTS) ?>">Manage Products</a></li>
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
                    <div class="col-md-9">
                      <form class="form-horizontal" method="post" action="<?= $action ?>" id="product">
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Name">Product Name <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Product Name" id="Name" class="form-control" name="Name" value="<?= (isset($data))?$data->Name:' ' ?>">
                              <span class="text text-danger" id="errname"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Description">Description <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <textarea id="editor1" name="Description" rows="10" cols="50">
                                 <?= (isset($data))?$data->Description:'' ?>
                              </textarea>
                              <span class="text text-danger" id="errdescription"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Hsn_code">Hsn code <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Hsn code" id="Hsn_code" class="form-control" name="Hsn_code" value="<?= (isset($data))?$data->Hsn_code:'' ?>">
                              <span class="text text-danger" id="errhsncode"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Unit">Unit <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Unit" id="Unit" class="form-control" name="Unit" value="<?= (isset($data))?$data->Unit:'' ?>">
                              <span class="text text-danger" id="errunit"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="Cost">Cost <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" placeholder="Cost" id="Cost" class="form-control" name="Cost" value="<?= (isset($data))?$data->Cost:'' ?>">
                              <span class="text text-danger" id="errcost"></span>
                            </div>
                          </div>
                        <?php if(isset($data)){?>
                          <input type="hidden" id="id" class="form-control" name="id" value="<?= (isset($data))?$data->id:'' ?>">
                        <?php }?>
                          <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                              <div class="box-footer">
                                <button class="btn btn-info" type="button" id="button">Submit</button>
                                <a href="<?= site_url(PRODUCTS) ?>"><button class="btn btn-default" type="button">Cancel</button></a>
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
<script>
    var url = "";
    var actioncolumn="";
</script>