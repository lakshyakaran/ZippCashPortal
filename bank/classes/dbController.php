<?php

class db{
	
	var $show_errors = false;
	
	
	var $ready = false;
	
	
	var $field_types = array();
	
	
	var $last_error = '';


	var $num_queries = 0;


	var $num_rows = 0;


	var $rows_affected = 0;

	
	var $insert_id = 0;

	
	var $last_query;


	var $last_result;
	
	
	var $func_call;
	
	
	var $queries;


	protected $result;


	protected $col_info;


	public $is_mysql = null;
	
	
	protected $dbuser;


	protected $dbpassword;


	protected $dbname;


	protected $dbhost;


	protected $dbh;
	
	function __construct( $dbuser, $dbpassword, $dbname, $dbhost = "localhost" ) {
//		register_shutdown_function( array( $this, '__destruct' ) );

		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;

		$this->db_connect();
	}
	
	function __destruct(){
		return true;
	}
	
	
	function _real_escape( $string ) {
		if ( $this->dbh )
			return mysql_real_escape_string( $string, $this->dbh );

		$class = get_class( $this );
		_doing_it_wrong( $class, "$class must set a database connection for use with escaping.", E_USER_NOTICE );
		return addslashes( $string );
	}
	
	
	function show_errors( $show = true ) {
		$errors = $this->show_errors;
		$this->show_errors = $show;
		return $errors;
	}
	
	function db_connect() {

		$this->is_mysql = true;

		$new_link = defined( 'MYSQL_NEW_LINK' ) ? MYSQL_NEW_LINK : true;
		$client_flags = defined( 'MYSQL_CLIENT_FLAGS' ) ? MYSQL_CLIENT_FLAGS : 0;

		$this->dbh = mysql_connect( $this->dbhost, $this->dbuser, $this->dbpassword, $new_link, $client_flags );

		if ( !$this->dbh ) {
			$this->bail( sprintf( __( "
<h1>Error establishing a database connection</h1>
<p>This either means that the username and password information in your <code>wp-config.php</code> file is incorrect or we can't contact the database server at <code>%s</code>. This could mean your host's database server is down.</p>
<ul>
	<li>Are you sure you have the correct username and password?</li>
	<li>Are you sure that you have typed the correct hostname?</li>
	<li>Are you sure that the database server is running?</li>
</ul>
<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>
" ), htmlspecialchars( $this->dbhost, ENT_QUOTES ) ), 'db_connect_fail' );

			return;
		}

		$this->ready = true;

		$this->select( $this->dbname, $this->dbh );
	}
	
	function select( $db, $dbh = null ) {
		if ( is_null($dbh) )
			$dbh = $this->dbh;

		if ( !@mysql_select_db( $db, $dbh ) ) {
			$this->ready = false;
			wp_load_translations_early();
			$this->bail( sprintf( __( '<h1>Can&#8217;t select database</h1>
<p>We were able to connect to the database server (which means your username and password is okay) but not able to select the <code>%1$s</code> database.</p>
<ul>
<li>Are you sure it exists?</li>
<li>Does the user <code>%2$s</code> have permission to use the <code>%1$s</code> database?</li>
<li>On some systems the name of your database is prefixed with your username, so it would be like <code>username_%1$s</code>. Could that be the problem?</li>
</ul>
<p>If you don\'t know how to set up a database you should <strong>contact your host</strong>. If all else fails you may find help at the <a href="http://wordpress.org/support/">WordPress Support Forums</a>.</p>' ), htmlspecialchars( $db, ENT_QUOTES ), htmlspecialchars( $this->dbuser, ENT_QUOTES ) ), 'db_select_fail' );
			return;
		}
	}
	
	function bail( $message, $error_code = '500' ) {
		if ( !$this->show_errors ) {
			$this->error = $message;
		}
	}
	
	function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$this->insert_id = 0;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		$sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
		return $this->query( $this->prepare( $sql, $data ) );
	}
	
	function query( $query ) {
		if ( ! $this->ready )
			return false;


		$return_val = 0;
		$this->flush();

		// Log how the function was called
		$this->func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		$this->last_query = $query;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )
			$this->timer_start();

		$this->result = @mysql_query( $query, $this->dbh );
		$this->num_queries++;

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )
			$this->queries[] = array( $query, $this->timer_stop(), $this->get_caller() );

		// If there is an error then take note of it..
		if ( $this->last_error = mysql_error( $this->dbh ) ) {
			// Clear insert_id on a subsequent failed insert.
			if ( $this->insert_id && preg_match( '/^\s*(insert|replace)\s/i', $query ) )
				$this->insert_id = 0;

			//$this->print_error();
			return false;
		}

		if ( preg_match( '/^\s*(create|alter|truncate|drop)\s/i', $query ) ) {
			$return_val = $this->result;
		} elseif ( preg_match( '/^\s*(insert|delete|update|replace)\s/i', $query ) ) {
			$this->rows_affected = mysql_affected_rows( $this->dbh );
			// Take note of the insert_id
			if ( preg_match( '/^\s*(insert|replace)\s/i', $query ) ) {
				$this->insert_id = mysql_insert_id($this->dbh);
			}
			// Return number of rows affected
			$return_val = $this->rows_affected;
		} else {
			$num_rows = 0;
			while ( $row = @mysql_fetch_object( $this->result ) ) {
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}

			// Log number of rows the query returned
			// and return number of rows selected
			$this->num_rows = $num_rows;
			$return_val     = $num_rows;
		}

		return $return_val;
	}


	function flush() {
		$this->last_result = array();
		$this->col_info    = null;
		$this->last_query  = null;
		$this->rows_affected = $this->num_rows = 0;
		$this->last_error  = '';

		if ( is_resource( $this->result ) )
			mysql_free_result( $this->result );
	}
	
	function timer_start() {
		$this->time_start = microtime( true );
		return true;
	}
	
	function timer_stop() {
		return ( microtime( true ) - $this->time_start );
	}

	function get_caller() {
		return wp_debug_backtrace_summary( __CLASS__ );
	}
	
	function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
	}
	
	function escape_by_ref( &$string ) {
		if ( ! is_float( $string ) )
			$string = $this->_real_escape( $string );
	}

	function get_results( $query = null, $output = OBJECT ) {
		$this->func_call = "\$db->get_results(\"$query\", $output)";

		if ( $query )
			$this->query( $query );
		else
			return null;

		$new_array = array();
		if ( $output == OBJECT ) {
			// Return an integer-keyed array of row objects
			return $this->last_result;
		} elseif ( $output == OBJECT_K ) {
			// Return an array of row objects with keys from column 1
			// (Duplicates are discarded)
			foreach ( $this->last_result as $row ) {
				$var_by_ref = get_object_vars( $row );
				$key = array_shift( $var_by_ref );
				if ( ! isset( $new_array[ $key ] ) )
					$new_array[ $key ] = $row;
			}
			return $new_array;
		} elseif ( $output == ARRAY_A || $output == ARRAY_N ) {
			// Return an integer-keyed array of...
			if ( $this->last_result ) {
				foreach( (array) $this->last_result as $row ) {
					if ( $output == ARRAY_N ) {
						// ...integer-keyed row arrays
						$new_array[] = array_values( get_object_vars( $row ) );
					} else {
						// ...column name-keyed row arrays
						$new_array[] = get_object_vars( $row );
					}
				}
			}
			return $new_array;
		}
		return null;
	}

	function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}

}
