<?php


    $host = "localhost";
    $port = "5432";
    $dbname = "EmployeeManagementSystem";
    $user = "postgres";
    $password = "carlo";


    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    var_dump($conn);

?>