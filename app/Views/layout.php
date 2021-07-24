<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Vakasukari | <?=$title;?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url('');?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('');?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url('');?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?=base_url('');?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?=base_url('');?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?=base_url('');?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?=base_url('');?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url('');?>assets/build/css/custom.min.css" rel="stylesheet">
        <!-- Datatables -->
    <link href="<?=base_url('');?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/plugins/select2/css/select2.css" rel="stylesheet"></link>
    <link href="<?=base_url('');?>assets/plugins/select2/css/select2.min.css" rel="stylesheet"></link>
    <link href="<?=base_url('');?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <!-- Toastr css -->
    <link href="<?=base_url('');?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="<?=base_url('');?>assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?=base_url('');?>assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet"> -->
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?=base_url('dashboard');?>" class="site_title"><i class="glyphicon glyphicon-cog"></i> <span>Vakasukari</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=base_url();?>/assets/images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <h2><?=$_SESSION['shop_name'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="<?=base_url('dashboard');?>"><i class="fa fa-home"></i> Dashboard </a></li>
                  <?php if($_SESSION['shop_privilege']==0){ ?>
                  <li><a href="<?=base_url('employees');?>"><i class="fa fa-users"></i> Utilisateurs</a></li>
                  <li><a href="<?=base_url('categories');?>"><i class="fa fa-edit"></i> Categories</a></li>
                  <?php }?>
                  <!-- <li><a href="<?=base_url('branches');?>"><i class="fa fa-laptop"></i> Branches</a></li> -->
                  <li><a href="<?=base_url('mainstore');?>"><i class="fa fa-desktop"></i>Stock Principal</a></li>
                  <li><a href="<?=base_url('Clients');?>"><i class="fa fa-users"></i> Clients</a></li>
                  <li><a href="<?=base_url('generalReport');?>"><i class="fa fa-bar-chart"></i>Rapport General</a></li>
                  <li><a href="<?=base_url('productReport');?>"><i class="fa fa-line-chart"></i>Rappor Selon Produit</a></li>
                  <?php if($_SESSION['shop_privilege']==0){ ?>
                  <li><a href="<?=base_url('inventaire');?>"><i class="fa fa-edit"></i>Inventaire</a></li>
                  <?php }?>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?=base_url('profile');?>">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url('logout');?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=base_url();?>/assets/images/user.png" alt=""><?=$_SESSION['shop_name'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=base_url('profile');?>"> Profile</a></li>
                    <li><a href="<?=base_url('logout');?>"><i class="fa fa-sign-out pull-right"></i> Deconnexion</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            <?=$content;?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Vakasukari
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?=base_url('');?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url('');?>assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url('');?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url('');?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=base_url('');?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?=base_url('');?>assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?=base_url('');?>assets/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?=base_url('');?>assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?=base_url('');?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?=base_url('');?>assets/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?=base_url('');?>assets/vendors/Flot/jquery.flot.js"></script>
    <script src="<?=base_url('');?>assets/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url('');?>assets/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?=base_url('');?>assets/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?=base_url('');?>assets/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?=base_url('');?>assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?=base_url('');?>assets/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?=base_url('');?>assets/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?=base_url('');?>assets/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?=base_url('');?>assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?=base_url('');?>assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?=base_url('');?>assets/vendors/moment/min/moment.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url('');?>assets/build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script src="<?=base_url('');?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?=base_url('');?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?=base_url('');?>assets/plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- Toastr js -->
      <script src="<?=base_url('');?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
	   <script type="text/javascript">
      $(function(){
        $(".select2").select2();
      })
      function done (value) {
      toastr.options = {
          type: 'success',
          closeButton: true,
          progressBar: true,
          showMethod: 'slideDown',
          timeOut: 1000
      };
      toastr.success(value,'Notification: ');
      }
      function wrong (value) {
      toastr.options = {
          type: 'error',
          closeButton: true,
          progressBar: true,
          showMethod: 'slideDown',
          timeOut: 1000
      };
      toastr.error(value,'Notification: ');
      }

     </script>
  </body>
</html>
