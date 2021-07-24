              <div class="col-md-8 col-sm-12 col-xs-8">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employees</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>
							               #
						             </th>
                          <th>Noms</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      foreach ($employees as $employee) {?>
                        <tr>
                          <td>
							              <?=$i;?>
						              </td>
                          <td><?=$employee['names'];?></td>
                          <td><?=$employee['email'];?></td>
                           <td><?=$employee['phone'];?></td>
                           <td>
                              <button class="edit-button btn-success btn-sm btn" data-id="<?=$employee['id'];?>">Afficher</button>
                              <button class="delete-button btn-danger btn-sm glyphicon glyphicon-trash" data-id="<?=$employee['id'];?>" data-target="#deleteEmployee" data-toggle="modal"></button>
                           </td>
                        </tr>

                        <?php
                         $i++;
                      }
                        ?>
                        </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              <div class="col-md-4 col-sm-12 col-xs-4">

          <div class="x_panel">
                  <div class="x_title">
                    <h2>Nouveau Employe</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                    <form id="employeeForm" data-parsley-validate action="<?=base_url('manipulateEmployees');?>" method="post">
                      <label for="fullname">Noms * :</label>
                      <input type="text" id="fullname" class="form-control" name="name" required />
                      <input type="hidden"  class="form-control" name="employeeId" required />
                      <label for="fullname">No Identification * :</label>
                      <input type="number"  class="form-control" name="identification" required />
                       <!-- <label>Branche</label> -->
                      <!-- <select class="form-control" name="branch">
                        <option selected disabled> Branch...</option>
                        <option value="0">Headquator</option>
                        
                      </select> -->
                      <label>Role</label>
                      <select class="form-control" name="role">
                        <option selected disabled> Role...</option>
                        <option value="0">Administrateur</option>
                        <option value="1">Vendeur</option>
                        <!-- <option value="2">Receptionist</option> -->
                      </select>
                      <label for="email">Email * :</label>
                      <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required />
                      <label for="email">Phone * :</label>
                      <input type="number" id="phone" class="form-control" name="phone" data-parsley-trigger="change" required />
                      <label for="email">Addresse * :</label>
                      <input type="text" id="location" class="form-control" name="address" data-parsley-trigger="change" required />
                          <br/>
                          <center>
                          <button type="reset" class="btn btn-success" style="width: ">Clear</button>
                          <button type="submit" class="btn btn-primary" style="width: ">Save</button>
                          </center>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
         
          </div>
    <div class="modal fade" id="deleteEmployee" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header"><p class="modal-title" id="exampleModalLabel">Vakasukari<span class="text-muted"> | Suppression de'Employe</span></p></div>
          <div class="modal-body">
              <form method="post" action="" class="form-group"id="deleteEmplForm" >
                <p id="namesemployee"></p>
                <input type="hidden" hidden="" value="" name="id">
                <button class="btn btn-secondary btn-default" type="button" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-sm btn-success" value="Supprime">
            </form>
          </div>
        </div>
      </div>
    </div>
<script src="<?=base_url('');?>assets/vendors/jquery/dist/jquery.min.js"></script>

<script>
  $(function() {
    $('#datatable').DataTable({
    "ordering": false
});
    //create employee
    $(document).on('submit', '#employeeForm', function (event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url('manipulateEmployees') ?>",
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
              $('#employeeForm')[0].reset();
              window.location.reload();
            }
          } catch (e) {
            alert("System error please try again later");
            console.log(e);
          }
        }
      })
    })

    $(".edit-button").on('click',function(e){
      var id=$(this).data('id');
      $.getJSON("<?=base_url();?>getEmployee/" + id, function (data) {
        // alert(id);
        $("#employeeForm [name='employeeId']").val(data.id).change();
        $("#employeeForm [name='name']").val(data.names).change();
        $("#employeeForm [name='email']").val(data.email).change().attr("readonly",true);
        $("#employeeForm [name='phone']").val(data.phone).change();
        $("#employeeForm [name='address']").val(data.address).change();
        $("#employeeForm [name='identification']").val(data.identification).change();
        // $("#employeeForm [name='branch']").val(data.brancheId).trigger('change');
        $("#employeeForm [name='role']").val(data.privilege).trigger('change');
      });
      return;
    })
    $(".delete-button").on("click",function(e){
      var id = $(this).data('id');
      // alert(id);
      $.getJSON("<?=base_url();?>getEmployee/"+id,function(data){
        $("#namesemployee").html('Names: ' +data.names +'</br> Email: '+data.email+'</br> Phone: '+data.phone);
        
        $("#deleteEmployee [name='id']").val(data.id).change();
      })
      return;
    })
    $(document).on('submit', '#deleteEmplForm', function (event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url('deleteEmployee') ?>",
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
							$('#deleteEmplForm')[0].reset();
							$('#deleteEmployee').hide();
							window.location.reload();
						}
					} catch (e) {
						alert("System error please try again later");
						console.log(e);
					}
        }
      })
    })

  })
  
</script>
