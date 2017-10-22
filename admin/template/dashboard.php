<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php $lottery_details = $lottery->get_active_lottery(); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<div class="right_col" role="main">

						<div class="row tile_count">
							<div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
								<center>
									<a style = "margin-top:10%;" href="index.php?options=add_credit" class="btn btn-success btn-lg">Add Credit</a>
								</center>
							</div>
							<div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
								<center>
									<a style = "margin-top:10%;" href="index.php?options=withdraw_credit" class="btn btn-success btn-lg">Withdraw Credit</a>
								</center>
							</div>
							<div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
								<center>
									<a style = "margin-top:10%;" href="index.php?options=add_new_agent" class="btn btn-success btn-lg">Add New Agent</a>
								</center>
							</div>
							<div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
								<center>
									<a style = "margin-top:10%;" href="index.php?options=add_new_user" class="btn btn-success btn-lg">Add New User</a>
								</center>
							</div>
							<div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
								<center>
									<a style = "margin-top:10%;" href="index.php?options=add_new_store" class="btn btn-success btn-lg">Add New Store</a>
								</center>
							</div>


						</div>

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

		</div>
</div>
<div id="custom_notifications" class="custom-notifications dsp_none">
		<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
		</ul>
		<div class="clearfix"></div>
		<div id="notif-group" class="tabbed_notifications"></div>
</div>
<?php $apl->load_footer(); ?>
