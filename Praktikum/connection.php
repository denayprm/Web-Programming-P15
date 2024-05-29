<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "db_universitas";
    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(!$link){
        die("Connection failed: ".mysqli_connect_errno()." - " .mysqli_connect_error());
    }

?>