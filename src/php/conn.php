<?php

$conn = mysqli_connect("localhost", "root", "", "sklep");

session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
