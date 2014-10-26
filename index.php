<?php
set_include_path('C:\xampp\htdocs\emc\phpseclib0.3.8');
include('Net/SSH2.php');


class SSH {
 var $ssh, $_ip, $username,$password;
 function SSH($_ip, $_username, $_password)
 {
  $this->ip = $_ip;
  $this->username = $_username;
  $this->password = $_password;
 }
 
 function connect()
 {
 
    
 }
   
$ssh = new Net_SSH2('192.168.1.146');
if (!$ssh->login('hackathon', 'hackathon'))
{
 exit('Login Failed');
}
$output =  $ssh->exec('cd /opt/Raptor;sudo python3 raptor.py appliance 0 all');

$arrDelimiters = array(",","\n");
$replacedDelimiterOutput = str_replace($arrDelimiters,"^",$output);
//echo $replacedDelimiterOutput;

$array = explode("^",$replacedDelimiterOutput); 

for ($i =1; $i < count($array)-2; $i++) {
 echo '</br>'.'Entry: '.$array[$i];
}




?> 
