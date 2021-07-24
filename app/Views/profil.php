<!-- page content -->
            <div class="page-title">
              <div class="title_left">
                <h3>Profile</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-4">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 profile_left">
                      <div class="profile_img text-center">
							<img class="profile-user-img img-fluid img-circle"
								 src="<?=base_url();?>/assets/images/user.png"
								 alt="User profile picture">
						</div>
                        <br>
                      <h3 class="text-center"><?=$employees['names'];?></h3>
						<p class="text-muted text-center">Account</p>
                        <center>
						<strong><i class="fa fa-phone mr-1"></i> Phone</strong>

						<p class="text-muted">
							<?=$employees['phone'];?>
						</p>
						<strong><i class="fa fa-envelope mr-1"></i> Email</strong>

						<p class="text-muted">
							<?=$employees['email'];?>
						</p>
						<a href="#" class="btn btn-primary"><b>Activate</b></a>
                        </center>
                      <br />

                      <!-- start skills -->

                    </div>
                  </div>
                </div>
              </div>
                  </div>
            <div class="col-md-8">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" style="cursor: pointer!important;background-color: #007bff;color: #fff" href="#basicInfo" data-toggle="tab">Change Password</a></li>
						</ul>
					</div>
                    <hr>
					<div class="card-body">
						<div class="tab-content">
							<div class="active tab-pane" id="basicInfo">
								<form class="form-horizontal" id="updatePass" method="post" action="<?=base_url('changePassword');?>">
									<div class="form-group row">
										<label for="inputName" class="col-sm-2 col-form-label">Mot de passe Actuel</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="currentPassword"  placeholder="Current Password">
										</div>
									</div>
									<div class="form-group row">
										<label for="inputEmail" class="col-sm-2 col-form-label">Nouveau Mot de passe</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="newPassword"  placeholder="New Password" id="password">
										</div>
									</div>
									<div class="form-group row">
										<label for="inputName2" class="col-sm-2 col-form-label" >Confirmer le Mot de passe</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" data-parsley-equalto-message="Password Mismatch" data-parsley-equalto="#password" placeholder="Confirm Password">
										</div>
									</div>
									<div class="form-group">
                                    <label class="col-sm-2 col-form-label"></label>
										<div class="offset-ms-2 col-sm-10">
											<button style="width: 100%;background-color: #007bff;color: #fff" type="submit" class="btn btn-default">Changer</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /.tab-content -->
				</div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /page content -->
<script src="<?=base_url('');?>assets/vendors/jquery/dist/jquery.min.js"></script>
        <script>
		$(document).on('submit', '#updatePass', function (event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url('changePassword') ?>",
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        cache: false,
        async: false,
        success: function (data) {
          var json = null;
          try {
            json = JSON.parse(data);
            if (json.hasOwnProperty("error")) {
              wrong(json.error);
            } else {
              done(json.success);
              $('#updatePass')[0].reset();
              window.location.reload();
            }
          } catch (e) {
            alert("System error please try again later");
            console.log(e);
          }
        }
      })
    })

</script>