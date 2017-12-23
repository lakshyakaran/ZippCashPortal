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
                  <h3>Users</h3>
              </div>
          </div>

          <div class="clearfix"></div>

          <?php $user_list = $user->get_user_list(); ?>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>List of all users</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                          <table id="lottery_table" class="table table-striped responsive-utilities jambo_table">
                              <thead>
                                  <tr class="headings">
                                      <th>User ID</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Phone</th>
                                      <th>Country</th>
                                      <th>Joined on</th>
                                      <th class=" no-link last">
                                        <span class="nobr">Action</span>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php if($user_list != null): ?>
                                  <?php foreach($user_list as $key => $user): ?>
                                    <?php if($key%2 == 0): ?>
                                      <tr class="even pointer">
                                    <?php else: ?>
                                      <tr class="even pointer">
                                    <?php endif; ?>
                                    <td class=" "><?php echo $user->user_id; ?></td>
                                    <td class=" "><?php echo $user->first_name."&nbsp;".$user->last_name; ?></td>
                                    <td class=" "><?php echo $user->email; ?></td>
                                    <td class=" "><?php echo $user->phone; ?></td>
                                    <td class=" "><?php echo $user->country_name; ?></td>
                                    <td class=" "><?php echo $user->date_time; ?></td>
                                    <td class=" ">
                                      <?php
                                        echo "<a href = '".$apl->site_url."index.php?options=user/".$user->user_id."'>Details</a>";
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                        echo "<a href = '".$apl->site_url."index.php?options=reset_passcode&login_id=".$user->login_id."'>Reset Passcode</a>";
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                        if($user->status === 'active'){
                                          echo "<a href = '".$apl->site_url."index.php?options=block_user&user_id=".$user->user_id."'>Block</a>";
                                        }else{
                                          echo "<a href = '".$apl->site_url."index.php?options=unblock_user&user_id=".$user->user_id."'>Unblock</a>";
                                        }
                                      ?>
                                    </td>
                                    <?php if($key%2 == 0): ?>
                                      </tr>
                                    <?php else: ?>
                                      </tr>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                <?php endif; ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

              <br />
              <br />
              <br />

          </div>

				</div>
				<!-- /page content -->

		</div>
</div>
<!-- Datatables -->
<script src="<?php echo $apl->template_url; ?>js/datatables/js/jquery.dataTables.js"></script>
<script src="<?php echo $apl->template_url; ?>js/datatables/tools/js/dataTables.tableTools.js"></script>
<?php $apl->load_footer(); ?>
