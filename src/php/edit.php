<?php
global $conn;
require "conn.php";
if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

$query = "SELECT * FROM samoloty";

$result = mysqli_query($conn, $query);
?>








?>


<html lang="en">
<head>
    <link rel="stylesheet" href="../css/panel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>


<header class="p-3 text-bg-dark fixed-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../../index.php" class="nav-link px-2  text-white  ">Home</a></li>
                <li><a href="shop.php" class="nav-link px-2 text-white">Sklep</a></li>
                <li><a href="panel.php" class="nav-link px-2 text-secondary">Panel</a></li>
                <li><a href="cart.php" class="nav-link px-2 text-white">Cart</a></li>

            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" data-dashlane-rid="b0ad484f5a24ee6d" data-form-type="">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" data-dashlane-rid="08ac5c5fec0cede6" data-form-type="">
            </form>

            <div class="text-end">


                <?php
                if (isset($_SESSION["id"])) {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="logout.php">Logout</a> </button>';
                } else {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="login.php">Login</a> </button>';
                }

                $get_id = $_GET["id"];

                $query_to_edit = "SELECT * FROM samoloty WHERE id = $get_id";

                $result_edit = mysqli_query($conn, $query_to_edit);

                $row_edit = mysqli_fetch_assoc($result_edit);
                ?>






            </div>
            <p class="username">  <?php




                if(isset($result_show_username)){
                    echo $result_show_username["username"];
                }

                ?></p>
        </div>
    </div>
</header>

<div class="title">

    <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">

            <?php echo '<h1 class="text-center"> Edit ' .
                $row_edit["nazwa"] .
                "</h1>"; ?>

            <form method="post">

                <h3>Add product:</h3>

                <?php echo '

                <div class="mt-2 row p-2 bg-white border rounded">
                    <div class="col-md-3 mt-1">Img url:<input placeholder="' .
                    $row_edit["img_location"] .
                    '" class="inp"   type="text" name="n_img_localization"></div>
                    <div class="col-md-6 mt-1">
                        <h5>Nazwa: <input placeholder="' .
                    $row_edit["nazwa"] .
                    '"  class="inp"  type="text" name="n_name"><br> Model: <input placeholder="' .
                    $row_edit["model"] .
                    '"  class="inp"  type="text" name="n_model"></h5>

                        <div class="mt-1 mb-1 spec-1"><span><b>Typ: </b><input placeholder="' .
                    $row_edit["typ"] .
                    '"  class="inp"  type="text" name="n_type"></span><span class="dot"></span></div>
                        <div class="mt-1 mb-1 spec-1"><span><b>Naped: </b><input placeholder="' .
                    $row_edit["naped"] .
                    '"  class="inp"  type="text" name="n_naped"></span><span class="dot"></span></div>
                        <p class="text-justify text-wrapping para mb-0">Description: <textarea placeholder="' .
                    $row_edit["description"] .
                    '"  name="n_description" cols="40" rows="5" maxlength="200"></textarea><br><br></p>
                    </div>
                    <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                        <div class="d-flex flex-row align-items-center">
                            <h5 class="price_n mt-4  ">Price $ <input placeholder="' .
                    $row_edit["cena"] .
                    '"  class="inp" type="number" name="n_price"></h5>
                        </div>
                        <div class="d-flex flex-column mt-4"><input type="submit" name="n_submit" class="btn btn-dark btn-sm" value="Edit this product" ></div>




                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



'; ?>


                <?php if (isset($_POST["n_submit"])) {
                    $n_img_localization = $_POST["n_img_localization"];
                    $n_name = $_POST["n_name"];
                    $n_model = $_POST["n_model"];
                    $n_type = $_POST["n_type"];
                    $n_naped = $_POST["n_naped"];
                    $n_description = $_POST["n_description"];
                    $n_price = $_POST["n_price"];

                    if ($n_img_localization) {
                        $edit_img_location = "UPDATE samoloty SET img_location = '$n_img_localization' WHERE id = $get_id";
                        $edit_img_location_result = mysqli_query(
                            $conn,
                            $edit_img_location
                        );
                    }

                    if ($n_name) {
                        $edit_name = "UPDATE samoloty SET nazwa = '$n_name' WHERE id = $get_id";
                        $edit_name_result = mysqli_query(
                            $conn,
                            $edit_name
                        );
                    }

                    if ($n_model) {
                        $edit_model = "UPDATE samoloty SET model = '$n_model' WHERE id = $get_id";
                        $edit_model_result = mysqli_query(
                            $conn,
                            $edit_model
                        );
                    }

                    if ($n_type) {
                        $edit_type = "UPDATE samoloty SET typ = '$n_type' WHERE id = $get_id";
                        $edit_type_result = mysqli_query(
                            $conn,
                            $edit_type
                        );
                    }

                    if ($n_naped) {
                        $edit_naped = "UPDATE samoloty SET naped = '$n_naped' WHERE id = $get_id";
                        $edit_naped_result = mysqli_query(
                            $conn,
                            $edit_naped
                        );
                    }

                    if ($n_description) {
                        $edit_description = "UPDATE samoloty SET description = '$n_description' WHERE id = $get_id";
                        $edit_description_result = mysqli_query(
                            $conn,
                            $edit_description
                        );
                    }

                    if ($n_price) {
                        $edit_price = "UPDATE samoloty SET cena = '$n_price' WHERE id = $get_id";
                        $edit_price_result = mysqli_query(
                            $conn,
                            $edit_price
                        );
                    }

                    echo '<script>setTimeout(function(){window.location.href = "panel.php";}, 1);</script>';
                } ?>
















                <div class="container border-top mt-5">
                    <footer class="py-5">
                        <div class="row">
                            <div class="col-6 col-md-2 mb-3">
                                <h5>Section</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                                </ul>
                            </div>

                            <div class="col-6 col-md-2 mb-3">
                                <h5>Section</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                                </ul>
                            </div>

                            <div class="col-6 col-md-2 mb-3">
                                <h5>Section</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                                </ul>
                            </div>

                            <div class="col-md-5 offset-md-1 mb-3">
                                <form data-dashlane-rid="1fb5382e33c39873" data-form-type="newsletter">
                                    <h5>Subscribe to our newsletter</h5>
                                    <p>Monthly digest of what's new and exciting from us.</p>
                                    <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                                        <label for="newsletter1" class="visually-hidden">Email address</label>
                                        <input id="newsletter1" type="text" class="form-control" placeholder="Email address" data-dashlane-rid="3a8f59a54e38127f" data-form-type="email" data-kwimpalastatus="alive" data-kwimpalaid="1675159274093-0">
                                        <button class="btn btn-primary" type="button" data-dashlane-rid="8467e9ee5893e84b" data-dashlane-label="true" data-form-type="action,subscribe">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                            <p>© 2022 Company, Inc. All rights reserved.</p>
                            <ul class="list-unstyled d-flex">
                                <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                                <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                                <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
                            </ul>
                        </div>
                    </footer>
                </div>








</body>
</html>



