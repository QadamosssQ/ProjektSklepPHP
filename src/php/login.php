<?php
global $conn;
require_once "conn.php"; ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/login.css">
        <title>Title</title>
    </head>
    <body>



    <header class="p-3 text-bg-dark fixed-top">
        <div class="containe">
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



                <div class="text-end">









                </div>
            </div>
        </div>
    </header>




    <div class="main">


        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form  method="POST">
                    <h1 class="neon">Create Account</h1>
                    <input type="text" placeholder="Name" name="name" required="required" />
                    <input id="email" type="email" placeholder="Email" name="email" required="required" />
                    <input type="password" placeholder="Password" name="password" required="required"/>
                    <input class="btn_sign" type="submit" value="Sign Up" name="submit_sign_up" />

                </form>
            </div>
            <div class="form-container sign-in-container">
                <form  method="POST">
                    <h1 class="neon">Log in</h1>
                    <h2 id="error_show2" class="no_show">Wrong data</h2>

                    <input type="email" placeholder="Email" name="email_login" required="required" />
                    <input type="password" placeholder="Password" name="password_login" required="required" />
                    <a class="a_log" href="#">Forgot your password?</a>
                    <input class="btn_sign" type="submit" value="Log In" name="submit_sign_in">

                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Log In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>


        <footer>
            <p>
                Do you want  <i class="fa fa-heart"></i>
                <a target="_blank" href="https://florin-pop.com">newsteller</a>
                - be up to date with the latest news?
                <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
            </p>
        </footer>
    </div>

    <script src="../js/login.js"></script>
    </body>
    </html>


<?php
if (isset($_POST["submit_sign_up"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $date = date("Y-m-d H:i:s");

    validate_name($name);
    validate_email($email);
    validate_password($password);

    if (validate_name($name) != true) {
        show_error_name();
    } elseif (validate_email($email) != true) {
        show_error_mail();
    } elseif (validate_password($password) != true) {
        show_error_password();
    } else {

        $query_check_if_exist = "SELECT * FROM users WHERE login = '$email'";
        $result = mysqli_query($conn, $query_check_if_exist);

        if (mysqli_num_rows($result) > 0) {
            user_exist_error();
        } else {
            // hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, login, password, sign_up_date) VALUES ('$name', '$email', '$hashed_password', '$date')";
            $result_insert = mysqli_query($conn, $query);

            if ($result_insert) {
                $query_l = "SELECT id FROM users WHERE login = '$email' AND password = '$hashed_password'";
                $result = mysqli_query($conn, $query_l);
                $final = mysqli_fetch_array($result);
                $_SESSION["id"] = $final["id"];

                echo '<script>setTimeout(function(){window.location.href = "panel.php";}, 1);</script>';
            }
        }
    }
}

//login ----------------------------------------------------------------------------------------------------------------

if (isset($_POST["submit_sign_in"])) {
    $email_login = $_POST["email_login"];
    $password_login = $_POST["password_login"];

    if (validate_email($email_login) != true) {
        show_error_mail();
    } else {
        $query_login = "SELECT id, password FROM users WHERE login = '$email_login'";

        $result_login = mysqli_query($conn, $query_login);

        // check if user exists

        if (mysqli_num_rows($result_login) > 0) {
            $final2 = mysqli_fetch_array($result_login);
            $hashed_password = $final2["password"];

            // verify password
            if (password_verify($password_login, $hashed_password)) {
                $_SESSION["id"] = $final2["id"];
                echo '<script>setTimeout(function(){window.location.href = "panel.php";}, 1);</script>';
            } else {
                wrong_password_login();
            }
        } else {
            wrong_password_login();
        }
    }
}


function wrong_password_login()
{
    echo '<script>

    
                                document.getElementById("error_show2").classList.remove("no_show");
                                document.getElementById("error_show2").classList.add("exist2"); 
                                
                                setTimeout(function(){ document.getElementById("error_show2").classList.add("no_show");}, 3000);
                                
                                
            </script>';
}

function error()
{
    //    header("Location: ../php/login.php");
    echo "error z error";
}

function validate_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //        echo "<h3 class='h3_error'>Only normal email</h3>";
        return false;
    } else {
        return true;
    }
}

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
        //        echo "<h3 class='h3_error'>Password: 8 characters length, big letter , number,  special char.</h3>";
        return false;
    } else {
        return true;
    }
}

function validate_name($name)
{
    if (!preg_match("/^[a-zA-Z]*$/", $name)) {
        //        echo "<h3 class='h3_error'>Only lettes!</h3>";
        return false;
    } else {
        return true;
    }
}

function show_error_mail()
{
    echo "<h3 id='error_show_mail' class='no_show'>Wrong email!</h3>";

    echo '<script>

                            document.getElementById("error_show_mail").classList.remove("no_show");
                            document.getElementById("error_show_mail").classList.add("h3_error");



                            setTimeout(function(){ document.getElementById("error_show_mail").classList.add("no_show");}, 3000);</script>';
}

function show_error_name()
{
    echo "<h3 id='error_show_name' class='no_show'>Only lettes in name!</h3>";

    echo '<script>

                            document.getElementById("error_show_name").classList.remove("no_show");
                            document.getElementById("error_show_name").classList.add("h3_error");



                            setTimeout(function(){ document.getElementById("error_show_name").classList.add("no_show");}, 3000);</script>';
}

function show_error_password()
{
    echo "<h3 id='error_show_password' class='no_show'>Password: 8 chars, number, special, one uppercase</h3>";

    echo '<script>

                            document.getElementById("error_show_password").classList.remove("no_show");
                            document.getElementById("error_show_password").classList.add("h3_error");
                            
                            setTimeout(function(){ document.getElementById("error_show_password").classList.add("no_show");}, 3000);</script>';
}

function user_exist_error()
{
    echo "<h3 id='error_show_exist' class='no_show'>User exist!</h3>";

    echo '<script>

                            document.getElementById("error_show_exist").classList.remove("no_show");
                            document.getElementById("error_show_exist").classList.add("h3_error");
                            
                            setTimeout(function(){ document.getElementById("error_show_exist").classList.add("no_show");}, 3000);</script>';
}

