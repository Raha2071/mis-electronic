<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Electronic Shop | Login</title>

    <!-- Bootstrap -->
    <link href="<?=base_url('');?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('');?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url('');?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?=base_url('');?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url('');?>assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?=base_url('login_pro');?>" method="post">
                <?php
                if (!empty($error)) {
                  ?>
                  <div class="alert alert-danger">
                    <label class="alert-heading"><?= lang("loginFailed"); ?></label>
                    <p><?= $error; ?></p>
                  </div>
                  <?php
                }
                ?>              
                <h1>Login</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="email" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" >Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <h1><i class="fa fa-paw"></i> ESMS</h1>
                  <p>©2020 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
