<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php if(!isset($_GET['login_id'])) { header("location:" . $apl->site_url . '/dashboard'); die(); } ?>
  <?php $apl->load_header(); ?>
  <div class="container body">
    <div class="main_container">

      <?php $apl->load_sidebar(); ?>
      <?php $apl->load_file('top_nav'); ?>
      <?php
        $updated = false;
        $user_id = $_GET['login_id'];
        $user_details = $user->get_user_data($user->get_user_id_from_login_id($user_id));
        if(isset($_POST['passcode'])){
          if($user->update_passcode($user_details->user_id, $_POST['passcode'])){
            $updated = true;
          }
        }
      ?>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Reset User's Passcode</h2>
                <div class="clearfix"></div>
              </div>
              <?php
              if($updated){
                ?>
                <div id="add_credit_success" class="alert alert-success alert-dismissible fade in" role="alert">The user's passcode has been updated</div>
                <?php
              }
              ?>
              <div class="x_content">
                <form id="reset_passcode_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="POST">
                  <div id = "reset_passcode_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                  </div>
                  <div id = "reset_passcode_success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
                  </div>
                  <input type = "hidden" id = "user_type" value = "store">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User ID <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input value = "<?php if(isset($_GET['login_id'])) echo $_GET['login_id']; ?>" type="text" id="login_id" required="required" class="form-control col-md-7 col-xs-12" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">New Passcode <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="passcode" class="form-control col-md-7 col-xs-12" type="text" name="passcode">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" id="reset_passcode" name="reset_passcode" class="btn btn-success">Reset Passcode</button>
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
                <h2>Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div id = "user_detail_processing" style = "display:none;width:100%;text-align:center;"><img src = "template/images/loader.gif"></div>
                <div id = "error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                </div>
                <div id = "success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
                </div>
                <div id = "ajax_response">
                  <div class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <p style="padding-top:8px;"><?php echo $user_details->first_name . '&nbsp;&nbsp;' . $user_details->last_name; ?></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <p style="padding-top:8px;"><?php echo $user_details->user_type; ?></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Email ID</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <p style="padding-top:8px;"><?php echo $user_details->email; ?></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone NUmber</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <p style="padding-top:8px;"><?php echo $user_details->phone; ?></p>
                      </div>
                    </div>
                  </div>                  
                </div>
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
