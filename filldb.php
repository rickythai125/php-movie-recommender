<?php
$servername = "127.0.0.1";
$username = "root";
$password = "pass";
$dbname = "movies";

$connection = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "DROP TABLE IF EXISTS MovieData;";
$connection->query($sql);

$connection->set_charset("utf8mb4");

$sql = "CREATE TABLE MovieData (
    ID int NOT NULL AUTO_INCREMENT,
    Movie_Title TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    Avg_Rating float(2),
    Genre TEXT,
    Tagline TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    Popularity FLOAT,
    Production_Company TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    Keywords TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    Poster TEXT,
    PRIMARY KEY (ID)
  );";

if ($connection->query($sql) === TRUE) {
    echo "MovieData table created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

$row = 1;
$count = 0;
$maxRows = 5000;

if (($handle = fopen("TMDB_movie_dataset_v11.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
        $count++;
        if ($count == 1) { 
            continue; 
        }

        if ($row > $maxRows) {
            break;
        }

        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
                $col[$c] = $data[$c];
        }

        $colTitle = $connection->real_escape_string($col[1]);
        $colRating = $connection->real_escape_string($col[2]);
        $colGenre = $col[19];
        $colTagline = $connection->real_escape_string($col[18]);
        $colPopularity = $col[16];
        $colProductionCompany = $connection->real_escape_string($col[20]);
        $colKeywords = $connection->real_escape_string($col[23]);
        $colPoster = $col[17];

        // SQL Query to insert data into DataBase
        $addData = "INSERT INTO MovieData(Movie_Title,Avg_Rating,Genre,Tagline,Popularity,Production_Company,Keywords,Poster) VALUES('".$colTitle."','".$colRating."','".$colGenre."','".$colTagline."','".$colPopularity."','".$colProductionCompany."','".$colKeywords."','".$colPoster."')";
        //check if data is added
        if ($connection->query($addData) === TRUE) {
            echo "Data added correctly";
        } else {
            echo "Error adding data: " . $connection->error;
        }
    }


    fclose($handle);
}

$connection->close();
?>