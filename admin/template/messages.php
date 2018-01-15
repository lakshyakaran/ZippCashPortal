<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
  <?php $apl->load_header(); ?>
  <div class="container body">
    <div class="main_container">

      <?php $apl->load_sidebar(); ?>
      <?php $apl->load_file('top_nav'); ?>
      <?php
        $messageSent = false;
        if(isset($_POST['message']) && $_POST['message'] != null){
          $user->send_message($_POST['message']);
          $messageSent = true;
        }
      ?>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Send New Message</h2>
                <div class="clearfix"></div>
              </div>
              <?php
              if($messageSent){
                ?>
                <div id="add_credit_success" class="alert alert-success alert-dismissible fade in" role="alert">The message has been sent successfully</div>
                <?php
              }
              ?>
              <div class="x_content">
                <form id="send_message_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="POST">
                  <div id = "send_message_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                  </div>
                  <div id = "send_message_success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea required="required" name="message" class="form-control col-md-7 col-xs-12">
                      </textarea>
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" id="reset_passcode" name="reset_passcode" class="btn btn-success">Send Now</button>
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
