<?php if($_SESSION['shop_privilege']==0){ ?>
<div class="col-md-8 col-sm-12">
<?php }?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Stock Principal</small></h2>
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
                          <th>Description</th>
                          <?php if($_SESSION['shop_privilege']==0){ ?>
                          <th>Purchased Price</th>
                          <th>Store Quantity</th>
                          <?php }?>
                          <th>PV</th>
                          <th>Qty. Disponible</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      foreach ($items as $item) {
                        $qty=$item['quantity'] - $item['usedQuantity'];?>
                        <tr>
                          <td>
							              <?=$i;?>
						              </td>
                          <td><?=$item['name'];?></td>
                          <?php if($_SESSION['shop_privilege']==0){ ?>
                          <td><?=$item['purchasedPrice'];?></td>
                           <td><?=$item['quantity'];?></td>
                          <?php }?>
                           <td><?=$item['sellingPrice'];?></td>
                           <?php if($qty==0){
                             echo "<td><b class='bg bg-danger'>Finished</b></td>";
                           }else{
                             echo "<td>".$qty."</td>";
                           };?>
                           <?php if($_SESSION['shop_privilege']==0){ ?>
                           <td>
                           <?php if($qty >= 1){?>
                           <button class="edit-button btn-success btn-sm btn" data-id="<?=$item['id'];?>">Details</button>
                           <?php }?>
                           </td>
                           <?php }?>
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
<?php if($_SESSION['shop_privilege']==0){ ?>
          <div class="x_panel">
                  <div class="x_title">
                    <h2>Nouveau Produit</h2>
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
                    <form id="branchForm" data-parsley-validate action="<?=base_url('manipulateMainStore');?>" method="post">
                      <label for="fullname">Noms * :</label>
                      <input type="text" id="fullname" class="form-control" name="title" required />
                      <input type="hidden" class="form-control" name="itemId" required />
                      <label for="fullname" class="classtype">Type * :</label>
                      <select name="type" class="form-control classtype">
                        <option selected disabled>Type...</option>
                        <option value="0">Unique</option>
                        <option value="1">Plusieurs</option>
                      </select>
                      <label for="fullname">Categorie * :</label>
                      <select name="category" class="form-control">
                        <option selected disabled>Category...</option>
                         <?php foreach ($categories as $category) {?>
                          <option value="<?=$category['id'];?>"><?=$category['title'];?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <label for="fullname">Numero Serie * :</label>
                      <input type="text"  class="form-control" name="serial" />
                      <label for="fullname">Model :</label>
                      <input type="text"  class="form-control" name="model"/>
                        <label for="fullname" class="classQty">Quantite * :</label>
                      <input type="text"  class="form-control classQty" name="quantity"  />
                        <label for="fullname">Prix d'Achat Unitaire * :</label>
                      <input type="text"  class="form-control" name="purchased" required />
                        <label for="fullname">Prix de Vente Unitaire* :</label>
                      <input type="text"  class="form-control" name="selling" required />
                      <label for="fullname">Dernier prix de Vente Unitaire* :</label>
                      <input type="text"  class="form-control" name="lastselling" required />
                      <label>Description</label>
                      <textarea class="form-control" name="desc"></textarea>

                          <br/>
                          <center>
                          <button type="reset" class="btn btn-success" style="width: ">Annuler</button>
                          <button type="submit" class="btn btn-primary" style="width: ">Enregistrer</button>
                          </center>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>

          </div>
          <?php }?>
<script src="<?=base_url('');?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script>
  $(function() {
    //create employee
    $(document).on('submit', '#branchForm', function (event) {
      event.preventDefault();
      $.ajax({
        url: "<?php echo base_url('manipulateMainStore') ?>",
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
              alert(data.error)
            // alert("System error please try again later");
            console.log(e);
          }
        }
      })
    })

    $(".edit-button").on('click',function(e){
      var id=$(this).data('id');
      $.getJSON("<?=base_url();?>getMainItem/" + id, function (data) {
        // alert(id);
        // var remaind=data.quantity-data.usedQuantity;
        $("#branchForm [name='itemId']").val(data.id).change();
        $("#branchForm [name='title']").val(data.name).change();
        $("#branchForm [name='serial']").val(data.serialNumber).change();
        $("#branchForm [name='model']").val(data.model).change();
        $("#branchForm [name='category']").val(data.categoryId).trigger("change");
        $("#branchForm [name='type']").val(data.type).trigger("change");
        $("#branchForm [name='quantity']").val(data.quantity).change();
        $("#branchForm [name='purchased']").val(data.purchasedPrice).change();
        $("#branchForm [name='selling']").val(data.sellingPrice).change();
        $("#branchForm [name='lastselling']").val(data.reduction).change();
        $("#branchForm [name='desc']").text(data.description).change();
      });
      return;
    })

    $(".classtype").on("change",function(){
      var type=$(this).val()
      if (type==0) {
        $(".classQty").hide().attr("required",false);;
      }else{
         $(".classQty").show().attr("required",true);
      }
    })

  })

</script>
