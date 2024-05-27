<?php

session_start();

try {
    $conn = mysqli_connect("localhost", "root", "", "sklep");
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Connection failed");
}

if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
    $show_username = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $show_username);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    $result_show_username = mysqli_stmt_get_result($stmt);
    $result_show_username = mysqli_fetch_array($result_show_username);
}

?>
