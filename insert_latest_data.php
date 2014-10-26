
<?php
include_once("DB.php");
include_once("SSH.php");

include_once("php-mailjet-v3-simple.class.php");


populate();
function populate()
{   
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
    
    $all_rows = format_ssh_data($data);
    
    //Mailing if RED alert
    send_alarm($all_rows);
    
    insert_ssh_data($db_instance, $id, $all_rows);   
}

function format_ssh_data($data)
{
    $all_rows = array();
    $j=0;
    //1 and -2 limits are required!
    for($i=1; $i < count($data)-2;)
    {
        $all_rows[$j]['light_name']=$data[$i++];
        $all_rows[$j]['state']=$data[$i++];
        $all_rows[$j]['color1']=$data[$i++];
        $all_rows[$j]['color2']=$data[$i++];
        $j++;
    }
    return $all_rows;
}

function insert_ssh_data($db_instance, $id, $all_rows)
{
    for ( $i = 0; $i < count($all_rows); $i++)
    {
        $light_name = $all_rows[$i]['light_name'];
        $state = $all_rows[$i]['state'];
        $color1 = $all_rows[$i]['color1'];
        $color2 = $all_rows[$i]['color2'];
        $db_instance->db_insert($id+1,$light_name,$state,$color1,$color2);
    }
    $db_instance->db_commit();
}


function send_alarm($all_rows) {
    $send_once = 0;
    
    for ($i=0; $i < count($all_rows); $i++ ) {
        if ( strcmp($all_rows[$i]['color1'],'Red') == 0) {
            $send_once = 1;
        }
        
        if ( strcmp($all_rows[$i]['color2'],'Red') == 0) {
            $send_once = 1;
        }        
    }
    
    if ($send_once == 1) {
        //send_email();
        echo 'Email sent';
    }
    
}

function send_email() {
    $mj = new Mailjet();
    $params = array(
        "method" => "POST",
        "from" => "pratham@live.unc.edu",
        "to" => "sreenu@live.unc.edu",
        "subject" => "Alert from Raptor!",
        "text" => "A LED color was RED"
    );

    $result = $mj->sendEmail($params);

    if ($mj->_response_code == 200) {
        
       //echo "success - email sent";
    }
    else {
       //echo "error - ".$mj->_response_code;
    }

    return $result;
}    

?> 