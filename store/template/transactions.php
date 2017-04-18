<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
	<?php $apl->load_header(); ?>
	<?php $total_users = $user->get_active_user_count(); ?>
	<?php $total_stores = $user->get_active_store_count(); ?>
	<?php $recent_transactions = $user->get_transactions($user->current_user_id, 1); ?>
	<?php $account_details_result = $user->get_current_user_account_details(); ?>
	<?php $commission_transaction_details = $user->get_user_commission_details($user->current_user_id); ?>
	<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
			<!-- page content -->
			<div class="right_col" role="main">
				<div class = "row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Account Details</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<?php
								if($account_details_result['success'] == false){
									?>
									<div id = "error" style = "display: block;" class="alert alert-danger alert-dismissible fade in" role="alert">
										<?php echo $account_details_result['data']; ?>
									</div>
									<?php
								}else{
									$account_details = $account_details_result['data'];
									?>
									<div class="bs-example" data-example-id="simple-jumbotron">
										<div class = "form-horizontal">
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">User ID</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->login_id; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Wallet ID</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->wallet_id; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Name</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->store_name; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Available Balance</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->available_balance; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Commission Till Date:</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $commission_transaction_details['data']->total_commission; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Currency</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->currency; ?></p>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Commision Details</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<?php
								if($account_details_result['success'] == false){
									?>
									<div id = "error" style = "display: block;" class="alert alert-danger alert-dismissible fade in" role="alert">
										<?php echo $account_details_result['data']; ?>
									</div>
									<?php
								}else{
									$account_details = $account_details_result['data'];
									?>
									<div class="bs-example" data-example-id="simple-jumbotron">
										<div class = "form-horizontal">
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Commission Till Date:</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $commission_transaction_details['data']->total_commission; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Today's Commission:</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $commission_transaction_details['data']->commission_transaction[0]->commission; ?></p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Yesterday's Commission:</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $commission_transaction_details['data']->commission_transaction[1]->commission; ?></p>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-5 col-sm-5 col-xs-5" style = "text-align:left;">Currency</label>
												<div class="col-md-7 col-sm-7 col-xs-7">
													<p style = "padding-top:8px;"><?php echo $account_details->currency; ?></p>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class = "row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Recent Transactions</h2>
								<div class="clearfix"></div>
							</div>
							<div class="row">
								<div class="x_content">
									<div class="bs-example" data-example-id="simple-jumbotron">
										<?php
										if($account_details_result['success'] == true){
											?>
											<table id = "transaction_table" class="table table-striped responsive-utilities jambo_table">
												<thead>
													<tr>
														<th>Date & Time</th>
														<th>Transaction Summary</th>
														<th>Refrence Account ID</th>
														<th>Refrence Account Name</th>
														<th>Credit</th>
														<th>Debit</th>
														<th>New Balance</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($recent_transactions as $key => $value) { ?>
														<?php
														if($value->transaction_name == "deposit_transfer"){
															$summary = "Amount transferred to account against cash deposit.";
														}
														if($value->transaction_name == "cash_deposit"){
															$summary = "Cash deposit by user to be transffered to their account.";
														}
														if($value->transaction_name == "cash_withdraw"){
															$summary = "Cash withdrawn by the user.";
														}
														if($value->transaction_name == "withdraw_transfer"){
															$summary = "Amount transferred from account for withdrawl.";
														}
														if($value->transaction_name == "account_recharge"){
															$summary = "Amount debited for user account recharge.";
														}
														if($value->transaction_name == "commission_lottery_ticket"){
															$summary = "Commission earned for selling lottery ticket.";
														}
														if($value->transaction_name == "store_commission_wallet_recharge"){
															$summary = "Commission earned for recharging user account.";
														}
														if($value->refrence_account_id == 0){
															$name = "ZippCash";
															$value->refrence_account_id = "NA";
														}else{
															if($value->user_type == "individual"){
																$name = $value->first_name . "&nbsp;" . $value->last_name;
															}else{
																$name = $value->store_name;
															}
														}
														if($value->transaction_type == "credit"){
															$debit = "";
															$credit = $value->transaction_amount;
														}else{
															$credit = "";
															$debit = $value->transaction_amount;
														}
														?>
														<tr>
															<td><?php echo $value->transaction_date; ?></td>
															<td><?php echo $summary; ?></td>
															<td><?php echo $value->refrence_account_id; ?></td>
															<td><?php echo $name; ?></td>
															<td><?php echo $credit; ?></td>
															<td><?php echo $debit; ?></td>
															<td><?php echo $value->current_balance; ?></td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
												<?php
											}
											?>
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
		<script src="<?php echo $apl->template_url; ?>js/datatables/js/jquery.dataTables.js"></script>
		<script src="<?php echo $apl->template_url; ?>js/datatables/tools/js/dataTables.tableTools.js"></script>
		<?php $apl->load_footer(); ?>
