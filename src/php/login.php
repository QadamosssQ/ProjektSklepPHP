<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/login.css">
    <title>Title</title>
</head>
<body>

<div class="main">


    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#" method="POST">
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="name" required="required" />
                <input type="email" placeholder="Email" name="email" required="required" />
                <input type="password" placeholder="Password" name="password" required="required"/>
                <input class="btn_sign" type="submit" value="Sign Up" name="submit_sign_up" />

            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#" method="POST">
                <h1>Sign in</h1>
                <input type="email" placeholder="Email" name="email" required="required" />
                <input type="password" placeholder="Password" name="password" required="required" />
                <a href="#">Forgot your password?</a>
                <input class="btn_sign" type="submit" value="Sign In" name="submit_sign_in">

            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
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

require_once 'conn.php';

if (isset($_POST['submit_sign_up'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO users (name, login, password, sign_up_date) VALUES ('$name', '$email', '$password', '$date')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: ../php/panel.php");
    } else {
        error();

    }
}

if(isset($_POST['submit_sign_in'])){

    $email = $_POST['email'];


    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        echo "User logged in";
    } else {

        error();
    }
}

function error(){
    echo "<style> input {    border: solid 2px red; box-shadow: #FF4B2B 0 0 10px;}</style>";
    sleep(2);
    header("Location: ../php/login.php");
}