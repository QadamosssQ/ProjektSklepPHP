<?php

$conn = mysqli_connect('localhost', 'root', '', 'sklep');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}