<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT Movie_Title FROM MovieData
        WHERE Avg_Rating > 7.8";

$result = mysqli_query($connection, $sql);
?>

<!-- form -->
<html>
<head>
<title> Title </title>
<link rel="stylesheet" href="movie.css">
</head>

<body>
<form action="fill_ratings.php" method="post">
<h1>Movie Ratings</h1>
<label for='user'>Name: </label>
<select name='user'>
    <option value="Ricky">Ricky</option>
    <option value="Richard">Richard</option>
</select>

<select name='Movies'>
<?php
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row['Movie_Title'] ."'>" . $row['Movie_Title'] ."</option>";
}

echo "</select>";
?>
<br>

<label for='rating'>Rating(1-5): </label>
    <input type="radio" name="rating" value="1">1
    <input type="radio" name="rating" value="2">2
    <input type="radio" name="rating" value="3">3
    <input type="radio" name="rating" value="4">4
    <input type="radio" name="rating" value="5">5

<input type="submit" name="formSubmit">
</form>
</body>

</html>