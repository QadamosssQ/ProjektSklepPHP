<?php
require "conn.php";
if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

//set cookie cart with array of products
if (!isset($_COOKIE["cart"])) {
    $cart = array();
    setcookie("cart", serialize($cart), time() + (86400 * 30), "/");
} else {
    $cart = unserialize($_COOKIE["cart"]);
}
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
                <li><a href="#" class="nav-link px-2 text-secondary">Panel</a></li>
                <li><a href="cart.php" class="nav-link px-2 text-white">Cart</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" data-dashlane-rid="b0ad484f5a24ee6d" data-form-type="">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" data-dashlane-rid="08ac5c5fec0cede6" data-form-type="">
            </form>

            <div class="text-end">


                <?php if (isset($_SESSION["id"])) {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="logout.php">Logout</a> </button>';
                } else {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="login.php">Login</a> </button>';
                } ?>






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
            <h1 class=" border-bottom text-center">Hi

                <?php

                if(isset($result_show_username)){
                    echo $result_show_username["username"];
                }

                ?>

            </h1>

            <h3 id="to_remove" class="no_show">Product added</h3>



            <h3 class="content_h3">Change your name here:</h3>





            <?php
            $query2 =
                "SELECT * FROM users WHERE id = '" . $_SESSION["id"] . "'";

            $result2 = mysqli_query($conn, $query2);

            $row2 = mysqli_fetch_array($result2);

            echo '<form method="post">';
            echo '<input type="text" class="form-control" name="username" placeholder="' .
                $row2["username"] .
                '">

                <h3 id="error_show_name" class="no_show">Only lettes in name!</h3>

                <div class="submit_container">

                    <input type="submit" name="submit_username" class="btn btn-primary mt-3" value="Change">

                </div>
                
                ';

            echo '<h3 class="content_h3">Change your password:</h3>';
            echo '<input type="text" class="form-control" name="password" placeholder="' .
                $row2["password"] .
                '">';

            echo '
                <h3 id="error_show_password" class="no_show">Password: 8 chars, number, special, one uppercase</h3>

                <div class="submit_container">

                <input type="submit" name="submit_password" class="btn btn-primary mt-3" value="Change">

                </div>
                


            </form>';

            if (isset($_POST["submit_username"])) {
                $edit_username = $_POST["username"];

                validate_name($edit_username);

                if (validate_name($edit_username) == false) {
                    show_error_name();
                } else {
                    $query_edit_username =
                        "UPDATE users SET username = '$edit_username' WHERE id = '" .
                        $_SESSION["id"] .
                        "'";
                    $result_edit_username = mysqli_query(
                        $conn,
                        $query_edit_username
                    );
                    header("Location: panel.php");
                }
            }

            if (isset($_POST["submit_password"])) {
                $edit_password = $_POST["password"];

                validate_password($edit_password);

                if (validate_password($edit_password) == false) {
                    show_error_password();
                } else {
                    $query_edit_password =
                        "UPDATE users SET password = '$edit_password' WHERE id = '" .
                        $_SESSION["id"] .
                        "'";
                    $result_edit_password = mysqli_query(
                        $conn,
                        $query_edit_password
                    );
                    header("Location: panel.php");
                }
            }
            ?>




















            <?php
            $query_if_admin = "SELECT * FROM users WHERE login = 'admin@admin.admin'";

            $result_if_admin = mysqli_query($conn, $query_if_admin);

            if ($ok_admmin = mysqli_fetch_array($result_if_admin)) {



                echo '
                
                
                
                
                
                
            <h3 class="  mt-5 content_h3">Change or add products:</h3>



            <h3>Add product:</h3>

            <form method="post">

                <div class="mt-2 row p-2 bg-white border rounded">
                    <div class="col-md-3 mt-1">Img url:<input class="inp" required="required"  type="text" name="n_img_localization"></div>
                    <div class="col-md-6 mt-1">
                        <h5>Nazwa: <input required="required" class="inp"  type="text" name="n_name"><br> Model: <input required="required" class="inp"  type="text" name="n_model"></h5>

                        <div class="mt-1 mb-1 spec-1"><span><b>Typ: </b><input required="required" class="inp"  type="text" name="n_type"></span><span class="dot"></span></div>
                        <div class="mt-1 mb-1 spec-1"><span><b>Naped: </b><input required="required" class="inp"  type="text" name="n_naped"></span><span class="dot"></span></div>
                        <p class="text-justify text-wrapping para mb-0">Description: <textarea required="required" name="n_description" cols="40" rows="5" maxlength="200"></textarea><br><br></p>
                    </div>
                    <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                        <div class="d-flex flex-row align-items-center">
                            <h5 class="price_n mt-4  ">Price $ <input required="required" class="inp" type="number" name="n_price"></h5>
                        </div>
                        <div class="d-flex flex-column mt-4"><input type="submit" name="n_submit" class="btn btn-dark btn-sm" value="Add new product" ></div>



                
                
                
                
                
                
                
                
                ';





                if (isset($_POST["n_submit"])) {
                    $n_img_localization = $_POST["n_img_localization"];
                    $n_name = $_POST["n_name"];
                    $n_model = $_POST["n_model"];
                    $n_type = $_POST["n_type"];
                    $n_naped = $_POST["n_naped"];
                    $n_description = $_POST["n_description"];
                    $n_price = $_POST["n_price"];

                    $add_query = "INSERT INTO `samoloty` (`img_location`, `nazwa`, `model`, `typ`, `naped`, `description`, `cena`) VALUES ('$n_img_localization', '$n_name', '$n_model', '$n_type', '$n_naped', '$n_description', '$n_price');";

                    $add_result = mysqli_query($conn, $add_query);

                    if ($add_result) {
                        echo "<script type='text/javascript'>
                                    $(window).load(function() {
                                    $('html, body').animate({ scrollTop: $('#cuar_reply_0').offset().top }, 1000);
                                     });
                                </script>";

                        echo '<script>

                            document.getElementById("to_remove").classList.remove("no_show");
                            document.getElementById("to_remove").classList.add("content_h3_success");



                            setTimeout(function(){document.getElementById("to_remove").classList.add("no_show");}, 3000);</script>';

                        echo '<script>setTimeout(function(){window.location.href = "panel.php";}, 3000);</script>';
                    } else {
                        echo '<script>alert("Product not added")</script>';
                    }
                }





                echo'
                

                    </div>
                </div>


            </form>















            <h3 class="content_h3 mt-10 ">Edit products</h3>

            <table>
                <tr class="product">
                    <td>Nazwa</td>
                    <td>Model</td>
                    <td>Typ</td>
                    <td>Naped</td>
                    <td>Cena</td>
                    <td>Edytuj</td>
                    <td>Usuń</td>

                </tr>
                ';

                $query_table = "SELECT * FROM samoloty";

                $result_table = mysqli_query($conn, $query_table);

                while ($final_table = mysqli_fetch_assoc($result_table)) {
                    echo '<tr class="product">';
                    echo "<td>" . $final_table["nazwa"] . "</td>";
                    echo "<td>" . $final_table["model"] . "</td>";
                    echo "<td>" . $final_table["typ"] . "</td>";
                    echo "<td>" . $final_table["naped"] . "</td>";
                    echo "<td>" . $final_table["cena"] . "</td>";
                    echo '<td><button type="button" class="btn btn-success"><a class="link_de" href="edit.php?id=' .
                        $final_table["id"] .
                        '">Edytuj</a></button></td>';
                    echo '<td><button type="button" class="btn btn-danger"><a class="link_de" href="delete.php?id=' .
                        $final_table["id"] .
                        '">Usuń</a></button></td>';
                    echo "</tr>";
                }


                echo '            

            <table>
            <h3 class="content_h3 mt-10 ">Edit users</h3>
                <tr class="product">
                    <td>Username</td>
                    <td>Login</td>
                    <td>Password</td>
                    <td>Sign up date</td>
                    <td>Edytuj</td>
                    <td>Usuń</td>
    

                </tr>';



                $query_table = "SELECT * FROM users";

                $result_table = mysqli_query($conn, $query_table);

                while ($final_table = mysqli_fetch_assoc($result_table)) {
                    echo '<tr class="product">';
                    echo "<td>" . $final_table["username"] . "</td>";
                    echo "<td>" . $final_table["login"] . "</td>";
                    echo "<td>" . $final_table["password"] . "</td>";
                    echo "<td>" . $final_table["sign_up_date"] . "</td>";

                    echo '<td><button type="button" class="btn btn-success"><a class="link_de" href="edit.php?id=' .
                        $final_table["id"] .
                        '">Edytuj</a></button></td>';
                    echo '<td><button type="button" class="btn btn-danger"><a class="link_de" href="delete_user.php?id=' .
                        $final_table["id"] .
                        '">Usuń</a></button></td>';
                    echo "</tr>";
                }







            }
            ?>
















                <?php


                function validate_password($password)
                {
                    $uppercase = preg_match("@[A-Z]@", $password);
                    $lowercase = preg_match("@[a-z]@", $password);
                    $number = preg_match("@[0-9]@", $password);
                    $specialChars = preg_match("@[^\w]@", $password);

                    if (
                        !$uppercase ||
                        !$lowercase ||
                        !$number ||
                        !$specialChars ||
                        strlen($password) < 8
                    ) {
                        return false;
                    } else {
                        return true;
                    }
                }

                function validate_name($name)
                {
                    if (!preg_match("/^[a-zA-Z]*$/", $name)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                function show_error_name()
                {
                    echo '<script>

                            document.getElementById("error_show_name").classList.remove("no_show");
                            document.getElementById("error_show_name").classList.add("h3_error");



                            setTimeout(function(){ document.getElementById("error_show_name").classList.add("no_show");}, 3000);</script>';
                }

                function show_error_password()
                {
                    echo '<script>

                            document.getElementById("error_show_password").classList.remove("no_show");
                            document.getElementById("error_show_password").classList.add("h3_error");
                            
                            setTimeout(function(){ document.getElementById("error_show_password").classList.add("no_show");}, 3000);</script>';
                }



echo'
            </table>








        </div>
    </div>
</div>



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
                    <p>Monthly digest of whats new and exciting from us.</p>
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
</html>';

