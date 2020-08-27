<div class="login-box">
  <div class="login-logo">
    <b class="text-uppercase"><?= $company_name ?></b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <span class="errid"><?php echo $this->session->userdata('login_error') <> '' ? $this->session->userdata('login_error') : ''; ?></span>
    <form action="<?= site_url('login-action')?>" method="post" onsubmit="return validation();">
      <div class="form-group has-feedback">
      	<input type="email" class="form-control" id="email" placeholder="Enter E-mail" name="email" autocomplete="off" value="<?php echo set_value('email'); ?>">
		<?php echo form_error('email'); ?>
    <span class="text text-danger" id="error_email"></span>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
		<?php echo form_error('password'); ?>
    <span class="text text-danger" id="error_password"></span>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat login"><?= $button;?></button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="<?= base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  var url ="";
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
function validation(){
        var email = $("#email").val().trim();
        var password = $("#password").val().trim();
        var alpha = /^[a-z A-Z]+$/;
        var validateEmail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        
        if(email =='')
        {
          $("#error_email").fadeIn().html("Please enter email").css("color","red");
          setTimeout(function(){$("#error_email").fadeOut("&nbsp;");},2000)
          $("#email").focus();
          return false;       
        }
        else if(!validateEmail.test(email))
        {
          $("#error_email").fadeIn().html("Please enter valid email").css("color","red");
          setTimeout(function(){$("#error_email").fadeOut("&nbsp;");},2000)
          $("#email").focus();
          return false;       
        }

        if(password =='')
        {
          $("#error_password").fadeIn().html("Please enter password").css("color","red");
          setTimeout(function(){$("#error_password").fadeOut("&nbsp;");},2000)
          $("#password").focus();
          return false;       
        }
        /*else if(password.length>'0' && password.length>'8')
        {
            $("#error_password").fadeIn().html("Password should be 8 characters only").css("color","red");
            setTimeout(function(){$("#error_password").fadeOut("&nbsp;");},2000)
            $("#password").focus();
            return false;
        }*/
}

setTimeout(function(){$("#messages").fadeOut();},3000);
</script>