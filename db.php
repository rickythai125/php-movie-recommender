<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";

$connection = new mysqli($servername, $username, $password);
if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE movies";
if ($connection->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$connection->close();
?>