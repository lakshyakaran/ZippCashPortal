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
                  <h3>Lotteries</h3>
              </div>
          </div>

          <div class="clearfix"></div>

          <?php $lottery_list = $lottery->get_lottery_list(); ?>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2>List of all lotteries</h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                          <table id="lottery_table" class="table table-striped responsive-utilities jambo_table">
                              <thead>
                                  <tr class="headings">
                                      <th>LotteryID </th>
                                      <th>Lottery Name</th>
                                      <th>Creaton Date</th>
                                      <th>Draw Date</th>
                                      <th>Status</th>
                                      <th class=" no-link last">
                                        <span class="nobr">Action</span>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php if($lottery_list != null): ?>
                                  <?php foreach($lottery_list as $key => $lottery): ?>
                                    <?php if($key%2 == 0): ?>
                                      <tr class="even pointer">
                                    <?php else: ?>
                                      <tr class="even pointer">
                                    <?php endif; ?>
                                    <td class=" "><?php echo $lottery->lottery_id; ?></td>
                                    <td class=" "><?php echo $lottery->lottery_name; ?></td>
                                    <td class=" "><?php echo $lottery->created_on; ?></td>
                                    <td class=" "><?php echo $lottery->lottery_date_time; ?></td>
                                    <td class=" "><?php echo ucfirst($lottery->status); ?></td>
                                    <td class=" ">
                                      <?php
                                        echo "<a href = '".$apl->site_url."index.php?options=lottery/".$lottery->lottery_id."'>View Details</a>";
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
