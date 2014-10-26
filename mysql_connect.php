
<?php
include("DB.php");
include("SSH.php");

$db_servername = "localhost";
$db_username = "root";
$db_password = "mupparaju";
$db_name = "test";


$ssh_servername = "192.168.1.146";
$ssh_username = "hackathon";
$ssh_password = "hackathon";


$db_instance = new DB($db_servername, $db_username, $db_password, $db_name);
$db_instance->connect();

$ssh_instance = new SSH($ssh_servername, $ssh_username, $ssh_password);
$ssh_instance->connect();


$id = $db_instance->db_get_sample_id();


$data = $ssh_instance->get_data();

//1 and -2 limits are required!
for($i=1; $i < count($data)-2;) {
    
    $light_name = $data[$i++];
    $state = $data[$i++];
    $color1 = $data[$i++];
    $color2 = $data[$i++];
    
    $db_instance->db_insert($id,$light_name,$state,$color1,$color2);
    
}

echo "id is: ".$id;
    





?> 