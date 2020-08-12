<div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= base_url() ?>/assets/dist/img/<?= $userdata->profile ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?= strtoupper($userdata->username) ?></h3>

              <p class="text-muted text-center"><?= strtoupper($userdata->role) ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?= $userdata->email ?></a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="pull-right"><?= $userdata->mobile ?></a>
                </li>
                <li class="list-group-item">
                  <b>IP Address</b> <a class="pull-right"><?= $userdata->ip_address ?></a>
                </li>
                <li class="list-group-item">
                  <b>Last Login</b> <a class="pull-right"><?= date('d-M-Y h:i A', strtotime($userdata->last_login)) ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>