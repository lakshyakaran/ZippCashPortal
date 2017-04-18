<?php

class lottery{

	function __construct(){

	}

	function get_lottery_list(){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from $apl->lottery_table order by lottery_id desc";
			$results = $db->get_results($query);

			if(count($results)){
				return $results;
			}
		}

		return null;
	}

	function get_lottery_details($lottery_id){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from $apl->lottery_table as lt, $apl->lottery_result_table as lrt where lt.lottery_id = '".$lottery_id."' and lt.lottery_id = lrt.lottery_id";
			$results = $db->get_results($query);

			if(count($results)){
				$lottery_details = $results[0];
				$lottery_date_time = new DateTime($lottery_details->lottery_date_time);
				$current_date_time = new DateTime(date('Y-m-d H:i:s'));
				$lottery_details->countdown_time = $lottery_date_time->getTimestamp() - $current_date_time->getTimestamp();
				return $lottery_details;
			}
		}
		return null;
	}

	function get_ticket_list_by_lottery($lottery_id){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from ".$apl->user_ticket_table." where lottery_id = '".$lottery_id."' and payment_status = 'paid'";
			$results = $db->get_results($query);
			if(count($results)){
				return $results;
			}
		}

		return null;
	}

	function get_user_ticket_list_by_lottery($user_id, $lottery_id){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from ".$apl->user_ticket_table." where lottery_id = '".$lottery_id."' and user_id = '".$user_id."' and payment_status = 'paid'";
			$results = $db->get_results($query);
			$tickets = array();
			if(count($results)){
				foreach ($results as $key => $result) {
					$tickets[$key] = $result;
					$tickets[$key]->ticket_numbers = $this->get_ticket_numbers_by_ticket_id($result->ticket_id);
				}
				return $tickets;
			}
		}

		return null;
	}

	function get_users_by_lottery($lottery_id){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select user_id from ".$apl->user_ticket_table." where lottery_id = '".$lottery_id."' and payment_status = 'paid' group by user_id";
			$results = $db->get_results($query);
			$user_list = array();
			if(count($results)){
				foreach($results as $key => $result){
					$user_list[$key] = $result;
					$user_list[$key]->user_details = $user->get_user_data($result->user_id);
					$user_list[$key]->tickets = $this->get_user_ticket_list_by_lottery($result->user_id, $lottery_id);
					$ticket_amount_paid = 0;
					$ticket_amount_win = 0;
					foreach($user_list[$key]->tickets as $tkt_key => $ticket){
						$ticket_amount_paid += $ticket->total_amount;
						if($ticket->win_amount != null){
							$ticket_amount_win += $ticket->win_amount;
						}else{
							$ticket_amount_win = null;
						}
					}
					$user_list[$key]->amount_paid = $ticket_amount_paid;
					$user_list[$key]->amount_win = $ticket_amount_win;
				}
				return $user_list;
			}
		}

		return null;
	}

	function get_ticket_list_by_user($user_id){
		global $apl;
		global $db;

		$ticket_list = array();
		$query = "select lottery_id from $apl->user_ticket_table where user_id = '".$user_id."' and payment_status = 'paid' group by lottery_id";
		$results = $db->get_results($query);

		if(count($results)){
			foreach ($results as $key => $result) {
				$lottery_id = $result->lottery_id;
				$ticket_list[$key]['lottery_details'] = $this->get_lottery_details($lottery_id);
				$ticket_list[$key]['ticket_details'] = $this->get_user_ticket_list_by_lottery($user_id, $lottery_id);
			}
			return $ticket_list;
		}

		return null;

	}

	function get_active_lottery(){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from $apl->lottery_table where status != 'inactive' order by lottery_id desc limit 1";
			$results = $db->get_results($query);

			if(count($results)){
				$lottery_details = $results[0];
				$lottery_date_time = new DateTime($lottery_details->lottery_date_time);
				$current_date_time = new DateTime(date('Y-m-d H:i:s'));
				$lottery_details->countdown_time = $lottery_date_time->getTimestamp() - $current_date_time->getTimestamp();

				return $lottery_details;
			}
		}

		return null;
	}

	function get_last_lottery(){
		global $apl;
		global $db;
		global $user;

		if($user->is_logged_in()){
			$query = "select * from $apl->lottery_table where status = 'inactive' order by lottery_id desc limit 1";
			$results = $db->get_results($query);

			if(count($results)){
				$lottery_details = $this->get_lottery_details($results[0]->lottery_id);
				$lottery_date_time = new DateTime($lottery_details->lottery_date_time);
				$current_date_time = new DateTime(date('Y-m-d H:i:s'));
				$lottery_details->countdown_time = $lottery_date_time->getTimestamp() - $current_date_time->getTimestamp();

				return $lottery_details;
			}
		}

		return null;
	}

	function get_ticket_numbers_by_ticket_id($ticket_id){
		global $apl;
		global $db;
		global $user;

		$return_data = new stdClass();

		if($user->is_logged_in()){
			$query = "select * from $apl->user_ticket_table as utt, $apl->user_table as ut where utt.ticket_id = '".$ticket_id."' and utt.user_id = ut.user_id";
			$result = $db->get_results($query);

			if(count($result)){
				$return_data->ticket_details = $result[0];
				$query = "select * from ".$apl->ticket_details_table." where ticket_id = '".$ticket_id."'";
				$results = $db->get_results($query);
				if(count($results)){
					$return_data->ticket_numbers = $results;
					return $return_data;
				}
			}
		}

		return false;
	}

	function get_due_payment_list(){
		global $db;
		global $apl;
		global $user;

		if($user->is_logged_in()){
			$query = "select user_id from $apl->user_ticket_table where payment_status = 'paid' and payment_sent_status != 'paid' group by user_id";
			$user_list = $db->get_results($query);

			$due_payment_list = array();

			if(count($user_list)){
				foreach ($user_list as $key => $user_object) {
					$user_details = $user->get_user_data($user_object->user_id);
					$user_tickets = $this->get_ticket_list_by_user($user_object->user_id);
					$due_payment_list[$key] = $user_details;
					$total_amount_paid_by_user = 0.00;
					$total_amount_to_be_paid = 0.00;
					foreach ($user_tickets as $ticket_list) {
						foreach($ticket_list['ticket_details'] as $ticket){
							if($ticket->payment_sent_status == null && $ticket->win_amount != null){
								$total_amount_paid_by_user += $ticket->total_amount;
								$total_amount_to_be_paid += $ticket->win_amount;
								$due_payment_list[$key]->ticket_details = $ticket;
							}
						}
					}
					$due_payment_list[$key]->total_amount_paid_by_user = $total_amount_paid_by_user;
					$due_payment_list[$key]->total_amount_to_be_paid = $total_amount_to_be_paid;
				}

				return $due_payment_list;
			}
		}

		return null;
	}

	function addTicketDetails(){
		global $apl;
		global $db;
		global $user;

		$output['success'] = false;
		$user_ticket = array();

		if($user->is_logged_in()){
			$current_user_id = $user->current_user_id;
			$current_user_details = $user->get_current_user_account_details();
			if($current_user_details['success'] == true){
				$user_id = $user->get_user_id_from_login_id($_POST['login_id']);
				if($user_id != false){
					$user_ticket['user_id'] = $user_id;
					$user_ticket['lottery_id'] = $_POST['lottery_id'];
					$user_ticket['purchased_on'] = date('Y-m-d H:i:s');
					$user_ticket['total_amount'] = 0;

					$lottery_details = $this->get_lottery_details($_POST['lottery_id']);
					if($lottery_details != null){
						if($lottery_details->countdown_time > 10){
							$user_details = $user->get_user_account_details($user_ticket['user_id']);

							foreach($_POST['tickets'] as $key => $ticket){
								$user_ticket['total_amount'] += $ticket['amount'];
							}
							if($user_details['success'] == true){
								if($user_ticket['total_amount'] > 0){
									if($user_ticket['total_amount'] <= $user_details['data']->available_balance){
										//Update transction for ticket purchase
										$user->make_transaction($user_ticket['user_id'], 0, 'debit', 'lottery_ticket_purchase', $user_ticket['total_amount']);
										$user->make_transaction(0, $user_ticket['user_id'], 'credit', 'lottery_ticket_purchase', $user_ticket['total_amount']);

										// Update transaction for commission received
										$commission_amount = ( 0.12 * $user_ticket['total_amount'] );
										$commission_amount = round($commission_amount, 2);

										$user->make_transaction(0, $current_user_id, 'debit', 'commission_lottery_ticket', $commission_amount);
										$user->make_transaction($current_user_id, 0, 'credit', 'commission_lottery_ticket', $commission_amount);

										$user_ticket['payment_status'] = 'paid';
										$db->insert($apl->user_ticket_table, $user_ticket);
										$ticket_id = $db->insert_id;
										if($ticket_id != null){
											$output['success'] = true;
											$output['data'] = new stdClass();
											$output['data']->ticket_id = $ticket_id;
											$output['data']->user_id = $user_ticket['user_id'];
											$output['data']->total_amount = $user_ticket['total_amount'];
											foreach($_POST['tickets'] as $key => $ticket){
												$ticket_details = array();
												$ticket_details['user_id'] = $user_ticket['user_id'];
												$ticket_details['ticket_id'] = $ticket_id;
												$ticket_details['ticket_number'] = $ticket['number'];
												$ticket_details['ticket_amount'] = $ticket['amount'];

												$db->insert($apl->ticket_details_table, $ticket_details);
											}
										}else{
											$message = "Unable to add ticket to database";
										}
									}else {
										$message = "Insufficient funds to purchase ticket";
									}
								}else{
									$message = "Invalid amount";
								}
							}else{
								$message = "Invalid User";
							}
						}else {
							$message = "Time ran out. Please wait for the next lottery.";
						}
					}else {
						$message = "Time ran out. Please wait for the next lottery.";
					}
				}else{
					$message = "The user with given login ID was not found. " . $_POST['login_id'];
				}
			}else{
				$message = $current_user_details['data'];
			}
		}else{
			$message = "You are not logged In";
		}

		if(!$output['success']){
			$output['data'] = $message;
		}

		echo json_encode($output);
		die;

	}

	function previewLotteryResult(){
		global $apl;
		global $db;
		global $user;

		$output['success'] = false;
		$output['data'] = '';
		$error_message = array();
		$preview_lottery_result = array();
		$total_amount_to_pay = 0;
		$total_amount_received = 0;
		$preview_lottery_result['lottery_number_1'] = new stdClass();
		$preview_lottery_result['lottery_number_2'] = new stdClass();
		$preview_lottery_result['lottery_number_3'] = new stdClass();

		if($user->is_logged_in()){
			$lottery_id = $_POST['lottery_id'];
			$lottery_details = $this->get_lottery_details($lottery_id);
			if(count($lottery_details)){
				if($lottery_details->status == "active"){
					$lottery_number_1 = $_POST['lottery_number_1'];
					$lottery_number_2 = $_POST['lottery_number_2'];
					$lottery_number_3 = $_POST['lottery_number_3'];
					if($lottery_number_1 != null && $lottery_number_2 != null && $lottery_number_3 != null){
						if(($lottery_number_1 !== $lottery_number_2) && ($lottery_number_1 != $lottery_number_3) && ($lottery_number_2 != $lottery_number_3)){
							if($lottery_number_1 >= 0 && $lottery_number_1 < 100 && $lottery_number_2 >= 0 && $lottery_number_2 < 100 && $lottery_number_3 >= 0 && $lottery_number_3 < 100){
								$user_tickets = $this->get_ticket_list_by_lottery($lottery_id);
								if(count($user_tickets)){
									foreach($user_tickets as $user_ticket){
										$total_amount_received += $user_ticket->total_amount;
									}
								}
								$query = "select ticket_number, ticket_amount from $apl->user_ticket_table as utt, $apl->ticket_details_table as tdt where utt.ticket_id = tdt.ticket_id and tdt.ticket_number = '".$lottery_number_1."' and utt.lottery_id = '".$lottery_id."'";
								$results = $db->get_results($query);
								$amount_to_pay = 0;
								$preview_lottery_result['lottery_number_1']->matched_number = count($results);
								if(count($results)){
									foreach ($results as $key => $result) {
										$amount_to_pay += ($result->ticket_amount * 60);
									}
								}
								$preview_lottery_result['lottery_number_1']->amount_to_pay = $amount_to_pay;
								$total_amount_to_pay += $amount_to_pay;

								$query = "select ticket_number, ticket_amount from $apl->user_ticket_table as utt, $apl->ticket_details_table as tdt where utt.ticket_id = tdt.ticket_id and tdt.ticket_number = '".$lottery_number_2."' and utt.lottery_id = '".$lottery_id."'";
								$results = $db->get_results($query);
								$amount_to_pay = 0;
								$preview_lottery_result['lottery_number_2']->matched_number = count($results);
								if(count($results)){
									foreach ($results as $key => $result) {
										$amount_to_pay += ($result->ticket_amount * 20);
									}
								}
								$preview_lottery_result['lottery_number_2']->amount_to_pay = $amount_to_pay;
								$total_amount_to_pay += $amount_to_pay;

								$query = "select ticket_number, ticket_amount from $apl->user_ticket_table as utt, $apl->ticket_details_table as tdt where utt.ticket_id = tdt.ticket_id and tdt.ticket_number = '".$lottery_number_3."' and utt.lottery_id = '".$lottery_id."'";
								$results = $db->get_results($query);
								$amount_to_pay = 0;
								$preview_lottery_result['lottery_number_3']->matched_number = count($results);
								if(count($results)){
									foreach ($results as $key => $result) {
										$amount_to_pay += ($result->ticket_amount * 10);
									}
								}
								$preview_lottery_result['lottery_number_3']->amount_to_pay = $amount_to_pay;
								$total_amount_to_pay += $amount_to_pay;

								$preview_lottery_result['total_amount_to_pay'] = $total_amount_to_pay;
								$preview_lottery_result['total_amount_received'] = $total_amount_received;
								$output['success'] = true;
							}else {
								$error_message[] = "One of the specified winning number is not valid";
							}
						}else{
							$error_message[] = "Two of the specified winning number cannot be same";
						}
					}else{
						$error_message[] = "Any of the specified winning number cannot be blank";
					}
				}else{
					$error_message[] = "The result for this lottery is already generated.";
				}
			}else{
				$error_message[] = "Specified lottery not found.";
			}
		}else{
			$error_message[] = "You are not authorized to generate results.";
		}
		if($output['success']){
			$output['data'] .=
			'<div class = "row">'.
				'<div class="table-responsive">'.
					'<table class="table">'.
						'<tbody>'.
							'<tr>'.
								'<th style="width:50%">Total Amount Received:</th>'.
								'<td> $'.$preview_lottery_result["total_amount_received"].'</td>'.
							'</tr>'.
							'<tr>'.
								'<th style="width:50%">Total Amount To Pay:</th>'.
								'<td> $'.$preview_lottery_result["total_amount_to_pay"].'</td>'.
							'</tr>'.
						'</tbody>'.
					'</table>'.
				'</div>'.
			'</div>';

			$output['data'] .=
			'<div class = "row">'.
				'<table class="table table-bordered">'.
					'<thead>'.
						'<tr>'.
							'<th>Lottery Number:</th>'.
							'<th>Total Matched Number:</th>'.
							'<th>Amount To Pay:</th>'.
						'</tr>'.
					'</thead>'.
					'<tbody>'.
						'<tr>'.
							'<td>'.$lottery_number_1.'</td>'.
							'<td> '.$preview_lottery_result["lottery_number_1"]->matched_number.'</td>'.
							'<td> $'.$preview_lottery_result["lottery_number_1"]->amount_to_pay.'</td>'.
						'</tr>'.
						'<tr>'.
							'<td>'.$lottery_number_2.'</td>'.
							'<td> '.$preview_lottery_result["lottery_number_2"]->matched_number.'</td>'.
							'<td> $'.$preview_lottery_result["lottery_number_2"]->amount_to_pay.'</td>'.
						'</tr>'.
						'<tr>'.
							'<td>'.$lottery_number_3.'</td>'.
							'<td> '.$preview_lottery_result["lottery_number_3"]->matched_number.'</td>'.
							'<td> $'.$preview_lottery_result["lottery_number_3"]->amount_to_pay.'</td>'.
						'</tr>'.
						'<tr>'.
							'<td></td>'.
							'<td> <strong>Total</strong></td>'.
							'<td> <strong>$'.($preview_lottery_result["lottery_number_1"]->amount_to_pay + $preview_lottery_result["lottery_number_2"]->amount_to_pay + $preview_lottery_result["lottery_number_3"]->amount_to_pay).'</strong></td>'.
						'</tr>'.
					'</tbody>'.
				'</table>'.
			'</div>';
		}else{
			$output['data'] .=
			'<div class="alert alert-danger alert-dismissible fade in" role="alert">'.
			  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
			  '</button>'.
			  '<strong>Error!</strong>'.$error_message[0].''.
			'</div>';
		}

		$output['error'] = $error_message;
		echo json_encode($output);
		die;
	}

	function generateLotteryResult(){
		global $apl;
		global $db;
		global $user;

		$error_message = array();
		$output['success'] = false;
		if($user->is_logged_in()){
			$lottery_id = $_POST['lottery_id'];
			$lottery_details = $this->get_lottery_details($lottery_id);
			if(count($lottery_details)){
				if($lottery_details->status == "active"){
					if($lottery_details->countdown_time < 10){
						$lottery_number_1 = $_POST['lottery_number_1'];
						$lottery_number_2 = $_POST['lottery_number_2'];
						$lottery_number_3 = $_POST['lottery_number_3'];
						if($lottery_number_1 != null && $lottery_number_2 != null && $lottery_number_3 != null){
							if(($lottery_number_1 !== $lottery_number_2) && ($lottery_number_1 != $lottery_number_3) && ($lottery_number_2 != $lottery_number_3)){
								if($lottery_number_1 >= 0 && $lottery_number_1 < 100 && $lottery_number_2 >= 0 && $lottery_number_2 < 100 && $lottery_number_3 >= 0 && $lottery_number_3 < 100){
									$amount_paid = 0;
									$amount_received = 0;
									$user_tickets = $this->get_ticket_list_by_lottery($lottery_id);
									if(count($user_tickets)){
										foreach($user_tickets as $user_ticket){
											$amount_received += $user_ticket->total_amount;
											$ticket_win_amount = 0;
											if($user_ticket->win_amount == null){
												$ticket_details = $this->get_ticket_numbers_by_ticket_id($user_ticket->ticket_id);
												if(count($ticket_details)){
													foreach ($ticket_details as $key => $ticket_detail) {
														if($ticket_detail->win_amount == null){
															if($ticket_detail->ticket_number == $lottery_number_1){
																$win_amount = $ticket_detail->ticket_amount * 60;
															}elseif ($ticket_detail->ticket_number == $lottery_number_2) {
																$win_amount = $ticket_detail->ticket_amount * 20;
															}elseif ($ticket_detail->ticket_number == $lottery_number_3) {
																$win_amount = $ticket_detail->ticket_amount * 10;
															}else {
																$win_amount = 0.00;
															}
															$ticket_win_amount += $win_amount;
															$ticket_detail_update_data = array(
																'win_amount' => $win_amount
															);
															$condition = array(
																'ticket_detail_id' => $ticket_detail->ticket_detail_id
															);
															$db->update($apl->ticket_details_table, $ticket_detail_update_data, $condition);
															unset($ticket_detail_update_data);
															unset($condition);
														}
													}
												}
											}
											$amount_paid += $ticket_win_amount;
											$ticket_update_data = array(
												'win_amount' => $ticket_win_amount
											);
											$condition = array(
												'ticket_id' => $user_ticket->ticket_id
											);
											$db->update($apl->user_ticket_table, $ticket_update_data, $condition);
											unset($ticket_update_data);
											unset($condition);
										}
									}
									$update_data = array(
										'published_on' => date('Y-m-d H:i:s'),
										'lottery_number_1' => $lottery_number_1,
										'lottery_number_2' => $lottery_number_2,
										'lottery_number_3' => $lottery_number_3,
										'amount_received'	 => $amount_received,
										'amount_paid'			 => $amount_paid
									);

									$condition = array(
										'lottery_id' => $lottery_id
									);
									$db->update($apl->lottery_result_table, $update_data, $condition);

									$lottery_update_data = array(
										'status' => 'inactive'
									);
									$db->update($apl->lottery_table, $lottery_update_data, $condition);
									$output['success'] = true;
									$output['data'] = $update_data;
								}else{
									$error_message[] = "One of the specified winning number is not valid";
								}
							}else{
								$error_message[] = "Two of the specified winning number cannot be same";
							}
						}else{
							$error_message[] = "Any of the specified winning number cannot be blank";
						}
					}else{
						$error_message[] = "The result for this lottery cannnot be generated. The lottery is still running. The countdown time is : " .$lottery_details->countdown_time;
					}
				}else{
					$error_message[] = "The result for this lottery is already generated.";
				}
			}else{
				$error_message[] = "Specified lottery not found.";
			}
		}else{
			$error_message[] = "You are not authorized to generate results.";
		}

		if(!$output['success']){
			$output['data'] =
			'<div class="alert alert-danger alert-dismissible fade in" role="alert">'.
			  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
			  '</button>'.
			  '<strong>Error!</strong>'.$error_message[0].''.
			'</div>';
		}

		echo json_encode($output);
		die;
	}

	function getUserTicketsByLottery(){
		$user_id = $_POST['user_id'];
		$lottery_id = $_POST['lottery_id'];

		$user_tickets = $this->get_user_ticket_list_by_lottery($user_id, $lottery_id);
		$output['data'] = '<div class="accordion" id="accordion" role="tablist" aria-multiselectable="false">';
		foreach($user_tickets as $key => $ticket){
			if($key == 0){
				$class = "in";
				$expanded = true;
			}else{
				$class = '';
				$expanded = false;
			}
			$output['data'] .=
			'<div class="panel">'.
			  '<a class="panel-heading" role="tab" id="heading'.$key.'" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$key.'" aria-expanded="'.$expanded.'" aria-controls="collapse'.$key.'">'.
			    '<h5><strong>Ticket ID:</strong> TKT-'.$ticket->ticket_id.'</h5>'.
			  '</a>'.
			  '<div id="collapse'.$key.'" class="panel-collapse collapse '.$class.'" role="tabpanel" aria-labelledby="heading'.$key.'">'.
			    '<div class="panel-body">'.
			    '<table class="table table-bordered">'.
			      '<thead>'.
			        '<tr>'.
							'<th>Ticket ID</th>'.
							'<th>Number</th>'.
							'<th>Paid Amount</th>'.
							'<th>Win Amount</th>'.
							'<th>User Paid</th>'.
			        '</tr>'.
			      '</thead>'.
			      '<tbody>';
						foreach ($ticket->ticket_numbers as $number_key => $ticket_number) {
							if($ticket_number->win_amount == null){
								$win_amount = "Not Declared";
							}else{
								$win_amount = $ticket_number->win_amount;
							}
							if($ticket->payment_sent_status == null){
								$user_paid = "No";
							}else{
								$user_paid = "Yes";
							}
							$output['data'] .=
							'<tr>'.
							'<td>'.$ticket_number->ticket_id.'</td>'.
							'<td>'.$ticket_number->ticket_number.'</td>'.
							'<td>$'.$ticket_number->ticket_amount.'</td>'.
							'<td>'.$win_amount.'</td>'.
							'<td>'.$user_paid.'</td>'.
							'</tr>';
						}
						$output['data'] .=
			      '</tbody>'.
			    '</table>'.
			    '</div>'.
			  '</div>'.
			'</div>';
		};

		$output['data'] .= '<div>';
		$output['success'] = true;

		echo json_encode($output);
		die;
	}

	function makePayment(){
		global $db;
		global $apl;
		global $user;

		$output['success'] = false;
		$error_message = array();
		$error = false;

		if($user->is_logged_in()){
			$user_id = $_POST['user_id'];
			$amount_to_pay = $_POST['amount_to_pay'];
			$cheque_id = $_POST['cheque_id'];

			if($user_id == null){
				$error = true;
				$error_message[] = "User ID is not specified";
			}
			if($amount_to_pay == null){
				$error = true;
				$error_message[] = "Amount to pay is not specified";
			}
			if($amount_to_pay < 0){
				$error = true;
				$error_message[] = "Specified amount is negative";
			}
			if($cheque_id == null){
				$error = true;
				$error_message[] = "Cheque number is not specified";
			}

			if(!$error){
				$user_tickets = $this->get_ticket_list_by_user($user_id);

				$total_amount_paid_by_user = 0.00;
				$total_amount_to_be_paid = 0.00;

				if(count($user_tickets)){
					foreach ($user_tickets as $ticket_list) {
						foreach($ticket_list['ticket_details'] as $ticket){
							if($ticket->payment_sent_status == null && $ticket->win_amount != null){
								$total_amount_to_be_paid += $ticket->win_amount;
							}
						}
					}
					if($total_amount_to_be_paid == $amount_to_pay){
						foreach ($user_tickets as $ticket_list) {
							foreach($ticket_list['ticket_details'] as $ticket){
								if($ticket->payment_sent_status == null && $ticket->win_amount != null){
									$payment_details = array(
										'ticket_id' => $ticket->ticket_id,
										'total_amount' => $ticket->win_amount,
										'payment_type' => 'outgoing',
										'payment_mode' => 'cheque',
										'payment_state' => 'paid',
										'payment_id'	=> $cheque_id,
										'payment_intent' => 'payment for win',
										'payment_response_type' => 'payment'
									);
									if($db->insert($apl->payment_details_table, $payment_details)){
										$transaction_id = $db->insert_id;
										$usert_ticket_details = array(
											'payment_sent_status' => 'paid',
											'payment_sent_transaction_id' => $transaction_id
										);
										$condition = array(
											'user_id' => $user_id,
											'ticket_id' => $ticket->ticket_id
										);
										if($db->update($apl->user_ticket_table, $usert_ticket_details, $condition)){
											$output['success'] = true;
										}else{
											$error = true;
											$error_message[] = "Payment unsuccessful. An error occured.";
										}
									}else{
										$error = true;
										$error_message[] = "Payment unsuccessful. An error occured.";
									}
								}
							}
						}
					}else{
						$error = true;
						$error_message[] = "You have to make full payment";
					}
				}
			}
		}else{
			$error = true;
			$error_message[] = "You don't have access to make payment updates";
		}

		if($output['success']){
			$output['data'] = "Payment Successfull";
		}else{
			$output['data'] =
			'<div class="alert alert-danger alert-dismissible fade in" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
				'</button>'.
				'<strong>Error!</strong>';
			foreach ($error_message as $key => $message) {
				$output['data'] .=
				'<li>'.$message.'</li>';
			}
			$output['data'] .=
			'</div>';
		}

		echo json_encode($output);
		die;
	}
}
