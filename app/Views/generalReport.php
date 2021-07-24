<!-- form input knob -->
<div class="col-md-12">
	<div class="x_panel">
		<div class="x_title">
			<h2><?=$title;?></h2>
			<div class="clearfix"></div>
		</div>
		<form id="getReportForm" action="<?=base_url('getGeneralReport');?>" method="POST">
		<div class="x_content">
			<div class="col-md-2">
				<div class="form-group">
					<label>Du</label>
					<input type="date" class="form-control" name="fromDate">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label>Au</label>
					<input type="date" class="form-control" name="untilDate">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<button type="submit" style="width: 100%;margin-top: 27px" class="btn btn-sm btn-success">Afficher</button>
				</div>
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-2">
			</div>
		</div>
		</form>
	</div>
</div>
<!-- /form input knob -->
<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Vakasukari</h2>
				<h2 class="pull-right">
					<div class="row no-print">
							<div class="col-xs-12">
								<button class="btn btn-default pull-right" id="printButton" onclick="printR(printReport);"><i class="fa fa-print"></i> Imprimer
								</button>
							</div>
						</div>
				</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form id="saveInvoiceForm">
					<section class="content invoice" id="printReport">
						<!-- title row -->
						<div class="row">
							<div class="col-xs-12 invoice-header">
								<h1>
									<i class="fa fa-globe"></i> Rapport.
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
						</div>
						<!-- /.row -->

						<!-- Table row -->
						<div class="row">
							<div class="col-xs-12 table">
								<table class="table table-striped" id="reportTable">
									<thead>
									<tr>
										<th>#</th>
										<th>Description</th>
										<th>Quantite</th>
										<th>Monatant Unitaire</th>
										<th>Montant Global</th>
										<th>Date</th>
										<th>Fait par</th>
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
							<div class="col-xs-6">

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
					</section>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url(''); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script>
	$(document).on('submit', '#getReportForm', function (event) {
		var row = "";
		var total=0
		event.preventDefault();
		$.ajax({
			url: "<?php echo base_url('getGeneralReport') ?>",
			method: 'POST',
			data: new FormData(this),
			contentType: false,
			processData: false,
			cache:false,
			async:false,
			success: function (data) {

				$.each(data, function (index, obj) {
					total+=parseInt(obj.amount)
					row += "<tr>" +
						"<td>"+(index+1) + "</td>" +
						"<td class='bg bg-info'>" + obj.product +" - "+obj.title+ "</td>" +
						"<td class='text-center bg bg-success'>" + obj.quantity +"</td>" +
						"<td class='text-center bg bg-warning'>" + obj.unitPrice + "</td>" +
						"<td class='text-center bg bg-primary'>" + obj.amount + "</td>" +
						"<td class='text-center bg bg-default'>" + obj.created_at + "</td>" +
						"<td class='text-center bg bg-danger'>" + obj.operator + "</td>" +
						"</tr>";
				})
				$("#reportTable tbody").html(row);
				$("#total").html(total)
			}
		})

	})
	function printR(printReport){
		document.getElementById("printButton").style.display = "none";
		var printContents = document.getElementById('printReport').innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;

	}
</script>
