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
