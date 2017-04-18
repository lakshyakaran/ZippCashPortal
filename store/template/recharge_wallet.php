<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
  <?php $apl->load_header(); ?>
  <div class="container body">
    <div class="main_container">

      <?php $apl->load_sidebar(); ?>
      <?php $apl->load_file('top_nav'); ?>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>recharge USer Wallet</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <form id="recharge_wallet_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                  <div id = "recharge_wallet_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                  </div>
                  <div id = "recharge_wallet_success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
                  </div>
                  <input type = "hidden" id = "user_type" value = "store">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User/Store ID <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input value = "<?php if(isset($_POST['login_id'])) echo $_POST['login_id']; ?>" type="text" id="login_id" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Credit Amount <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="credit_amount" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" id = "recharge_wallet" class="btn btn-success" disabled="true">Recharge</button>
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
                <div id = "ajax_response"></div>
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
