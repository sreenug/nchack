<?php

//$var = ' ';
//$var = trim($var);

// This will evaluate to TRUE so the text will be printed.
if (isset($var)) {
    echo "This var is set so I will print.\n";
}

if(empty($var))
{
    echo "$var is empty\n";
}

if(is_null($var))
{
    echo "$var is null\n";
}
?>