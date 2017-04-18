<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php $lottery_details = $lottery->get_active_lottery(); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">

						<!-- top tiles -->
						<!-- <div class="row tile_count">
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
										<div class="left"></div>
										<div class="right">
												<span class="count_top"><i class="fa fa-user"></i> Total Users</span>
												<div class="count">2500</div>
												<span class="count_bottom"><i class="green">4% </i> From last Week</span>
										</div>
								</div>
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
										<div class="left"></div>
										<div class="right">
												<span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
												<div class="count">123.50</div>
												<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
										</div>
								</div>
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
										<div class="left"></div>
										<div class="right">
												<span class="count_top"><i class="fa fa-user"></i> Total Males</span>
												<div class="count green">2,500</div>
												<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
										</div>
								</div>
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
										<div class="left"></div>
										<div class="right">
												<span class="count_top"><i class="fa fa-user"></i> Total Females</span>
												<div class="count">4,567</div>
												<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
										</div>
								</div>
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
										<div class="left"></div>
										<div class="right">
												<span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
												<div class="count">2,315</div>
												<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
										</div>
								</div>
								<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
									<center>
										<button style = "margin-top:10%;" id = "make_payment_button" type="button" class="btn btn-success btn-lg">Make Payment</button>
									</center>
								</div>

						</div> -->
						<!-- /top tiles -->

						<div class = "row">
							<div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>Current Active Lottery</h2>
                          <div class="clearfix"></div>
                      </div>
											<div class="row">
												<div class="col-md-5 col-sm-12 col-xs-12">
													<div class="x_content">
														<?php if($lottery_details != null){ ?>
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
															<?php } ?>
														<?php } ?>
													</div>
												</div>
												<div class="col-md-7 col-sm-12 col-xs-12">
													<div class="x_content">
														<?php if($lottery_details != null){ ?>
															<input type = "hidden" id = "lottery_id" value = "<?php echo $lottery_details->lottery_id; ?>">
															<?php if($lottery_details->status == 'active'){ ?>
																<div class="bs-example" data-example-id="simple-jumbotron">
																	<div class="jumbotron">
																		<div id="preview_error_response">
																		</div>
																		<div id="lottery_numbers">
																			<div class="col-md-3 col-sm-12 col-xs-12">
																				<input type="text" class="form-control" id = "lottery_number_1" placeholder="No. #1">
																			</div>
																			<div class="col-md-3 col-sm-12 col-xs-12">
																				<input type="text" class="form-control" id = "lottery_number_2" placeholder="No. #2">
																			</div>
																			<div class="col-md-3 col-sm-12 col-xs-12">
																				<input type="text" class="form-control" id = "lottery_number_3" placeholder="No. #3">
																			</div>
																			<div class="col-md-3 col-sm-12 col-xs-12">
																				<center>
																					<button type="button" id = "preview_result" class="btn btn-success btn-sm">Preview Result</button>
																				</center>
																			</div>
																			<div class="clearfix"></div>
																			<br><br>
																		</div>

																		<div id="preview_result_response">
																		</div>
																		<div id = "generate_result_button_container" style = "display:none;">
																			<center>
																				<button id = "generate_result_button" type="button" class="btn btn-success btn-lg">Generate Result</button>
																			</center>
																		</div>
																	</div>
																</div>
															<?php } ?>
														<?php } ?>
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
