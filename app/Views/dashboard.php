
<div class="row tile_count">
<?php if($_SESSION['shop_privilege']==0){ ?>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Total Users</span>
		<div class="count"><?=$clients['clients'];?></div>
		<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"> Total Users</i></i></span>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-clock-o"></i> Total Clients</span>
		<div class="count"><?=$employees['employees'];?></div>
		<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> Total Clients</i></span>
	</div>
	<!-- <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Total Branches</span>
		<div class="count green"></div>
		<span class="count_bottom"><i class="green"> <i class="fa fa-sort-desc"> Total Branches</i></i> </span>
	</div> -->
	<?php }?>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Total Products</span>
		<div class="count green"><?=$products['products'];?></div>
		<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Total Products </i></span>
	</div>
</div>
<!-- /top tiles -->

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="dashboard_graph">

			<!-- <div class="row x_title">
				<div class="col-md-6">
					<h3>Network Activities <small>Graph title sub-title</small></h3>
				</div>
				<div class="col-md-6">
					<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
						<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
					</div>
				</div>
			</div> -->
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div id="chart_plot_01" class="demo-placeholder"></div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12 bg-white">
				<div class="x_title">
					<h2>Near End Products</h2>
					<div class="clearfix"></div>
				</div>
				<table id="" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>
							               #
						             </th>
                          <th>Name</th>
                          <th>Remaining Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      foreach ($items as $item) {
						  $qty=$item['quantity'] - $item['usedQuantity'];
						  $name=$item['name'];
						   if($qty > 1 && $qty < 5)
						{
							echo "
							<tr>
                          <td>$i</td>
                          <td>$name</td>
						   <td>$qty</td>
                           
                        </tr>";
                         $i++;
                      }}
                        ?>
                    </tbody>
            	</table>

			</div>
		</div>
	</div>
</div>


