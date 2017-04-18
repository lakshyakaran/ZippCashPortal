<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<?php
  if(isset($_GET['ticket_id'])) {
    $ticket = $lottery->get_ticket_numbers_by_ticket_id($_GET['ticket_id']);
    if($ticket == false){
      // header("location:" . $apl->site_url); die();
    }else{
      $ticket_details = $ticket->ticket_details;
      $ticket_numbers = $ticket->ticket_numbers;
    }
  }else{
    // header("location:" . $apl->site_url); die();
  }
?>
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
                        <h2>Ticket Details</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                      <div class="x_content">
                        <div class="bs-example" data-example-id="simple-jumbotron">
                          <div class = "form-horizontal">
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-3" style = "text-align:left;">User ID</label>
                              <div class="col-md-9 col-sm-9 col-xs-9">
                                <p style = "padding-top:8px;"><?php echo $ticket_details->login_id; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-3" style = "text-align:left;">Name</label>
                              <div class="col-md-9 col-sm-9 col-xs-9">
                                <p style = "padding-top:8px;"><?php echo $ticket_details->first_name . "&nbsp;" . $ticket_details->last_name; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-3" style = "text-align:left;">Ticket ID</label>
                              <div class="col-md-9 col-sm-9 col-xs-9">
                                <p style = "padding-top:8px;"><?php echo $ticket_details->ticket_id; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-3" style = "text-align:left;">Total Amount</label>
                              <div class="col-md-9 col-sm-9 col-xs-9">
                                <p style = "padding-top:8px;"><?php echo $ticket_details->total_amount; ?></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-3" style = "text-align:left;">Purchased On</label>
                              <div class="col-md-9 col-sm-9 col-xs-9">
                                <p style = "padding-top:8px;"><?php echo $ticket_details->purchased_on; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Ticket Numbers and Amount</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                          <div class="x_content">
                            <div class="bs-example" data-example-id="simple-jumbotron">
                              <table class = "table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Number</th>
                                    <th>Amount Paid</th>
                                    <th>Amount Won</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  foreach ($ticket_numbers as $key => $value) {
                                    if($value->win_amount == null){
                                      $win_amount = "Not Declared";
                                    }else{
                                      $win_amount = $value->win_amount;
                                    }
                                    ?>
                                    <tr>
                                      <td><?php echo $value->ticket_detail_id; ?></td>
                                      <td><?php echo $value->ticket_number; ?></td>
                                      <td><?php echo $value->ticket_amount; ?></td>
                                      <td><?php echo $win_amount; ?></td>
                                    </tr>
                                    <?php
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
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
