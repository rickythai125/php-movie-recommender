<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_POST['formSubmit'] == "Submit") {
    $varName = $_POST['user'];
    $varMovie = $_POST['Movies'];
    $varRating = $_POST['rating'];
    $errorMessage = "";
}

$exists = "SELECT ID FROM UserRatings WHERE Movie = '$varMovie'";
$result = $connection->query($exists);
$varMovie = str_replace("'","''", $varMovie);
$updatedMovieName = mysqli_real_escape_string($connection, $varMovie);

if ($_POST['user'] == "Ricky") {
    if ($result->num_rows == 0) {
        $rickyData = "INSERT INTO UserRatings(Movie,Ricky_Rating) VALUES('".$varMovie."','".$varRating."')";

        if ($connection->query($rickyData) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $connection->error;
        }
    } else {
        $updateRicky = "UPDATE `UserRatings`
        SET `Ricky_Rating` = $varRating
        WHERE Movie='$updatedMovieName'";

        if ($connection->query($updateRicky) === TRUE) {
            echo "Row updated successfully";
        } else {
            echo "Error adding data: " . $connection->error;
        }
    }
}

if ($_POST['user'] == "Richard") {
    if ($result->num_rows == 0) {
        $richardData = "INSERT INTO UserRatings(Movie,Richard_Rating) VALUES('".$varMovie."','".$varRating."')";

        if ($connection->query($richardData) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $connection->error;
        }
    } else {
        $updateRichard = "UPDATE `UserRatings`
        SET `Richard_Rating` = $varRating
        WHERE Movie='$updatedMovieName'";

        if ($connection->query($updateRichard) === TRUE) {
            echo "Row updated successfully";
        } else {
            echo "Error adding data: " . $connection->error;
        }
    }
}

?>

<html>
<head>
<title> Form Data </title>
</head>
<body>
<h3>Form submission successful</h3>
<p> Your name: <?php echo $varName; ?> </p>
<p> Movie: <?php echo $varMovie; ?> </p>
<p> Rating: <?php echo $varRating; ?> </p>
<a href="obtain_ratings.php">Back</a>
</body>
</html>