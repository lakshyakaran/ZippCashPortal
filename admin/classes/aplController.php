<?php

class aplController{

	private $page_name = 'index';

	private $default_page_name = 'index';

	public $template_path = '';

	public $template_url = '';

	public $params = array();

	protected $site;

	public $site_title = null;

	public $site_url = null;

	public $site_path = null;

	public $admin_table = "user_admin";

	public $user_table = "user_info";

	public $agent_table = "user_agent";

	public $user_wallet_table = "user_wallet";

	public $lottery_table = "lottery_details";

	public $lottery_result_table = "lottery_result";

	public $user_ticket_table = "user_ticket";

	public $transaction_details_table = "transaction_details";

	public $ticket_details_table = "ticket_details";

	public $payment_details_table = "payment_details";


	function __construct(){
		date_default_timezone_set('America/New_York');
		if( $this->site_title == null )
			$this->site_title = "NGO Time";

		if( $this->site_url == null )
			$this->site_url = BASE_URL . "/";

		if( $this->site_path == null )
			$this->site_path = BASE_PATH . "/";

		$this->setReporting();
		$this->removeQuotes();
		$this->unregisterGlobals();
	}

	function setReporting(){
		if(DEVELOPMENT_ENVIRONMENT == true){
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', 'Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', BASE_PATH . "/tmp/errors/error.log");
		}
	}


	function stripSlashesAll($value){
		$value = is_array($value) ? array_map( array( $this, 'stripSlashesAll' ), $value) : stripslashes($value);
		return $value;
	}


	function removeQuotes(){
		if(get_magic_quotes_gpc()){
			$_GET = $this->stripSlashesAll($_GET);
			$_POST = $this->stripSlashesAll($_POST);
			$_COOKIE = $this->stripSlashesAll($_COOKIE);
		}
	}


	function unregisterGlobals(){
		if(ini_get('register_globals')){
			$array = array('$_GET', '$_POST', '$_REQUEST', '$_SERVER', '$_FILES', '$_ENV', '$_COOKIE');
			foreach($array as $value){
				foreach($GLOBALS[$value] as $key => $var){
					if($var == $GLOBALS[$key]){
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}

	function process_url(){
		if(isset($_GET['options']) && $this->stripSlashesAll($_GET['options']) != null)
			$options = $this->stripSlashesAll($_GET['options']);
		else
			$options = "index";

		$optionsArray = array();
		$params = array();
		$optionsArray = explode('/', preg_replace('{/$}', '', preg_replace('{/*/}', '/', $options)));
		if(isset($optionsArray[0]))
			$this->page_name = $optionsArray[0];

		array_shift($optionsArray);

		if(isset($optionsArray[0]))
			$this->params = $optionsArray;
	}

	function get_page_name(){
		return $this->page_name;
	}

	function get_params(){
		return $this->params;
	}

	function set_template_path(){
		$this->template_path = BASE_PATH . '/template/';
		$this->template_url = BASE_URL . '/template/';
	}

	function load_template(){
		global $apl;
		global $user;
		global $lottery;

		if( file_exists( $this->template_path . $this->page_name . '.php' ) )
			require_once $this->template_path . $this->page_name . '.php';
		else
			require_once $this->template_path . '404.php';
	}

	function load_header(){
		global $apl;
		global $user;

		if( file_exists( $this->template_path . 'header.php' ) )
			require_once $this->template_path . 'header.php' ;

		return true;
	}

	function load_footer(){
		global $apl;
		global $site;

		if( file_exists( $this->template_path . 'footer.php' ) )
			require_once $this->template_path . 'footer.php' ;

		return true;
	}

	function load_sidebar(){
		global $apl;
		global $site;

		if( file_exists( $this->template_path . 'sidebar.php' ) )
			require_once $this->template_path . 'sidebar.php' ;

		return true;
	}

	function load_file( $file_name ){
		global $apl;
		global $user;

		if( file_exists( $this->template_path . $file_name . '.php' ) )
			require_once $this->template_path . $file_name .'.php' ;

		return true;
	}

	function get_site_title(){
		return $this->site_title;
	}

	function get_random_number( $length ) {
		$characters = "0123456789";
		$string;
		for ($p = 0; $p < $length ; $p++) {
			@$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}

	public function parse_data_in_table( $data_array, $table_class = '' ){
		$html_content = '';
		$html_content .= '
		<table class = "'.$table_class.'">
			<thead>
				<tr class = "column-header">
		';
		foreach( $data_array as $key => $value ):
			if( $key == 0 ):
				foreach( $value as $data => $width ):
					$html_content .= '
					<th class = "manage-column" width = "'.$width.'%">'.$data.'</th>
					';
				endforeach;
				$html_content .= '</tr></thead><tbody>';
			else:
				$html_content .= '<tr>';
				foreach( $value as $data ):
					$html_content .= '
					<td>'.$data.'</td>
					';
				endforeach;
				$html_content .= '</tr>';
			endif;
		endforeach;
		$html_content .='
			</tbody>
		</table>
		';
		return $html_content;
	}
}
