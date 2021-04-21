<?php

    $hostname = "localhost";
    $username = "einater_admin";
    $password = "admin";
    $db = "einater_castdb";
    
    $connection = new mysqli($hostname, $username, $password, $db);
    
    if($connection->connect_error)
    {
        die("error occurred while tryin to connect to DB: ".$connection->connect_error);
    }

?>