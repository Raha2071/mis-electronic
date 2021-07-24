
<div class="col-md-12 col-sm-12" id="printInvoice">
	<div class="x_panel">
		<div class="x_title">
			<h2>Invoices History</small></h2>
			<div class="clearfix"></div>
			<div class="x_content">
				<form>
					<section class="content invoice" id="PrintThis">
						<!-- title row -->
						<div class="row">
							<div class="col-xs-12 invoice-header">
								<h1>
									<i class="fa fa-globe"></i> Invoice.
									<small class="pull-right" style="font-size: 13px">Date: <?=date('d-m-Y h:i:s');?></small>
								</h1>
							</div>
							<!-- /.col -->
						</div>
						<!-- info row -->
						<div class="row invoice-info">
							<div class="col-sm-4 invoice-col">
								From
								<address>
									<strong>Electronics Shop</strong>
									<br>795 Freedom Ave, Suite 600
									<br>New York, CA 94107
									<br>Phone: 1 (804) 123-9876
									<br>Email: electronics@gmail.com
								</address>
							</div>
							<!-- /.col -->
							<div class="col-sm-4 invoice-col">
								To
								<address>
									<strong><?=$clients['name'];?></strong>
									<br>Phone: <?=$clients['phone'];?>
									<br>Email: <?=$clients['email'];?>
								</address>
							</div>
							<!-- /.col -->
							<div class="col-sm-4 invoice-col">
								<b>Invoice # <span id="invId"><?php echo $invoiceid;?></span> #</b>
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
										<th>U.price</th>
										<th>Subtotal</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$i=1;
									$total=0;
									foreach ($invoices as $invoice) {
										$total=$total + $invoice['amount'];
										?>
										<tr>
											<td><?= $i; ?></td>
											<td><?= $invoice['produit']; ?></td>
											<td><?= $invoice['quantity']; ?></td>
											<td><?= $invoice['price']; ?></td>
											<td><?= $invoice['amount']; ?></td>
										</tr>
										<?php
									$i++;
									}
									?>
									</tbody>
								</table>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
						<div class="row">
							<!-- accepted payments column -->
							<div class="col-xs-6">
								<p class="lead">Note:</p>
								<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
									The goods sold cannot be taken back or exchanged.
								</p>
							</div>
							<!-- /.col -->
							<div class="col-xs-6">
								<div class="table-responsive">
									<table class="table">
										<tbody>
										<tr>
											<th>Total: <?=$total;?></th>
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
							<div class="col-xs-12">
								<button class="btn btn-default" onclick="printData(PrintThis)" id="printButton"><i class="fa fa-print"></i> Print
								</button>
							</div>
						</div>
					</section>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	function printData(PrintThis)
	{
		document.getElementById("printButton").style.display = "none";
		var printContents = document.getElementById('printInvoice').innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
	}
</script>
