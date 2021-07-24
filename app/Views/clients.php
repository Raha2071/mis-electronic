<div class="col-md-12 col-sm-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Clients</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li>
					<button class="btn-info btn btn-sm" data-toggle="modal" data-target="#clientModal"
							style="float: right"><i class="fa fa-plus"></i> Nouveau Client
					</button>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
				<thead>
				<tr>
					<th>#</th>
					<th>Noms</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Addresse</th>
					<th>Avenue</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i = 1;
				foreach ($clients as $client) {
					?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $client['name']; ?></td>
						<td><?= $client['phone']; ?></td>
						<td><?= $client['email']; ?></td>
						<td><?= $client['address']; ?></td>
						<td><?= $client['street']; ?></td>
						<td style="text-align: center">
							<button class="btn btn-sm btn-success" data-target="#clientModal" data-toggle="modal"
									data-id="<?= $client['id']; ?>"><span class="fa fa-pen"></span> Modifier
							</button>&nbsp;&nbsp;
							<a href="<?= base_url('invoicing/'.$client['id']);?>">
								<button class="btn btn-sm btn-info"><span
										class="fa fa-pen"></span> Vente
								</button>
							</a>
							<a href="<?= base_url('invoiceHistory/'.$client['id']);?>">
								<button class="btn btn-sm btn-default"><span
										class="fa fa-pen"></span> Factures
								</button>
							</a>

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


<script src="<?= base_url(''); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script>
	$(function () {
		//create client
		$(document).on('submit', '#clientForm', function (event) {
			event.preventDefault();
			$.ajax({
				url: "<?php echo base_url('manipulate_client') ?>",
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
							$('#clientForm')[0].reset();
							$('#clientModal').hide();
							window.location.reload();
						}
					} catch (e) {
						alert("System error please try again later");
						console.log(e);
					}
				}
			})
		})
		//get client's data
		$("#clientModal").on('show.bs.modal', function (e) {
			var id = $(e.relatedTarget).data("id");
			$.getJSON("<?=base_url();?>get_client/" + id, function (data) {
				// alert(data.id);
				$("#clientModal [name='client_Id']").val(data.id).change();
				$("#clientModal [name='name']").val(data.name).change();
				$("#clientModal [name='phone']").val(data.phone).change();
				$("#clientModal [name='email']").val(data.email).change();
				$("#clientModal [name='address']").val(data.address).change();
				$("#clientModal [name='street']").val(data.street).change();
				$("#clientModal [name='clientType']").val(data.client_type).trigger('change');
			});
			return;
		})
	})

</script>
<div class="modal fade" id="clientModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('manipulate_client'); ?>" id="clientForm" method="POST">
				<div class="modal-header">
					<h4 class="modal-title">Nouveau Client</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Noms</label>
						<input type="hidden" name="client_Id" id="client">
						<input class="form-control form-control-sm" type="text" placeholder="Names" name="name">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input class="form-control form-control-sm" type="number" placeholder="Phone number"
							   name="phone">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input class="form-control form-control-sm" type="email" placeholder="email@example.com"
							   name="email">
					</div>

					<div class="form-group">
						<label>Addresse</label>
						<input class="form-control form-control-sm" type="text" placeholder="Address" name="address">
					</div>
					<div class="form-group">
						<label>Avenue</label>
						<input class="form-control form-control-sm" type="text" placeholder="Street" name="street">
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Enregistrer</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

