<?php


set_include_path('C:\xampp\htdocs\emc\phpseclib0.3.8');
include_once ('Net/SSH2.php');

class SSH {
 var $ssh, $ip, $username,$password;
 function SSH($_ip, $_username, $_password)
 {
  $this->ip = $_ip;
  $this->username = $_username;
  $this->password = $_password;
 }
 
 function connect()
 {
  $this->ssh = new Net_SSH2($this->ip);
  if (!$this->ssh->login($this->username, $this->password))
  {
   exit('Login Failed');
  }
 }
 
 function get_data()
 {
  $output =  $this->ssh->exec('cd /opt/Raptor;sudo python3 raptor.py appliance 0 all');

  $arrDelimiters = array(",","\n");
  $replacedDelimiterOutput = str_replace($arrDelimiters,"^",$output);
  //echo $replacedDelimiterOutput;

  $array = explode("^",$replacedDelimiterOutput);
  return $array;
 }
}

?> 
