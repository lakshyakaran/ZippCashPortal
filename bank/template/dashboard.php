<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php $total_users = $user->get_active_user_count(); ?>
<?php $total_stores = $user->get_active_store_count(); ?>
<?php $zippcash_acount = $user->get_zippcash_account_details(); ?>
<?php $recent_deposits = $user->get_recent_transaction(0, 'cash_deposit', 5); ?>
<?php $recent_withdrawls = $user->get_recent_transaction(0, 'cash_withdraw', 5); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">

						<!-- top tiles -->
						<div class="row tile_count">
							<div class="animated flipInY col-md-3 col-sm-4 col-xs-4 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "add_credit_button" type="button" class="btn btn-success btn-lg">Add Credit</button>
								</center>
							</div>
							<div class="animated flipInY col-md-3 col-sm-4 col-xs-4 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "withdraw_credit_button" type="button" class="btn btn-success btn-lg">Withdraw Credit</button>
								</center>
							</div>
							<div class="animated flipInY col-md-3 col-sm-4 col-xs-4 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "add_new_user_button" type="button" class="btn btn-success btn-lg">Add New User</button>
								</center>
							</div>
							<div class="animated flipInY col-md-3 col-sm-4 col-xs-4 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "add_new_store_button" type="button" class="btn btn-success btn-lg">Add New Store</button>
								</center>
							</div>


						</div>
						<!-- /top tiles -->

						<div class = "row">
							<div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Last 5 Deposits</h2>
                          <div class="clearfix"></div>
                      </div>
											<div class="row">
												<div class="x_content">
													<div class="bs-example" data-example-id="simple-jumbotron">
														<table class="table">
															<thead>
																<tr>
																	<th>Trans ID</th>
																	<th>Deposit By</th>
																	<th>Amount</th>
																	<th>Date Time</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($recent_deposits as $key => $value) { ?>
																	<?php
																	if($value->user_type == "individual"){
																		$name = $value->first_name . "&nbsp;" . $value->last_name;
																	}else{
																		$name = $value->store_name;
																	}
																	?>
																	<tr>
																		<th scope="row"><?php echo $value->transaction_id; ?></th>
																		<td><?php echo $name; ?></td>
																		<td><?php echo $value->transaction_amount; ?></td>
																		<td>@<?php echo $value->transaction_date; ?></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
                  </div>
              </div>

							<div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Last 5 Withdrawls</h2>
                          <div class="clearfix"></div>
                      </div>
											<div class="row">
												<div class="x_content">
													<div class="bs-example" data-example-id="simple-jumbotron">
														<table class="table">
															<thead>
																<tr>
																	<th>Trans ID</th>
																	<th>Withdrawn By</th>
																	<th>Amount</th>
																	<th>Date Time</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($recent_withdrawls as $key => $value) { ?>
																	<?php
																	if($value->user_type == "individual"){
																		$name = $value->first_name . "&nbsp;" . $value->last_name;
																	}else{
																		$name = $value->store_name;
																	}
																	?>
																	<tr>
																		<th scope="row"><?php echo $value->transaction_id; ?></th>
																		<td><?php echo $name; ?></td>
																		<td><?php echo $value->transaction_amount; ?></td>
																		<td>@<?php echo $value->transaction_date; ?></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</div>

												</div>
											</div>
                  </div>
              </div>
						</div>

				</div>
				<!-- /page content -->

		</div>
</div>
<div id="custom_notifications" class="custom-notifications dsp_none">
		<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
		</ul>
		<div class="clearfix"></div>
		<div id="notif-group" class="tabbed_notifications"></div>
</div>
<?php $apl->load_footer(); ?>
