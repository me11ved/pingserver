<?php
class Model {
   public function __construct() {
	

	$opts = array(
 		'user'    => DB_USER,
 		'pass'    => DB_PASSWORD,
 		'db'      => DB_NAME,
		);
	
	$this->db = new sql($opts);	
	$this->pt = new PingTools();	

   }
  }
  ?>