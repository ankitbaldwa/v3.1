<div class="wrapper">

  <?php $this->load->view('Common/header'); ?>
  <?php $this->load->view('Common/sidemenu'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

  <!-- Main content -->
  <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['todays_pending_sum']) ?></h4>

              <p><p>Today's Pending Invoices</p></p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['todays_sum']) ?></h4>

              <p>Today's Received Invoices</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['pending_sum']) ?></h4>

              <p>Total Outstanding</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['overall_sum']) ?></h4>

              <p>Total Received</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal-active">
            <div class="inner">
              <h4><?= $data['total_no_invoices'] ?></h4>

              <p>Current Yr Invoices</p>
            </div>
            <div class="icon">
              <i class="fa fa-files-o"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange-active">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['total_sales']) ?></h4>

              <p>Current Yr Sales</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon-active">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['total_overall_sum']) ?></h4>

              <p>Total Overall Payments</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple-active">
            <div class="inner">
              <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['total_pending_sum']) ?></h4>

              <p>Total Overall Outstanding</p>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable ui-sortable">
           <!-- Custom tabs (Charts with tabs)-->
           <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Monthly Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable ui-sortable">
          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Received Amount Monthwise Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-border">
              <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['pending_invoice'] ?>" data-width="60" data-height="60"
                        data-fgColor="#39CCCC">

                  <div class="knob-label">Pending Invoices</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['completed_invoice'] ?>" data-width="60" data-height="60"
                        data-fgColor="#39CCCC">

                  <div class="knob-label">Completed Invoices</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['part_completed_invoice'] ?>" data-width="60" data-height="60"
                        data-fgColor="#39CCCC">

                  <div class="knob-label">Partly Completed</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <div class="col-lg-6">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Current Year GST</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Month</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>IGST</th>
                    <th>CESS</th>
                    <th>TCS</th>
                    <th>Total Tax</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($complete_gst as $gst){ ?>
                  <tr>
                    <td><?= date('M-Y',strtotime($gst->Month)) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->CGST) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->SGST) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->IGST) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->CESS) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->TCS) ?></td>
                    <td><i class="fa fa-inr"></i> <?= moneyFormatIndia($gst->total_tax) ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-lg-6">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">User Log</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <ul class="todo-list">
                <?php foreach($user_log as $log){ ?>
                <li>
                  <span class="handle">
                    <b><?= name ?> - </b>
                  </span>
                  <!-- todo text -->
                  <span class="text text-wrap" style="width: 35rem;"><?= $log['description'] ?></span>
                  <!-- Emphasis label -->
                  <small class="label label-danger pull-right"><i class="fa fa-clock-o"></i> <?= date('d-m-Y h:i A', strtotime($log['created'])) ?></small>
                </li>
              <?php } ?>
                
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
  <div id="release_notes" tabindex="-1" aria-labelledby="myModalLabel" style="opacity: 1; display: none;">
      <div class="popupPanel box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Release Note</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body text-center">
          <div class="checkIcon"><i class="fa fa-check"></i></div>
          <!-- <button aria-label="Close" data-dismiss="modal" class="popupPanelClose close" type="button">×</button>-->
          <h4><span>- <?= $release_note->name ?> Package v<?= (float)$release_note->version ?> -</span></h4>
          <p class="versionText"><?= $release_note->release_notes?></p>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-primary btn-sm release_note" data-url="<?= $release_note->release_notes_pdf ?>">Release Note</button>
            <button type="button" class="btn btn-danger btn-sm release_cancel">Cancel</button>
            <button type="button" class="btn btn-warning btn-sm release_stop" data-url="<?= site_url().'Welcome\update_release_note' ?>">Don't Show Again</button>
          </div>
      </div>
  </div>
  <!-- Update From Email Setup Popup -->
  <div class="modal" tabindex="-1" role="dialog" id="email_setup_popup">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><b>From Mail Setup For Company</b></h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="from_Email">From Email address</label>
            <input type="email" class="form-control" id="from_Email" aria-describedby="emailHelp" placeholder="Enter email" name="from_Email">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='update_email_setup' data-url="<?= site_url('Welcome/update_email') ?>">Update</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    var show_popup = '<?= $show_popup ?>';
    var script = <?= $script; ?>;
    //var purchase_script = <?//= $purchase_script; ?>;
    var script2 = <?= $script2; ?>;
    //var purchase_script2 = <?//= $purchase_script2; ?>;
    var url ="";
    //release_notes
    var release_note_url = "<?= site_url() .'Welcome/get_release_note' ?>";
  </script> 
  <?php $this->load->view('Common/footer'); ?>
</div>
<!-- ./wrapper -->