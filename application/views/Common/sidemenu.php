<!-- Left side column. contains the logo and sidebar -->

  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->

    <section class="sidebar">

      <!-- Sidebar user panel -->

      <div class="user-panel">

        <div class="pull-left image">

          <img src="<?= base_url() ?>/assets/dist/img/<?= profile ?>" class="img-circle" alt="User Image">

        </div>

        <div class="pull-left info">
          <p><i><u><?php echo ucfirst(LOGO); ?></u></i></p>
          <p><?php echo ucfirst(name); ?></p>

        </div>

      </div>
       <!-- search form -->
       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control search-menu-box" placeholder="Search..." autocomplete="off">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu" data-widget="tree">

        <li class="<?= ($this->uri->segment(1) == 'dashboard')?'active':'' ?>">

          <a href="<?= site_url(DASHBOARD) ?>">

            <i class="fa fa-dashboard"></i> <span>Dashboard</span>

          </a>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-bookmark"></i>

            <span>Manage Masters</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?= site_url('countries') ?>"><i class="fa fa-circle-o"></i> Countries</a></li>

            <li><a href="<?= site_url('states') ?>"><i class="fa fa-circle-o"></i> States</a></li>

            <li><a href="<?= site_url('city') ?>"><i class="fa fa-circle-o"></i> Cities</a></li>

          </ul>

        </li>

        <?php if($this->session->userdata('logged_in')['role'] == 'Admin') { ?>

        <li class="<?= ($this->uri->segment(1) == 'users')?'active':'' ?>">

          <a href="<?= site_url(USERS) ?>">

            <i class="fa fa-users"></i> <span>Manage Companies</span>

          </a>

        </li>

        <?php } ?>

        <li class="<?= ($this->uri->segment(1) == PRODUCTS)?'active':'' ?>">

          <a href="<?= site_url(PRODUCTS) ?>">

            <i class="fa fa-th"></i> <span>Manage Products</span>

          </a>

        </li>

        <!--<li class="<?= ($this->uri->segment(1) == SUPPLIERS)?'active':'' ?>">

          <a href="<?= site_url(SUPPLIERS) ?>">

            <i class="fa fa-users"></i> <span>Manage Suppliers</span>

          </a>

        </li>-->
        <li class="<?= ($this->uri->segment(1) == CUSTOMERS)?'active':'' ?>">

          <a href="<?= site_url(CUSTOMERS) ?>">

            <i class="fa fa-users"></i> <span>Manage Customers</span>

          </a>

        </li>

        <li class="<?= ($this->uri->segment(1) == VOUCHER)?'active':'' ?>">

          <a href="<?= site_url(VOUCHER) ?>">

            <i class="fa fa-file-text-o"></i> <span>Manage Vouchers</span>

          </a>

        </li>

        <!--<li class="<?= ($this->uri->segment(1) == PURCHASE)?'active':'' ?>">

          <a href="<?= site_url(PURCHASE) ?>">

            <i class="fa fa-file-text-o"></i> <span>Purchase Bills</span>

          </a>

        </li>-->

        <li class="<?= ($this->uri->segment(1) == INVOICES)?'active':'' ?>">

          <a href="<?= site_url(INVOICES) ?>">

            <i class="fa fa-file-text-o"></i> <span>Sales Bills</span>

          </a>

        </li>

        <li class="treeview">

          <a href="#">

            <i class="fa fa-file"></i>

            <span>Sales Reports</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li class="<?= ($this->uri->segment(1) == MONTHLY_REPORT)?'active':'' ?>"><a href="<?= site_url(MONTHLY_REPORT) ?>"><i class="fa fa-circle-o"></i> Monthly Report</a></li>

            <li class="<?= ($this->uri->segment(1) == GST_REPORT)?'active':'' ?>"><a href="<?= site_url(GST_REPORT) ?>"><i class="fa fa-circle-o"></i> GST Report</a></li>

            <li class="<?= ($this->uri->segment(1) == OUTSTANDING_REPORT)?'active':'' ?>"><a href="<?= site_url(OUTSTANDING_REPORT) ?>"><i class="fa fa-circle-o"></i> Outstanding Bill Report</a></li>

            <li class="<?= ($this->uri->segment(1) == CUSTOMER_REPORT)?'active':'' ?>"><a href="<?= site_url(CUSTOMER_REPORT) ?>"><i class="fa fa-circle-o"></i> Customer Report</a></li>

            <li class="<?= ($this->uri->segment(1) == PAYMENT_REPORT)?'active':'' ?>"><a href="<?= site_url(PAYMENT_REPORT) ?>"><i class="fa fa-circle-o"></i> Payment Report</a></li>

          </ul>

        </li>
        <!--<li class="treeview">

          <a href="#">

            <i class="fa fa-file"></i>

            <span>Purchase Reports</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li class="<?= ($this->uri->segment(1) == MONTHLY_PURCHASE_REPORT)?'active':'' ?>"><a href="<?= site_url(MONTHLY_PURCHASE_REPORT) ?>"><i class="fa fa-circle-o"></i> Monthly Report</a></li>

            <li class="<?= ($this->uri->segment(1) == PURCHASE_GST_REPORT)?'active':'' ?>"><a href="<?= site_url(PURCHASE_GST_REPORT) ?>"><i class="fa fa-circle-o"></i> GST Report</a></li>

            <li class="<?= ($this->uri->segment(1) == PURCHASE_OUTSTANDING_REPORT)?'active':'' ?>"><a href="<?= site_url(PURCHASE_OUTSTANDING_REPORT) ?>"><i class="fa fa-circle-o"></i> Outstanding Bill Report</a></li>

            <li class="<?= ($this->uri->segment(1) == SUPPLIERS_REPORT)?'active':'' ?>"><a href="<?= site_url(SUPPLIERS_REPORT) ?>"><i class="fa fa-circle-o"></i> Suppliers Report</a></li>

            <li class="<?= ($this->uri->segment(1) == PURCHASE_PAYMENT_REPORT)?'active':'' ?>"><a href="<?= site_url(PURCHASE_PAYMENT_REPORT) ?>"><i class="fa fa-circle-o"></i> Payment Report</a></li>

          </ul>

        </li>-->
        <li class="<?= ($this->uri->segment(1) == PROFILE || $this->uri->segment(1) == TAXES || $this->uri->segment(1) == BANK_DETAILS || $this->uri->segment(1) == SETTINGS || $this->uri->segment(1) == CHANGEPASSWORD)?'active':'' ?>">

          <a href="<?= site_url(PROFILE) ?>">

            <i class="fa fa-file-text-o"></i> <span>Configuration</span>

          </a>

        </li>
        <li>
            <a href="<?= site_url(RELEASE_NOTES) ?>" target="_blank">
                <i class="fa fa-file-text-o"></i> Release Notes
            </a>
        </li>
        <li>
        <a href="<?= site_url(LOGOUT)?>"><i class="fa fa-sign-out"></i><span>Sign out</span></a>
        </li>

      </ul>

    </section>

    <!-- /.sidebar -->

  </aside>