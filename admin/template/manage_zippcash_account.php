<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
	<?php $apl->load_header(); ?>
	<div class="container body">
		<div class="main_container">
			<?php
				$withdraw_zippcash_credit_success = null;
				$withdraw_zippcash_credit_error = null;
				if(isset($_POST['debit_amount'])){
					$withdraw_response = $user->withdrawZIppcashCredit();
					if($withdraw_response === 'success'){
						$withdraw_zippcash_credit_success = "Amount has been withdrawn successfully from Zippcash";
					}else{
						$withdraw_zippcash_credit_error = $withdraw_response;
					}
				}
				if(isset($_POST['credit_amount'])){
					$add_response = $user->addZIppcashCredit();
					if($add_response === 'success'){
						$success_message = "Amount has been addedd successfully to Zippcash";
					}else{
						$error_message = $add_response;
					}
				}
			?>
			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
			<!-- page content -->
			<div class="right_col" role="main">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<?php
							if($withdraw_zippcash_credit_error !== null){
								?>
								<div id = "withdraw_zippcash_credit_error" class="alert alert-danger fade in" role="alert">
								<?php echo $withdraw_zippcash_credit_error; ?>
								</div>
								<?php
							}
						?>
						<?php
							if($withdraw_zippcash_credit_success !== null){
								?>
								<div id = "withdraw_zippcash_credit_success" class="alert alert-success fade in" role="alert">
								<?php echo $withdraw_zippcash_credit_success; ?>
								</div>
								<?php
							}
						?>
						<div class="x_panel">
							<div class="x_title">
								<h2>Withdraw credit</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<form method="POST" id="withdraw_zippcash_credit_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
									<input type = "hidden" id = "user_type" value = "store">
									<div class="form-group">
										<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Withdrawing Amount <span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="debit_amount" class="form-control col-md-7 col-xs-12" type="text" name="debit_amount">
										</div>
									</div>
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button type="submit" id = "withdraw_zippcash_credit" class="btn btn-success">Withdraw</button>
											<div id = "processing" style="display:none;"><img src = "template/images/loader.gif"></div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Add Credit</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<form method="POST" id="add_zippcash_credit_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
									<div id = "add_zippcash_credit_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
									</div>
									<div id = "add_zippcash_credit_success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
									</div>
									<input type = "hidden" id = "user_type" value = "store">
									<div class="form-group">
										<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount to Deposit<span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="credit_amount" class="form-control col-md-7 col-xs-12" type="text" name="credit_amount">
										</div>
									</div>
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button type="submit" id = "add_zippcash_credit" class="btn btn-success">Add Amount</button>
											<div id = "processing" style="display:none;"><img src = "template/images/loader.gif"></div>
										</div>
									</div>
								</form>
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
	<?php $apl->load_footer(); ?>
