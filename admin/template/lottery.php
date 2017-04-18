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
                  <h3>Lottery Details</h3>
              </div>
          </div>

          <div class="clearfix"></div>

					<?php
					$lottery_details = $lottery->get_lottery_details($apl->get_params()[0]);
					$user_list = $lottery->get_users_by_lottery($apl->get_params()[0]);

					$total_amount_received = 0.00;
					$total_amount_paid = 0.00;
					$paid_text = false;

					if(count($user_list)){
						foreach ($user_list as $key => $user){
							$total_amount_received += $user->amount_paid;
							if($user->amount_win != null){
								$total_amount_paid += $user->amount_win;
							}
						}
					}
					if($lottery_details->status == 'active'){
						$paid_text = true;
						$total_amount_paid = "Result not declared";
					}else{
						$total_amount_paid = "$".$total_amount_paid;
					}
					$total_amount_received = "$".$total_amount_received;
					?>
					<div class="row tile_count">
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-user"></i> Total Users</span>
										<div class="count" ><?php echo count($user_list); ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i> Amount Received</span>
										<div class="count"><?php echo $total_amount_received; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i> Amount Paid</span>
										<?php if($paid_text){ ?>
											<div class="count_bottom" style = "font-size: 25px !important;"><?php echo $total_amount_paid; ?></div>
										<?php }else{ ?>
											<div class="count"><?php echo $total_amount_paid; ?></div>
										<?php } ?>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
					</div>
					<div class = "clearfix"></div>

          <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Lottery - <?php echo $lottery_details->lottery_name; ?></h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
												<input type = "hidden" id = "lottery_id" value = "<?php echo $lottery_details->lottery_id; ?>">
												<p><strong>Lottery ID: </strong><?php echo $lottery_details->lottery_id; ?></p>
												<p><strong>Creation Date: </strong><?php echo $lottery_details->created_on; ?></p>
												<p><strong>Draw Date: </strong><?php echo $lottery_details->lottery_date_time; ?></p>
												<p><strong>Lottery Status: </strong><?php echo ucfirst($lottery_details->status); ?></p>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Lottery Result</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
												<?php if($lottery_details->status == 'active' && $lottery_details->countdown_time > 0){ ?>
													<div class="bs-example" data-example-id="simple-jumbotron">
	                          <div class="jumbotron">
	                            <h4>
	                              <center>
																	<div id="counters"></div>
																	<script type="text/javascript">
																	var ts = (new Date()).getTime() + (<?php echo $lottery_details->countdown_time; ?>)*1000;
																	 $("#counters")
																	 .countdown(ts, function(event) {
																		 $(this).html(
																			 event.strftime('<span class="counters-outer"><span class="counter-inner">%D</span><span class="counters-text">Day</span></span><span class="counters-outer"><span class="counter-inner">%H</span><span class="counters-text">Hours</span></span><span class="counters-outer"><span class="counter-inner">%M</span><span class="counters-text">Minutes</span></span><span class="counters-outer"><span class="counter-inner">%S</span><span class="counters-text">Seconds</span></span>')
																		 );
																	 });
																	</script>
	                              </center>
	                            </h4>
	                          </div>
	                        </div>
												<?php }elseif($lottery_details->status == 'active' && $lottery_details->countdown_time < 1) { ?>
													<div class="bs-example" data-example-id="simple-jumbotron">
														<div class="jumbotron">
															<h4>
																<center>
																	Time ran out. Waiting for the result.
																	<br>
																	<br>
																	<button type="button" class="btn btn-success btn-lg">Generate Result</button>
																</center>
															</h4>
														</div>
													</div>
												<?php }elseif($lottery_details->status == 'inactive'){ ?>
													<p class = "title balls">
														<div style = "width:30%;float:left;margin-right:5%;">
															<span class = "ball"><?php echo $lottery_details->lottery_number_1; ?></span>
														</div>
														<div style = "width:30%;float:left;margin-right:5%;">
															<span class = "ball"><?php echo $lottery_details->lottery_number_2; ?></span>
														</div>
														<div style = "width:30%;float:left;">
															<span class = "ball"><?php echo $lottery_details->lottery_number_3; ?></span>
														</div>
													</p>
												<?php }; ?>
                      </div>
                  </div>
              </div>
              <div class = "clearfix"></div>
          </div>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Users who played this lottery</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
												<div id = "user_ticket_container" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
																<div class="modal-content">

																		<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
																				</button>
																				<h4 class="modal-title">List of tickets and numbers</h4>
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
															<th>User ID</th>
															<th>Name</th>
															<th># of tickets</th>
															<th>Paid amount</th>
															<th>Win amount</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php if(count($user_list)){ ?>
															<?php foreach ($user_list as $key => $user) { ?>
																<?php if($key%2 == 0): ?>
																	<tr class="even pointer">
																<?php else: ?>
																	<tr class="even pointer">
																<?php endif; ?>
																	<td><?php echo $user->user_id; ?></td>
																	<td><?php echo $user->user_details->first_name ."&nbsp;". $user->user_details->last_name; ?></td>
																	<td><?php echo count($user->tickets); ?></td>
																	<td><?php echo "$".$user->amount_paid; ?></td>
																	<td>
																		<?php
																		if(is_numeric($user->amount_win)){
																			echo "$".$user->amount_win;
																		}else{
																			echo "Not Declared";
																		}
																		?>
																	</td>
																	<td>
																		<button type="button" id = "<?php echo $user->user_id; ?>" class="btn btn-primary ticket_user_details" data-toggle="modal" data-target=".bs-example-modal-lg">
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
