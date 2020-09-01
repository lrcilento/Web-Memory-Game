<?php
    include("auth_session.php");
    require('database.php');
    $moves = $_SESSION['moves'];
    $time = $_SESSION['time'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Leaderboards</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div id="main">
        <h1>Leaderboards</h1>
        <?php
            if($moves != null) {
            echo "<p>Last Score:</p>
                    <p>Time: " . $time . "s | Moves: " . $moves . " </p>";
            }
        ?>
        <p>Best Time:</p>
        <table><tr><td>Player</td><td>Time</td><td>Moves</td>
        <?php
            $i = 0;
            $query = "SELECT Highscores.time, Highscores.moves, Users.username
                        FROM Highscores INNER JOIN Users
                        ON (Highscores.user_id = Users.id)
                        ORDER BY time ASC, moves ASC";
            $result = mysqli_query($con,$query)
                        or die ("Error: ".mysqli_error($con));
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["username"] . "</td><td>" . $row["time"] . "s</td><td>" . $row["moves"] . "</td></tr>";
                    $i++;
                    if ($i >= 5) {
                        break;
                    }
                }
            } 

        ?>
        </table>
        <br>
        <p>Least Moves:</p>
        <table><tr><td>Player</td><td>Moves</td><td>Time</td>
        <?php
            $i = 0;
            $query = "SELECT Highscores.time, Highscores.moves, Users.username
                        FROM Highscores INNER JOIN Users
                        ON (Highscores.user_id = Users.id)
                        ORDER BY moves ASC, time ASC";
            $result = mysqli_query($con,$query)
                        or die ("Error: ".mysqli_error($con));
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["username"] . "</td><td>" . $row["moves"] . "</td><td>" . $row["time"] . "s</td></tr>";
                    $i++;
                    if ($i >= 5) {
                        break;
                    }
                }
            } 

        ?>
        </table>
        <br>
        <br>
        <button onclick="window.location.href='../index.php';">Continue Playing!</button>
        <br>
    </div>
</body>
</html>