<div class="col-md-8 col-sm-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Archives</small></h2>
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
					<th>Fait par</th>
					<th>Date</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i=1;
				foreach ($histories as $history) {?>
					<tr>
						<td onclick="getData('test')">
							<?=$i;?>
						</td>
						<td><?=$history['operator'];?></td>
						<td><?=$history['created_at'];?></td>
						<td>
							<a href="<?= base_url('viewInvoiceHistory/'.$history['id'].'/'.$history['clientId']);?>">
								<button class="btn btn-sm btn-success"><span
											class="fa fa-pen"></span> Afficher
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

