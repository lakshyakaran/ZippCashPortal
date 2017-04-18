<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php
$lottery_details = null;
if(isset($_GET['lottery_id'])) {
	if(is_numeric($_GET['lottery_id'])){
		if($_GET['lottery_id'] > 0){
			$lottery_details = $lottery->get_lottery_details($_GET['lottery_id']);
		}
	}
}
if($lottery_details == null){
	header("location:" . $apl->site_url . "/index.php?options=dashboard"); die();
}
?>
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
																	var time = moment.tz("<?php echo $lottery_details->lottery_date_time; ?>", "America/Sao_Paulo");
																	 $("#counters")
																	 .countdown(time.toDate(), function(event) {
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

				</div>
				<!-- /page content -->

		</div>
</div>
<!-- Datatables -->
<script src="<?php echo $apl->template_url; ?>js/datatables/js/jquery.dataTables.js"></script>
<script src="<?php echo $apl->template_url; ?>js/datatables/tools/js/dataTables.tableTools.js"></script>
<?php $apl->load_footer(); ?>
