<?php
    include("auth_session.php");
    require('database.php');
    $moves = $_GET['moves'];
    $time = $_GET['time'];
    $username = $_SESSION["username"];
    $_SESSION["moves"] = $moves;
    $_SESSION["time"] = $time;
    $query = "SELECT id FROM Users WHERE username = '$username'";
    $result = mysqli_query($con,$query)
                or die ("Error: ".mysqli_error($con));
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $user_id = $row["id"];
        }
    }
    $query    = "INSERT INTO Highscores (moves, time, user_id)
                    VALUES ('$moves', '$time', '$user_id')";
    $result = mysqli_query($con,$query)
                or die ("Error: ".mysqli_error($con));
    header("Location: leaderboards.php");
    die();
?>