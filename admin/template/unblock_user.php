<?php if( !$user->is_logged_in() ){ header("location:" . $apl->site_url); die();}; ?>
<?php
	if(isset($_GET['user_id'])){
		$user_details = $user->get_user_data($_GET['user_id']);
		if($user_details){
			$user->unblock_user($_GET['user_id']);
			header("location:" . $apl->site_url . 'index.php?options=users');
		}
	}else{
		header("location:" . $apl->site_url . 'index.php?options=404');
		die();
	}
?>