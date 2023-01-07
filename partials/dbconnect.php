<?php
$server="localhost";
$username="root";
$password="";
$database="user";
$mysqli=mysqli_connect($server,$username,$password,$database);

// if($mysqli){
//     echo "connected";
// }
// else{
//     die("error".mysqli_connect_error());
// }
// require_once 'pdoconfig.php';
// try {
// $mysqli = new PDO("mysql:host=$server;dbname=$database", $username, $password);
// echo "Connected to $database at $server successfully.";
// } catch (PDOException $pe) {
// die ("Could not connect to the database $database:" . $pe->getMessage());
// }

// ?>

