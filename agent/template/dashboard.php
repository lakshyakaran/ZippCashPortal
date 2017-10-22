<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
	<?php $apl->load_header(); ?>
	<?php $total_users = $user->get_active_user_count(); ?>
	<?php $total_stores = $user->get_active_store_count(); ?>
	<?php $zippcash_acount = $user->get_zippcash_account_details(); ?>
	<?php $recent_deposits = $user->get_recent_transaction(0, 'cash_deposit', 5); ?>
	<?php $recent_withdrawls = $user->get_recent_transaction(0, 'cash_withdraw', 5); ?>
	<div class="container body">
		<div class="main_container">

			<?php $apl->load_sidebar(); ?>
			<?php $apl->load_file('top_nav'); ?>
			<?php $apl->load_file('add_new_store'); ?>
			<!-- page content -->
		</div>
	</div>
	<div id="custom_notifications" class="custom-notifications dsp_none">
		<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
		</ul>
		<div class="clearfix"></div>
		<div id="notif-group" class="tabbed_notifications"></div>
	</div>
	<?php $apl->load_footer(); ?>
