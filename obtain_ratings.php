<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize search query
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

// Modify SQL query to filter by search input if provided
$sql = "SELECT Movie_Title FROM MovieData";
if (!empty($searchQuery)) {
    $searchQuery = $connection->real_escape_string($searchQuery);
    $sql .= " WHERE Movie_Title LIKE '%$searchQuery%'";
}

$result = mysqli_query($connection, $sql);
?>

<!-- form -->
<html>
<head>
<title> Title </title>
<link rel="stylesheet" href="movie.css">
</head>

<body>
<h1>Movie Ratings</h1>

<!-- Search Form -->
<form method="post" action="">
    <label for="search">Search for a movie:</label>
    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
    <input type="submit" value="Search">
</form>

<form action="fill_ratings.php" method="post">
    <label for='user'>Name: </label>
    <select name='user'>
        <option value="Ricky">Ricky</option>
        <option value="Richard">Richard</option>
    </select>

    <select name='Movies'>
    <?php
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='" . htmlspecialchars($row['Movie_Title']) . "'>" . htmlspecialchars($row['Movie_Title']) . "</option>";
            }
        } else {
            echo "<option value=''>No movies found</option>";
        }
    ?>
    </select>
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