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
            <h3>Add new user</h3>
          </div>
        </div>

        <div class = "clearfix"></div>

        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Enter User Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div id = "success" style = "display: none;" class="alert alert-success alert-dismissible fade in" role="alert">
                </div>
                <form id="add_user_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                  <input type = "hidden" id = "user_type" value = "individual">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first_name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="last_name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="phone" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Adress</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="address" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Adress 2</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="address_2" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="city" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="state" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="country" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" disabled="true" value="Haiti">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Postal Code</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="postal_code" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Landmark</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="landmark" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" id = "add_user" class="btn btn-success">Submit</button>
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
                <div id = "email_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                </div>
                <div id = "phone_error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
                </div>
                <div id = "error" style = "display: none;" class="alert alert-danger alert-dismissible fade in" role="alert">
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
