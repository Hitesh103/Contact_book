<?php
function db_connect(){

    $host = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "contactbook";
    $conn = mysql_connect($host,$dbUser,$dbPass,$dbName) or die("DB connection Error: " . mysqli_connect_error());
    return $conn;
}

function db_close($conn){
    mysqli_close($conn);
}