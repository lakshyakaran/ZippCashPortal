<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php $apl->load_header(); ?>
<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
				<!-- page content -->
				<div class="right_col" role="main">

						<!-- top tiles -->
						<div class="row tile_count">
              <center>
                <h1>404 Error! Page not found.</h1>
              </center>
						</div>
						<!-- /top tiles -->
				</div>
				<!-- /page content -->

		</div>
</div>
<?php $apl->load_footer(); ?>
