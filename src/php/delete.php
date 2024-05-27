<?php

session_start();

global $conn;
require "conn.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    error();
}

$to_delete = $_GET["id"];
$query = "DELETE FROM samoloty WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $to_delete);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    header("Location: ../php/panel.php");
    exit();
} else {
    error();
}

function error() {
    header("Location: error.php");
    exit();
}
