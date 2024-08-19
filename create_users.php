<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "CREATE TABLE UserRatings (
    ID int NOT NULL AUTO_INCREMENT,
    Movie varchar(255),
    Ricky_Rating float(2),
    Richard_Rating float(2),
    PRIMARY KEY (ID)
);";

if ($connection->query($sql) === TRUE) {
    echo "UserRatings table created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

$connection->close();
?>