<?php
// return [
//     'database' => [
//         'host' => 'localhost',
//         'port' => 3306,
//         'dbname' => 'users_db',
//         'charset' => 'utf8mb4'
//     ]
//     ];

$host = "localhost";
$user = "root";
$password = "";
$database = "users_db";

$conn = new mysqli($host, $user, $password, $database);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// define("HOSTNAME", "localhost");
// define("USERNAME", "root");
// define("PASSWORD", "");
// define("DATABASE", "users_db");

// $connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// if(!$connection) {
//     die("Connection failed");   
// } else {
//     echo "Connection Successful";
// } 


?>