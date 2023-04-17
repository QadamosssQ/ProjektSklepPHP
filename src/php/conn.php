<?php

session_start();

try {
    $conn = mysqli_connect("localhost", "root", "", "sklep");
    if (!$conn) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Connection failed");
}

if(!$_SESSION == null) {
    $show_username = "SELECT * FROM users WHERE id = '" . $_SESSION["id"] . "'";
    $result_show_username = mysqli_query($conn, $show_username);
    $result_show_username = mysqli_fetch_array($result_show_username);
}

?>
