<?php

global $conn;
require "conn.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

$to_delete = $_GET["id"];
$query = "DELETE FROM users WHERE id = $to_delete";
$result = mysqli_query($conn, $query);
if ($result) {
    header("Location: ../php/panel.php");
} else {
    error();
}
