<?php

	include_once("DB.php");

	$db_servername = "localhost";
	$db_username = "root";
	$db_password = "mupparaju";
	$db_name = "test";

	$db_instance = new DB($db_servername, $db_username, $db_password, $db_name);
	$db_instance->connect();

	
	$latest_id = $db_instance->db_get_sample_id();
	
	//echo $latest_id."<br>";
	$latest_result = $db_instance->db_get_sample_data($latest_id);
	
	//echo var_dump($latest_result);
	
	//Create a JSON output
	$prefix = '';
	echo "[\n";

	for ( $i = 0; $i < count($latest_result); $i++) {
		echo $prefix." {\n";
			
		echo '"light_name": "'.$latest_result[$i]['light_name'].'",'."\n";	
		echo '"state": "'.$latest_result[$i]['state'].'",'."\n";
		echo '"color1": "'.$latest_result[$i]['color1'].'",'."\n";
		echo '"color2": "'.$latest_result[$i]['color2'].'"'."\n";
		
		echo " }";
		$prefix = ",\n";
	}
	
	echo "\n]";

?>