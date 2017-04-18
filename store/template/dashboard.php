<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php $lottery_details = $lottery->get_active_lottery(); ?>
<?php $last_lottery_details = $lottery->get_last_lottery(); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">

						<!-- top tiles -->
						<div class="row tile_count">
							<div class="animated flipInY col-md-6 col-sm-12 col-xs-12 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "add_new_user_button" type="button" class="btn btn-success btn-lg">Add New User</button>
								</center>
							</div>
							<div class="animated flipInY col-md-6 col-sm-12 col-xs-12 tile_stats_count">
								<center>
									<button style = "margin-top:10%;" id = "recharge_wallet_button" type="button" class="btn btn-success btn-lg">Recharge Wallet</button>
								</center>
							</div>
						</div>
						<!-- /top tiles -->

						<div class = "row">
							<div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Current Active Lottery</h2>
                          <div class="clearfix"></div>
                      </div>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="x_content">
														<?php if($lottery_details->status == 'active' && $lottery_details->countdown_time > 0){ ?>
															<div class="bs-example" data-example-id="simple-jumbotron">
																<div class="jumbotron">
																	<h4>
																		<center>
																			<div id="counters"></div>
																			<script type="text/javascript">
																			var time = moment.tz("<?php echo $lottery_details->lottery_date_time; ?>", "America/Sao_Paulo");
																			 $("#counters")
																			 .countdown(time.toDate(), function(event) {
																				 $(this).html(
																					 event.strftime('<span class="counters-outer"><span class="counter-inner">%D</span><span class="counters-text">Day</span></span><span class="counters-outer"><span class="counter-inner">%H</span><span class="counters-text">Hours</span></span><span class="counters-outer"><span class="counter-inner">%M</span><span class="counters-text">Minutes</span></span><span class="counters-outer"><span class="counter-inner">%S</span><span class="counters-text">Seconds</span></span>')
																				 );
																			 });
																			</script>
																			<div class = "clearfix"></div>
																			<br>
																			<br>
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
                  </div>
              </div>
							<div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Last Lottery</h2>
                          <div class="clearfix"></div>
                      </div>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="x_content">
														<?php if($last_lottery_details->status == 'active' && $last_lottery_details->countdown_time > 0){ ?>
															<div class="bs-example" data-example-id="simple-jumbotron">
																<div class="jumbotron">
																	<h4>
																		<center>
																			<div id="counters"></div>
																			<script type="text/javascript">
																			 $("#counters")
																			 .countdown("<?php echo $last_lottery_details->lottery_date_time; ?>", function(event) {
																				 $(this).html(
																					 event.strftime('<span class="counters-outer"><span class="counter-inner">%D</span><span class="counters-text">Day</span></span><span class="counters-outer"><span class="counter-inner">%H</span><span class="counters-text">Hours</span></span><span class="counters-outer"><span class="counter-inner">%M</span><span class="counters-text">Minutes</span></span><span class="counters-outer"><span class="counter-inner">%S</span><span class="counters-text">Seconds</span></span>')
																				 );
																			 });
																			</script>
																			<div class = "clearfix"></div>
																			<br>
																			<br>
																		</center>
																	</h4>
																</div>
															</div>
														<?php }elseif($last_lottery_details->status == 'active' && $last_lottery_details->countdown_time < 1) { ?>
															<div class="bs-example" data-example-id="simple-jumbotron">
																<div class="jumbotron">
																	<h4>
																		<center>
																			Time ran out. Waiting for the result.
																			<br>
																			<br>
																		</center>
																	</h4>
																</div>
															</div>
														<?php }elseif($last_lottery_details->status == 'inactive'){ ?>
															<p><strong>Lottery ID: </strong><?php echo $last_lottery_details->lottery_id; ?></p>
															<p><strong>Creation Date: </strong><?php echo $last_lottery_details->created_on; ?></p>
															<p><strong>Draw Date: </strong><?php echo $last_lottery_details->lottery_date_time; ?></p>
															<p><strong>Lottery Status: </strong><?php echo ucfirst($last_lottery_details->status); ?></p>
															<label class="control-label" style = "text-align:center;width:100%;">Lottery Result</label>
															<div class="divider-dashed"></div>
															<p class = "title balls">
																<div style = "width:30%;float:left;margin-right:5%;">
																	<span class = "ball"><?php echo $last_lottery_details->lottery_number_1; ?></span>
																</div>
																<div style = "width:30%;float:left;margin-right:5%;">
																	<span class = "ball"><?php echo $last_lottery_details->lottery_number_2; ?></span>
																</div>
																<div style = "width:30%;float:left;">
																	<span class = "ball"><?php echo $last_lottery_details->lottery_number_3; ?></span>
																</div>
															</p>
														<?php }; ?>
													</div>
												</div>
											</div>
                  </div>
              </div>
						</div>

						<div class = "row">
							<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="x_panel">
											<div class="x_title">
													<h2>Buy Lottery Tickets</h2>
													<div class="clearfix"></div>
											</div>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="x_content">
														<input type = "hidden" id = "lottery_id" value = "<?php echo $lottery_details->lottery_id; ?>">
														<?php if($lottery_details->status == 'active'){ ?>
															<div class="bs-example" data-example-id="simple-jumbotron">
																<div id = "error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
																</div>
																<div id = "success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
																</div>
																<div id="buy_ticket_response">
																</div>
																<div class = "form-horizontal">
																	<div class = "row">
																		<label class="control-label">User ID</label>
																		<div class="col-md-12 col-sm-12 col-xs-12">
																			<input type="text" id = "login_id" class="form-control" placeholder="User ID">
																		</div>
																	</div>
																	<div class = "row">
																		<label class="control-label">Ticket Details</label>
																		<div class="col-md-12 col-sm-12 col-xs-12">
																			<div class="divider-dashed"></div>
																			<div class = "row">
																				<div class="col-md-5 col-sm-5 col-xs-5">
																					<input type="text" name = "lottery_number[]" class="form-control" placeholder="Number">
																				</div>
																				<div class="col-md-5 col-sm-5 col-xs-5">
																					<input type="text" name = "lottery_number_amount[]" class="form-control" placeholder="Amount">
																				</div>
																				<div id = "additional_input"></div>
																				<div class="col-md-2 col-sm-2 col-xs-2">
																					<button class="form-control" id = "add_input">+</button>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class = "row">
																		<br>
																		<div class="col-md-12 col-sm-12 col-xs-12">
																			<span id = "buy_tickets" class="btn btn-primary" style = "width:100%;">Buy Tickets</span>
																			<div id = "processing" style="display:none;text-align:center;"><img src = "template/images/loader.gif"></div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
									</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Details</h2>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div id = "user_detail_processing" style = "display:none;width:100%;text-align:center;"><img src = "template/images/loader.gif"></div>
										<div id = "error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
										</div>
										<div id = "success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
										</div>
										<div id = "ajax_response"></div>
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
