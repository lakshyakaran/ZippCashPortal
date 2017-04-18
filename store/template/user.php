<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">
          <div class="page-title">
              <div class="title_left">
                  <h3>User Details</h3>
              </div>
          </div>

          <div class="clearfix"></div>

					<?php
					$ticket_list = $lottery->get_ticket_list_by_user($apl->get_params()[0]);

					$total_amount_won = 0.00;
					$total_amount_paid = 0.00;
					$total_tickets_purchased = 0;

					if(count($ticket_list)){
						foreach ($ticket_list as $lottery){
							// print_r($lottery);
							foreach ($lottery['ticket_details'] as $ticket) {
								$total_tickets_purchased++;
								$total_amount_paid += $ticket->total_amount;
								if($ticket->win_amount != null){
									$total_amount_won += $ticket->win_amount;
								}
							}
						}
					}
					?>

					<div class="row tile_count">
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-user"></i> # Tickets Purchased</span>
										<div class="count" ><?php echo $total_tickets_purchased; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i> Total Amount Paid</span>
										<div class="count"><?php echo "$".$total_amount_paid; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i> Total Amount Win</span>
										<div class="count"><?php echo "$".$total_amount_won; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
					</div>
					<div class = "clearfix"></div>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>List of tickets played by user</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
												<div id = "user_ticket_container" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
																<div class="modal-content">

																		<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
																				</button>
																				<h4 class="modal-title">List of numbers and details</h4>
																		</div>
																		<div class="modal-body">
																		</div>
																		<div class="modal-footer">
																				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
																				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
																		</div>

																</div>
														</div>
												</div>

												<table id="lottery_user_table" class="table table-striped responsive-utilities jambo_table table-hover">
													<thead>
														<tr>
															<th>Lottery ID</th>
															<th>Lottery Name</th>
															<th># Tickets Purchased</th>
															<th>Paid amount</th>
															<th>Win amount</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php if(count($ticket_list)){ ?>
															<?php foreach ($ticket_list as $key => $ticket) { ?>
																<?php
																$amount_paid = 0.00;
																$amount_won = 0.00;
																foreach($ticket['ticket_details'] as $ticket_detail){
																	$amount_paid += $ticket_detail->total_amount;
																	if($ticket['lottery_details']->status == 'inactive'){
																		$amount_won += $ticket_detail->win_amount;
																	}
																}
																if($ticket['lottery_details']->status == 'active'){
																	$amount_won = "Not Declared";
																}else{
																	$amount_won = "$". $amount_won;
																}
																?>
																<?php if($key%2 == 0): ?>
																	<tr class="even pointer">
																<?php else: ?>
																	<tr class="even pointer">
																<?php endif; ?>
																	<td><?php echo $ticket['lottery_details']->lottery_id; ?></td>
																	<td><?php echo $ticket['lottery_details']->lottery_name; ?></td>
																	<td><?php echo count($ticket['ticket_details']); ?></td>
																	<td><?php echo $amount_paid; ?></td>
																	<td><?php echo $amount_won; ?></td>
																	<td>
																		<button type="button" lottery_id = "<?php echo $ticket['lottery_details']->lottery_id; ?>"  id = "<?php echo $apl->get_params()[0]; ?>" class="btn btn-primary ticket_user_details" data-toggle="modal" data-target=".bs-example-modal-lg">
																			View Detail
																		</button>
																	</td>
																	<?php if($key%2 == 0): ?>
																		</tr>
																	<?php else: ?>
																		</tr>
																	<?php endif; ?>
															<?php } ?>
														<?php } ?>
													</tbody>
												</table>
                      </div>
                  </div>
              </div>
              <div class = "clearfix"></div>
          </div>

				</div>
				<!-- /page content -->

		</div>
</div>
<!-- Datatables -->
<script src="<?php echo $apl->template_url; ?>js/datatables/js/jquery.dataTables.js"></script>
<script src="<?php echo $apl->template_url; ?>js/datatables/tools/js/dataTables.tableTools.js"></script>
<?php $apl->load_footer(); ?>
