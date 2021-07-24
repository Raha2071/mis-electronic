<div class="col-md-8 col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Categories</small></h2>
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
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>
							               #
						             </th>
                          <th>Titre</th>
                          <th>Fait par</th>
                          <th>Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      foreach ($branches as $branche) {?>
                        <tr>
                          <td onclick="getData('test')">
							              <?=$i;?>
						              </td>
                          <td><?=$branche['title'];?></td>
                          <td><?=$branche['operator'];?></td>
                           <td><?=$branche['created_at'];?></td>
                           <td><button class="edit-button btn-success btn-sm btn" data-id="<?=$branche['id'];?>">view</button></td>
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


          <div class="col-md-4 col-sm-12">

          <div class="x_panel">
                  <div class="x_title">
                    <h2>Nouvelle Categorie</h2>
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
                    <form id="branchForm" data-parsley-validate action="<?=base_url('manipulateCategory');?>" method="post">
                      <label for="fullname">Titre * :</label>
                      <input type="text" id="fullname" class="form-control" name="title" required />
                      <label for="fullname">Description * :</label>
                      <textarea class="form-control" name="description"></textarea>
                      <input type="hidden" class="form-control" name="categoryId" required />
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
<script src="<?=base_url('');?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script>
  $(function() {
    //create employee
    $(document).on('submit', '#branchForm', function (event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url('manipulateCategory') ?>",
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
              $('#branchForm')[0].reset();
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
      $.getJSON("<?=base_url();?>getCategory/" + id, function (data) {
        // alert(id);
        $("#branchForm [name='categoryId']").val(data.id).change();
        $("#branchForm [name='title']").val(data.title).change();
        $("#branchForm [name='description']").text(data.description).change();
      });
      return;
    })

  })

</script>
