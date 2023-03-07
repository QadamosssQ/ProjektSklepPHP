<?php

$conn = mysqli_connect("localhost", "root", "", "sklep");

session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



if(!$_SESSION == null) {



    $show_username = "SELECT * FROM users WHERE id = '" . $_SESSION["id"] . "'";

    $result_show_username = mysqli_query($conn, $show_username);

    $result_show_username = mysqli_fetch_array($result_show_username);

}



