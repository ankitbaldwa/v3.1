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

      <?php $this->load->view('Common/profile'); ?>

        <!-- /.col -->

        <div class="col-md-9">

          <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">

              <li><a href="<?= site_url(PROFILE) ?>">Profile</a></li>

              <li class="active"><a href="<?= site_url(TAXES) ?>">Taxes</a></li>

              <li><a href="<?= site_url(BANK_DETAILS)?>">Bank Details</a></li>

              <li><a href="<?= site_url(SETTINGS) ?>">General Settings</a></li>

              <li><a href="<?= site_url(CHANGEPASSWORD) ?>">Change Password</a></li>

            </ul>

            <div class="tab-content">

              <div class="active tab-pane" id="activity">

                  <table class="table table-bordered table-striped">

                      <thead>

                          <tr>

                              <th>Name</th>

                              <th>Value</th>

                              <th>Action</th>

                          </tr>

                      </thead>

                      <tbody>

                        <?php foreach($taxes as $data){ ?>

                        <tr>

                          <th><?= $data->name ?></th>

                          <td>
                            <?php if($data->name == 'CESS'){ ?>
                            <span id="dis<?= $data->name ?>">Rs. <?= $data->value ?></span><input type="text" name="<?= $data->name ?>" id="<?= $data->name ?>input" value="<?= $data->value ?>">
                          <?php } else { ?>
                            <span id="dis<?= $data->name ?>"><?= $data->value ?> %</span><input type="text" name="<?= $data->name ?>" id="<?= $data->name ?>input" value="<?= $data->value ?>">
                          <?php } ?>
                          </td>

                          <td><input type="hidden" id="id<?= $data->name ?>" value="<?= $data->id ?>"><button class="btn btn-info btn-xs" id="edit<?= $data->name ?>" type="button"><i class="fa fa-pencil"></i></button><button class="btn btn-success btn-xs" id="save<?= $data->name ?>" type="button">Save</button></td>

                        </tr>

                        <?php }?>

                      </tbody>

                  </table>

              </div>

              <!-- /.tab-pane -->

            </div>

            <!-- /.tab-content -->

          </div>

          <!-- /.nav-tabs-custom -->

        </div>

        <!-- /.col -->

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

    var url = "<?= base_url(TAXES_UPDATE)?>";

    var actioncolumn='';

</script>

