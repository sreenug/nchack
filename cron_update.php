<?php
include_once("insert_latest_data.php");
while(1)
{
    sleep(30);
    populate();
}
?>