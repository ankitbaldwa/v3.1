<!-- Purchase Blocks -->
<div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['pur_todays_pending_sum']) ?></h4>
              </div>
              <div class="icon">
                <i class="fa fa-inr"></i>
              </div>
              <a href="#" class="small-box-footer"><p>Today's Pending Invoices</p></a>
            </div>
        </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['pur_todays_sum']) ?></h4>
              </div>
              <div class="icon">
                <i class="fa fa-inr"></i>
              </div>
              <a href="#" class="small-box-footer"><p>Today's Received Invoices</p></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['pur_pending_sum']) ?></h4>
              </div>
              <div class="icon">
                <i class="fa fa-inr"></i>
              </div>
              <a href="#" class="small-box-footer"><p>Total Outstanding</p></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h4><i class="fa fa-inr"></i> <?= moneyFormatIndia($data['pur_overall_sum']) ?></h4>
              </div>
              <div class="icon">
                <i class="fa fa-inr"></i>
              </div>
              <a href="#" class="small-box-footer"><p>Total Received</p></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
              <!-- Tabs within a box -->
              <ul class="nav nav-tabs pull-right">
                <li class="pull-left header"><i class="fa fa-inbox"></i> Monthly Purchases</li>
              </ul>
              <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="purchase-chart" style="position: relative; height: 300px;"></div>
              </div>
            </div>
            <!-- /.nav-tabs-custom -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
              <div class="box-header">
                <i class="fa fa-th"></i>

                <h3 class="box-title">Purchase Payment Amt Monthwise Graph</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body border-radius-none">
                <div class="chart" id="purchase-payment" style="height: 250px;"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-border">
                <div class="row">
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['pending_pur_invoice'] ?>" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">Pending Purchases</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['completed_pur_invoice'] ?>" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">Completed Purchases</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="<?= $Donut_chart['part_pur_completed_invoice'] ?>" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">Partly Completed Purchases</div>
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