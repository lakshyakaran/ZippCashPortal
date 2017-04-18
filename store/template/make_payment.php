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
                  <h3>Payment Details</h3>
              </div>
          </div>

          <div class="clearfix"></div>
          <?php
					$due_payment_list = $lottery->get_due_payment_list();
					$total_amount_received = 0.00;
					$total_amount_to_be_paid = 0.00;

					if(count($due_payment_list)){
						foreach ($due_payment_list as $user_object){
							$total_amount_received += $user_object->total_amount_paid_by_user;
							$total_amount_to_be_paid += $user_object->total_amount_to_be_paid;
						}
					}
					?>

					<div class="row tile_count">
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i>Amount Received</span>
										<div class="count" ><?php echo "$".$total_amount_received; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
						<div class="animated flipInY col-md-4 col-sm-4 col-xs-4 tile_stats_count">
								<div class="left"></div>
								<div class="right">
										<span class="count_top"><i class="fa fa-credit-card"></i>Amount Due</span>
										<div class="count"><?php echo "$".$total_amount_to_be_paid; ?></div>
										<!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
								</div>
						</div>
					</div>
					<div class = "clearfix"></div>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>List of users to be paid</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
												<div id = "make_user_payment_container" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
																<div class="modal-content">

																		<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
																				</button>
																				<h4 class="modal-title">Make payment now</h4>
																		</div>
																		<div class="modal-body">
																			<div id="make_payment_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
																				<div id = "payment_error_response"></div>
																			  <div class="form-group">
																			      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User ID: <span class="required">*</span>
																			      </label>
																			      <div class="col-md-6 col-sm-6 col-xs-12">
																			          <input type="text" id="form_user_id" disabled="true" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="7620"><ul class="parsley-errors-list" id="parsley-id-7620"></ul>
																			      </div>
																			  </div>
																			  <div class="form-group">
																			      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name: <span class="required">*</span>
																			      </label>
																			      <div class="col-md-6 col-sm-6 col-xs-12">
																			          <input type="text" id="form_name" disabled="true" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="7620"><ul class="parsley-errors-list" id="parsley-id-7620"></ul>
																			      </div>
																			  </div>
																			  <div class="form-group">
																			      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount to pay($): <span class="required">*</span>
																			      </label>
																			      <div class="col-md-6 col-sm-6 col-xs-12">
																			          <input type="text" id="form_amount_to_pay" disabled="true" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="7620"><ul class="parsley-errors-list" id="parsley-id-7620"></ul>
																			      </div>
																			  </div>
																			  <div class="form-group">
																			      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cheque ID: <span class="required">*</span>
																			      </label>
																			      <div class="col-md-6 col-sm-6 col-xs-12">
																			          <input type="text" id="form_cheque_id" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="7620"><ul class="parsley-errors-list" id="parsley-id-7620"></ul>
																			      </div>
																			  </div>
																			  <div class="ln_solid"></div>
																			  <div class="form-group">
																			      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
																			          <button type="submit" class="btn btn-primary" data-dismiss="modal">Cancel</button>
																			          <button type="submit" class="btn btn-success" id = "pay_now">Pay Now</button>
																			      </div>
																			  </div>
																			</div>
																		</div>
																</div>
														</div>
												</div>

												<table id="lottery_user_table" class="table table-striped responsive-utilities jambo_table table-hover">
													<thead>
														<tr>
															<th>User ID</th>
															<th>Name</th>
															<th># Tickets Purchased</th>
															<th>Paid amount</th>
															<th>Win amount</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php if(count($due_payment_list)){ ?>
															<?php foreach ($due_payment_list as $key => $user_object) { ?>
																<?php
																$amount_paid = 0.00;
																$amount_won = 0.00;
																?>
																<?php if($key%2 == 0): ?>
																	<tr class="even pointer">
																<?php else: ?>
																	<tr class="even pointer">
																<?php endif; ?>
																	<td><?php echo $user_object->user_id; ?></td>
																	<td><?php echo $user_object->first_name . "&nbsp;" . $user_object->last_name; ?></td>
																	<td><?php echo count($user_object->ticket_details); ?></td>
																	<td><?php echo "$".$user_object->total_amount_paid_by_user; ?></td>
																	<td><?php echo "$".$user_object->total_amount_to_be_paid; ?></td>
																	<td>
																		<button type="button" user_name = "<?php echo $user_object->first_name . "&nbsp;" . $user_object->last_name; ?>" total_amount = "<?php echo $user_object->total_amount_to_be_paid; ?>" id = "<?php echo $user_object->user_id; ?>" class="btn btn-primary make_user_payment" data-toggle="modal" data-target=".bs-example-modal-lg">
																			Make Payment
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
<div id="custom_notifications" class="custom-notifications dsp_none">
		<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
		</ul>
		<div class="clearfix"></div>
		<div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- Datatables -->
<script src="<?php echo $apl->template_url; ?>js/datatables/js/jquery.dataTables.js"></script>
<script src="<?php echo $apl->template_url; ?>js/datatables/tools/js/dataTables.tableTools.js"></script>
<?php $apl->load_footer(); ?>
