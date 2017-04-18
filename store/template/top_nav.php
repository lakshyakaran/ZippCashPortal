<!-- top navigation -->
<div class="top_nav">

  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class = "row">
        <div class = "col-md-2 col-sm-2 col-xs-2">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
        </div>
        <div class = "col-md-7 col-sm-7 col-xs-7">
          <ul class="nav navbar-nav navbar-left">
            <li class="">
              <div class="input-group" style = "margin-top: 10px;">
                <input type="text" class="form-control" id = "search" placeholder="Search for user or store...">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </li>
          </ul>
        </div>
        <div class = "col-md-3 col-sm-3 col-xs-3">
          <ul class="nav navbar-nav navbar-right">
            <li class="">
              <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $apl->template_url; ?>/images/img.jpg" alt=""><?php echo $user->current_user_name; ?>
                <span class=" fa fa-angle-down"></span>
              </a>
              <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                <li>
                  <a href="javascript:;">  Profile</a>
                </li>
                <li>
                  <a href="index.php?options=logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

</div>
<!-- /top navigation -->
