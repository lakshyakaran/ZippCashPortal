<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php $total_users = $user->get_active_user_count(); ?>
<?php $total_stores = $user->get_active_store_count(); ?>
<?php $recent_transactions = $user->get_transactions(0, 1); ?>
<?php
  if(isset($_GET['user_id'])){
    if($_GET['user_id'] == 0){
      $account_details = $user->get_zippcash_account_details();
    }else{
      $account_details = $user->get_account_details($_GET['user_id']);
    }
  }else{
    $account_details = $user->get_zippcash_account_details();
  }
?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">
          <div class = "row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Account Details</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                      <div class="x_content">
                        <div class="bs-example" data-example-id="simple-jumbotron">
                          <div class = "form-horizontal">
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">User ID</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo $account_details->login_id; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Wallet ID</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo $account_details->wallet_id; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Name</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo $account_details->name; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Money Belongs to ZippCash</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo $account_details->available_balance; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Money Belongs to User/Store</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo ($account_details->total_asset - $account_details->available_balance); ?></p>
                              </div>
                            </div>
                            <?php if(!isset($_GET['user_id'])){ ?>
                              <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Total Assets in Bank</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                  <p style = "padding-top:8px;"><?php echo $account_details->total_asset; ?></p>
                                </div>
                              </div>
                            <?php } ?>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-4" style = "text-align:left;">Currency</label>
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                <p style = "padding-top:8px;"><?php echo $account_details->currency; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
														<table id = "transaction_table" class="table table-striped responsive-utilities jambo_table">
															<thead>
																<tr>
																	<th>Date & Time</th>
																	<th>Transaction Summary</th>
																	<th>Refrence Account</th>
																	<th>Credit</th>
																	<th>Debit</th>
                                  <th>Old Balance</th>
																	<th>New Balance</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($recent_transactions as $key => $value) { ?>
																	<?php
                                  $summary = $value->transaction_name;
                                  if($value->transaction_name == "deposit_transfer"){
                                    $summary = "Amount transferred to user account against cash deposit.";
                                  }
                                  if($value->transaction_name == "cash_deposit"){
                                    $summary = "Cash deposit by user/store for their zippcash account.";
                                  }
                                  if($value->transaction_name == "cash_withdraw"){
                                    $summary = "Cash withdrawn by the user.";
                                  }
                                  if($value->transaction_name == "withdraw_transfer"){
                                    $summary = "Amount transferred from user account for withdrawl.";
                                  }

                                  if($value->transaction_name == "lottery_ticket_purchase"){
                                    $summary = "Amount received for sell of lottery ticket.";
                                  }
                                  if($value->transaction_name == "commission_lottery_ticket"){
                                    $summary = "Commission paid for selling lottery ticket.";
                                  }
                                  if($value->transaction_name == "zippcash_commission_wallet_recharge"){
                                    $summary = "Commission earned for user account recharge.";
                                  }
                                  if($value->transaction_name == "ticket_win_amount"){
                                    $summary = "Amount paid for ticket win.";
                                  }
                                  if($value->transaction_name == "bank_withdrawl"){
                                    $summary = "Amount withdrawn from bank.";
                                  }
                                  if($value->transaction_name == "bank_deposit"){
                                    $summary = "Amount deposit to bank.";
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
                                    if($value->transaction_name == "account_recharge"){
                                      $summary = "Amount received for user account recharge.";
                                    }
                                    if($value->transaction_name == "store_commission_wallet_recharge"){
                                      $summary = "Commission recived to be paid to store for user account recharge.";
                                    }
                                    $debit = "";
                                    $credit = $value->transaction_amount;
                                  }else{
                                    if($value->transaction_name == "account_recharge"){
                                      $summary = "Amount paid for user account recharge.";
                                    }
                                    if($value->transaction_name == "store_commission_wallet_recharge"){
                                      $summary = "Commission paid for user account recharge.";
                                    }
                                    $credit = "";
                                    $debit = $value->transaction_amount;
                                  }
																	?>
																	<tr>
																		<td><?php echo $value->transaction_date; ?></td>
																		<td><?php echo $summary; ?></td>
																		<td><?php echo $name; ?></td>
																		<td><?php echo $credit; ?></td>
																		<td><?php echo $debit; ?></td>
                                    <td><?php echo $value->previous_balance; ?></td>
																		<td><?php echo $value->current_balance; ?></td>
																	</tr>
																<?php } ?>  
															</tbody>
														</table>
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
