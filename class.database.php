<?php

	# This method is automagically called when you create a new Object using this Class
	public function __construct() {
		# New mysqli Object for database communication
		$this->database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

		# Kill the page is there was a problem with the database connection
		if ( $this->database->connect_error ):
			die( "Connection Error! Error: " . $this->database->connect_error );
		endif;
	}

?>