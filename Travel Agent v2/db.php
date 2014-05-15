<?php
//File db.php
//Desc: Database connection class
//Date:26/02/2005

class Db {

	//Constructor,connect to db usig hostname,user name,database name and password
    function db($dbhost,$dbuser,$dbpass,$dbname) {
   		$result=@mysql_pconnect($dbhost,$dbuser,$dbpass);
		if (!$result) {
			Die("Database conection failed");
		}
		if (!@mysql_select_db($dbname,$result)) {
			die("Database Selection failed");
		}
		return $result;
	}

	//Query database,Query is pass as string
    function query($sql) {
    	$result = @mysql_query($sql) or die(mysql_error());
       	return $result;
    }

	//Returns row as an associative array
    function fetch_array($sql) {
    	$result = @mysql_fetch_array($sql);
    	return $result;
    }

	// Returns row as an enumerated array
    function fetch_row($sql) {
    	$result = @mysql_fetch_row($sql);
    	return $result;
    }
	//Returns number of reocrd found
	function row_count($sql){
		$result=@mysql_num_rows($sql);
		return $result;
	}



}



?>