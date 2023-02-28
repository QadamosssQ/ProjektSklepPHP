<?php


$show_username = "SELECT * FROM users WHERE id = '" . $_SESSION["id"] . "'";

$result_show_username = mysqli_query($conn, $show_username);

$result_show_username = mysqli_fetch_array($result_show_username);

echo $result_show_username["username"];

?>