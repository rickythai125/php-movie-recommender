<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$mean_ricky = 
"SELECT ROUND(AVG(Ricky_Rating),2)
From UserRatings
WHERE Ricky_Rating IS NOT NULL
AND Richard_Rating IS NOT NULL;";
$result_average = $connection->query($mean_ricky);

if ($result_average->num_rows > 0) {
    while ($row = $result_average->fetch_assoc()) {
        $complete_mean_ricky = $row['ROUND(AVG(Ricky_Rating),2)'];
        echo "<br>";
    }
}

$rank_array_ricky = Array();
$rank_array_richard = Array();

$all_ratings = "SELECT Movie, Ricky_Rating, Richard_Rating FROM UserRatings";
$result = $connection->query($all_ratings);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Rating for Ricky for Movie: " . $row["Movie"] . " is: " . $row["Ricky_Rating"];
        echo "<br>";
        array_push($rank_array_ricky, $row["Ricky_Rating"]);

        echo "Rating for Richard for Movie: " . $row["Movie"] . " is: " . $row["Richard_Rating"];
        echo "<br>";
        array_push($rank_array_richard, $row["Richard_Rating"]);
    }
}

?>