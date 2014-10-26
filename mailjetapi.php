<?php
    
    include("php-mailjet-v3-simple.class.php");
    
    sendEmail();

    function sendEmail() {
        $mj = new Mailjet();
        $params = array(
            "method" => "POST",
            "from" => "pratham@live.unc.edu",
            "to" => "sreenu@live.unc.edu",
            "subject" => "Test 2",
            "text" => "Test 2"
        );

        $result = $mj->sendEmail($params);

        if ($mj->_response_code == 200)
           echo "success - email sent";
        else
           echo "error - ".$mj->_response_code;

        return $result;
    }    

?>


