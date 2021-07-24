<div class="row">
	<div class="col-md-8">
		<div class="x_panel" id="printfacture">
			<div class="x_title">
				<h2>Facture</h2><button class="pull-right btn btn-default fa fa-print" id="printButton">Print</button>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form id="saveInvoiceForm" action="<?=base_url('');?>" method="POST">
				<section class="content invoice">
					<!-- title row -->
					<div class="row" >
						<div class="col-xs-12 invoice-header">
							<h1>
								<i class="fa fa-globe"></i> Facture.
								<small class="pull-right" style="font-size: 13px">Date: <?=date('d-m-Y h:i:s');?></small>
							</h1>
						</div>
						<!-- /.col -->
					</div>
					<!-- info row -->
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">

								<address>
									<strong>Boutique Vakasuri</strong>
									<br>Butembo
									<br>Nord-kvu
									<br>Rdc
									<br>Email: vakasukari@gmail.com
								</address>
							</div>
						<!-- /.col -->
						<div class="col-sm-4 invoice-col">
							A
							<address>
								<strong><?=$clients['name'];?></strong>
								<br>Phone: <?=$clients['phone'];?>
								<br>Email: <?=$clients['email'];?>
							</address>
						</div>
						<!-- /.col -->
						<div class="col-sm-4 invoice-col">
							<b>Invoice # <span id="invId"></span> #</b>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
						<div class="col-xs-12 table">
							<table class="table table-striped" id="reportTable">
								<thead>
									<tr>
										<th>#</th>
										<th>Product</th>
										<th>Qty</th>
										<th>Prix Unitaire</th>
										<th>Prix Total</th>
										<th id="thr"></th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">
						<!-- accepted payments column -->
						<div class="col-xs-4">
							<p class="lead">Note:</p>
							<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
								La marchandise vendu n'est ni echangee ni remise
							</p>
						</div>
						<!-- /.col -->
						<div class="col-xs-6">
							<div class="table-responsive">
								<table class="table">
									<tbody>
									<tr>
										<th>Total:</th>
										<td id="total"></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->

					<!-- this row will not appear when printing -->
					<div class="row no-print">
						<div class="col-xs-12" id="buttsub">
							<button class="btn btn-success pull-right rightSide" type="submit"><i class="fa fa-credit-card"></i> Enregistrer</button>
							<button class="btn btn-danger pull-right annuler" type="button">Annuler</button>
						</div>
					</div>
				</section>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 rightSide" >
		<div class="x_panel">
			<div class="x_title">
				<h2>Nouvel Item</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form id="addItemForm" >
					<div class="modal-body">
						<div class="form-group">
							<label>Nom du Produit</label>
							<input type="hidden" name="clientId" value="<?=$clients['id'];?>">
							<input type="hidden" name="invoiceId" id="invoiceId">
							<select class="select2" style="width: 100%" name="productId" id="productId">
								<option selected disabled>Product...</option>
								<?php
								foreach ($items as $item) {
									echo "<option value=" . $item['id'] . ">" . $item['name'].' [' .$item['title'].']'. "</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Quantite</label>
							<input class="form-control form-control-sm" type="text" name="quantity" required>
						</div>
						<div class="form-group">
							<label>Prix de Vente</label>
							<input id="prixdevente"class="form-control form-control-sm" type="text" name="prixVente" required>
						</div>
						<div class="col-xs-12 table">
							<table class="table table-striped" >
								<thead>
								<tr>
									<th>Disp.Qty</th>
									<th>Prix Unit</th>
									<th>Desc</th>
								</tr>
								</thead>
								<tbody id="display">
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="reset" class="btn btn-default">Annuler</button>
						<button type="submit" class="btn btn-primary">Ajouter</button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
<script src="<?= base_url(''); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script>
	$(function () {
		$("#invoiceId").val(localStorage.getItem("invoiceId"));
		var row = "";
		var total=0
		$(document).on('submit', '#addItemForm', function (event) {
			event.preventDefault();
			$.ajax({
				url: "<?php echo base_url('manipulate_items') ?>",
				method: 'POST',
				data: new FormData(this),
				contentType: false,
				processData: false,
				cache:false,
				async:false,
				success: function (data) {
					$(".avquantity").html(data.qtyd)
					$("#reportTable tbody").children().remove()
					row="";
					total=0;
					if(data.error){
						alert(data.error)
					}
					else if (data.invoice){
						$("#invId").text(data.invoice)
						localStorage.setItem("invoiceId",data.invoice)
						$("#invoiceId").val(data.invoice);
							$.each(data.records, function (index, obj) {
								total+=parseInt(obj.amount)
								row += "<tr>" +
										"<td>"+(index+1) + "</td>" +
										"<td>" + obj.produit +"-"+obj.title + "</td>" +
										"<td>" + obj.quantity + "</td>" +
										"<td>" + obj.unitPrice + "</td>" +
										"<td>" + obj.amount + "</td>" +
										"<td><i data-id="+obj.id+" class='removeItem fa fa-times-circle'></i><td>"+
									"</tr>";
							})
						$("#reportTable tbody").append(row);
						$("#total").text(total)
					}else{
						$.each(data.records, function (index, obj) {
							total+=parseInt(obj.amount)
							row += "<tr>" +
									"<td><input type='hidden' value='"+obj.id+"' name='recordId[]'>"+(index+1) + "</td>" +
									"<td><input type='hidden' value='"+obj.productId+"' name='productId[]'>" + obj.produit +"-"+obj.title + "</td>" +
									"<td><input type='hidden' value='"+obj.quantity+"' name='quantity[]'>" + obj.quantity + "</td>" +
									"<td><input type='hidden' value='"+obj.unitPrice+"' name='quantity[]'>" + obj.unitPrice + "</td>" +
									"<td>" + obj.amount + "</td>" +
									"<td><i data-id="+obj.id+" class='removeItem fa fa-times-circle'></i><td>"+
								"</tr>";
						})
						$("#reportTable tbody").append(row);
						$("#total").text(total)
					}

					$('#addItemForm')[0].reset();
				}
			});
		});
		//remove item
		$(document).on('click','.removeItem',function(){
			var id = $(this).data('id');
			var table=''
			$(this).closest('tr').remove();
			$.getJSON("<?=base_url('removeItemInvoice')?>/"+id,function(data){
				console.log(data.dispo);
				$(".avquantity").html(data.dispo);
				// $("#addItemForm [name='productId']").val(data.idp).prop({select:true}).trigger('change')
				done(data.success);
			})
		})
		//cancel invoice
		$(document).on("click",".annuler",function(){
			var id = localStorage.getItem("invoiceId");
			// alert(id);
			$.getJSON("<?=base_url('removeInvoice')?>/"+id,function(data){
				localStorage.removeItem("invoiceId")
				done(data.success)
				window.location.reload()
			})

		})
		//save invoice

		$(document).on('submit', '#saveInvoiceForm', function (event) {
			event.preventDefault();
			$.ajax({
				url: "<?php echo base_url('saveInvoice') ?>",
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
							localStorage.removeItem("invoiceId")
							done(data.success)
							$("#thr").hide()
							$(".removeItem").hide();
							$("#printButton").show();
							$('#buttsub').hide();
						}
					} catch (e) {
						alert("System error please try again later");
						console.log(e);
					}
				}
			})
		})
		$('select').on('change',function(){
			var table='';
			var qty='';
			var id= $('#productId option:selected').val();
			$.getJSON("<?= base_url();?>getSales/"+id,function(data){
					qty=data.quantity-data.usedQuantity;
					if(qty>=1){
							table +=  "<td class='avquantity bg bg-warning text-center'>"+qty+"</td>" +
								"<td class='bg bg-info text-center'>"+data.sellingPrice+"</td>" +
								"<td class='bg bg-warning text-center'>"+data.model+"</td>" ;
					}
					else{
						table +="<span class='bg bg-warning text-center'>Produit deja finis</span>";
					}
					$("#display").html(table);
					$("#prixdevente").val(data.sellingPrice);
			})
		})
	})
	function printData()
	{
		// $('#printButton').hide();
		$('#buttsub').hide();
		$(".removeItem").hide();
		document.getElementById("printButton").style.display = "none";
		var printContents = document.getElementById('printfacture').innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
		window.location.reload()
	}
	

	$('#printButton').on('click',function(){
		printData();
		$(".removeItem").hide();
		window.location.reload()

	})
	$("#printButton").hide();
</script>
