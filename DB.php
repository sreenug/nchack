<?php

class DB {
   var $conn,$servername, $db_name, $username, $password;
   function DB($_servername, $_username, $_password, $_db_name)
   {
     $this->servername = $_servername;
     $this->username = $_username;
     $this->password = $_password;
     $this->db_name = $_db_name;
   }
   
   function connect()
   {
       // Create connection
       $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db_name);

       // Check connection
       if ($this->conn->connect_error) {
           die("Connection failed: " . $this->conn->connect_error);
       }
       //echo "Connected successfully";
       return $this->conn;
   }
   
   function db_insert($sample_id, $light_name, $state, $color1, $color2)
   {
     $sample_id = trim($sample_id);
     $light_name = trim($light_name);
     $state = trim($state);
     $color1 = trim($color1);
     $color2 = trim($color2);
     
     //echo " <br>". $sample_id. " ". $light_name. " ". $state ." ". $color1." ". $color2;
     if(!$light_name || (strcmp($light_name,'') == 0) ) $light_name = 'na';
     if(!$state || (strcmp($state,'') == 0) ) $state = 'na';
     if(empty($color1)) $color1 = 'na';
     if(empty($color2)) $color2 = 'na';
     

     //echo " <br>". $sample_id. " ". $light_name. " ". $state ." ". $color1." ". $color2." <br>";
     
     $sql_query = "INSERT INTO raptor_data(sample_id, light_name, state, color1, color2)
     VALUES($sample_id, '$light_name', '$state', '$color1', '$color2')";
     
     //echo "query is ".$sql_query." <br> ";
     
     if ($this->conn->query($sql_query) === TRUE) {
         //echo "New record created successfully";
     } else {
         echo "Error: " . $sql_query . "<br>" . $this->conn->error;
     }
   }
   
   function db_get_sample_id()
   {
     $sql_query = "SELECT MAX(sample_id) as sample_id FROM raptor_data";
     $result = $this->conn->query($sql_query);
     
     $obj=mysqli_fetch_object($result);
     if($obj->sample_id)
     {
          return $obj->sample_id;
     }
     else
     {
          return 0;
     }
   }
   
   function db_get_sample_data($sample_id)
   {
     $sql_query = "SELECT light_name, state, color1, color2, time_stamp FROM raptor_data where sample_id = $sample_id";
     $result = $this->conn->query($sql_query);
     
     $obj=mysqli_fetch_object($result);
     
     $i=0;
     $all_rows = array();
     while($row = mysqli_fetch_array($result))
     {
         $all_rows[$i]['light_name']=$row['light_name'];
         $all_rows[$i]['state']=$row['state'];
         $all_rows[$i]['color1']=$row['color1'];
         $all_rows[$i]['color2']=$row['color2'];
         $i++;
     }
     return $all_rows;
   }
   
   function db_get_hour_data()
   {
     $sql_query = "SELECT light_name, state, color1, color2, hour(time_stamp) as data_hour FROM raptor_data";
     $result = $this->conn->query($sql_query);
     
     $obj=mysqli_fetch_object($result);
     
     $i=0;
     $all_rows = array();
     while($row = mysqli_fetch_array($result))
     {
         $all_rows[$i]['light_name']=$row['light_name'];
         $all_rows[$i]['state']=$row['state'];
         $all_rows[$i]['color1']=$row['color1'];
         $all_rows[$i]['color2']=$row['color2'];
         $all_rows[$i]['data_hour']=$row['data_hour'];
         $i++;
     }
     return $all_rows;
     
   }
   
      function db_get_all_data()
   {
     $sql_query = "SELECT light_name, state, color1, color2, time_stamp  FROM raptor_data";
     $result = $this->conn->query($sql_query);
     
     $obj=mysqli_fetch_object($result);
     
     $i=0;
     $all_rows = array();
     while($row = mysqli_fetch_array($result))
     {
         $all_rows[$i]['light_name']=$row['light_name'];
         $all_rows[$i]['state']=$row['state'];
         $all_rows[$i]['color1']=$row['color1'];
         $all_rows[$i]['color2']=$row['color2'];
         $all_rows[$i]['time']=$row['time_stamp'];
         $i++;
     }
     return $all_rows;
     
   }
   
   function db_commit()
   {
     $this->conn->commit();
   }
}
?>