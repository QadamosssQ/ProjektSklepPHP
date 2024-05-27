<?php
require "conn.php";
if($_SESSION['id'] != 1) {
    header("Location: panel.php");
    exit();
}

if (empty($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST["nazwa"];
    $model = $_POST["model"];
    $typ = $_POST["typ"];
    $naped = $_POST["naped"];
    $cena = $_POST["cena"];
    $img_location = $_POST["img_location"];
    $description = $_POST["description"];
    $ilosc = $_POST["ilosc"];

    $nazwa = mysqli_real_escape_string($conn, $nazwa);
    $model = mysqli_real_escape_string($conn, $model);
    $typ = mysqli_real_escape_string($conn, $typ);
    $naped = mysqli_real_escape_string($conn, $naped);
    $cena = mysqli_real_escape_string($conn, $cena);
    $img_location = mysqli_real_escape_string($conn, $img_location);
    $description = mysqli_real_escape_string($conn, $description);
    $ilosc = mysqli_real_escape_string($conn, $ilosc);

    $sql = "INSERT INTO samoloty (nazwa, model, typ, naped, cena, img_location, description, ilosc)
            VALUES ('$nazwa', '$model', '$typ', '$naped', '$cena', '$img_location', '$description', '$ilosc')";
    if (mysqli_query($conn, $sql)) {
        header("Location: shop.php");
    } else {
        echo "Błąd: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
