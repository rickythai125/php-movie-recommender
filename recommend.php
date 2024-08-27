<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$userID = isset($_POST['userID']) ? $_POST['userID'] : '';

$recommendations = [];
$movieGenres = [];
$userRatings = [];
$userPreferences = [];

if ($userID) {
    $user_sql = $userID . "_Rating";
    $sql = "SELECT Movie, $user_sql FROM UserRatings";
    $userRatingsResult = $connection->query($sql);

    if ($userRatingsResult->num_rows > 0) {
        while ($row = $userRatingsResult->fetch_assoc()) {
            $userRatings[$row['Movie']] = $row[$user_sql];
        }
    }

    $sql = "SELECT Movie_Title, Genre FROM MovieData";
    $moviesResult = $connection->query($sql);

    if ($moviesResult->num_rows > 0) {
        while ($row = $moviesResult->fetch_assoc()) {
            $movieGenres[$row['Movie_Title']] = explode(',', $row['Genre']);
        }
    }

    foreach ($userRatings as $movie => $rating) {
        if (isset($movieGenres[$movie])) {
            foreach ($movieGenres[$movie] as $genre) {
                if (!isset($userPreferences[$genre])) {
                    $userPreferences[$genre] = 0;
                }
                $userPreferences[$genre] += $rating;
            }
        }
    }

    $totalRatings = array_sum($userRatings);
    foreach ($userPreferences as $genre => $preference) {
        $userPreferences[$genre] /= $totalRatings;
    }

    // echo "User Preferences:<br>";
    // print_r($userPreferences);
    // echo "<br>";

    $recommendations = [];
    foreach ($movieGenres as $movie => $genres) {
        if (!isset($userRatings[$movie])) {
            $score = 0;
            foreach ($genres as $genre) {
                if (isset($userPreferences[$genre])) {
                    $score += $userPreferences[$genre];
                }
            }
            $recommendations[$movie] = $score;
        }
    }

    arsort($recommendations);

}

$connection->close();

?>

<html>
<head>
    <title>Movie Recommendations</title>
</head>
<body>

<h1>Movie Recommendations</h1>

<!-- User selection form -->
<form method="post" action="">
    <label for="userID">Select User:</label>
    <select name="userID" id="userID">
        <option value="Ricky" <?php if ($userID == 'Ricky') echo 'selected'; ?>>Ricky</option>
        <option value="Richard" <?php if ($userID == 'Richard') echo 'selected'; ?>>Richard</option>
        <!-- Add more user options as needed -->
    </select>
    <input type="submit" value="Get Recommendations">
</form>

<?php if (!empty($userID) && !empty($recommendations)): ?>
    <h2>Recommended Movies for User <?php echo htmlspecialchars($userID); ?>:</h2>
    <ul>
        <?php 
        $count = 0;
        $max_count = 15;
        foreach ($recommendations as $movie => $score): 
            if ($count >= $max_count) break;
            $genres = implode(", ", $movieGenres[$movie]);
        ?>
            <li>
                <?php echo htmlspecialchars($movie); ?> - Genres: (<?php echo htmlspecialchars($genres); ?>)
            </li>
        <?php 
        $count++;
        endforeach; 
        ?>
    </ul>
<?php endif; ?>

</body>
</html>