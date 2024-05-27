<?php
global $conn;
require_once "conn.php";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
}
?>

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

    if (!validate_name($name)) {
        show_error_name();
    } elseif (!validate_email($email)) {
        show_error_mail();
    } elseif (!validate_password($password)) {
        show_error_password();
    } else {
        $query_check_if_exist = $conn->prepare("SELECT * FROM users WHERE login = ?");
        $query_check_if_exist->bind_param("s", $email);
        $query_check_if_exist->execute();
        $result = $query_check_if_exist->get_result();

        if ($result->num_rows > 0) {
            user_exist_error();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, login, password, sign_up_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $date);
            if ($stmt->execute()) {
                $query_l = $conn->prepare("SELECT id FROM users WHERE login = ?");
                $query_l->bind_param("s", $email);
                $query_l->execute();
                $result = $query_l->get_result();
                $final = $result->fetch_assoc();
                $_SESSION["id"] = $final["id"];
                echo '<script>setTimeout(function(){window.location.href = "panel.php";}, 1);</script>';
            } else {
                error();
            }
        }
    }
}

//login ----------------------------------------------------------------------------------------------------------------

if (isset($_POST["submit_sign_in"])) {
    $email_login = $_POST["email_login"];
    $password_login = $_POST["password_login"];

    if (!validate_email($email_login)) {
        show_error_mail();
    } else {
        $query_login = $conn->prepare("SELECT id, password FROM users WHERE login = ?");
        $query_login->bind_param("s", $email_login);
        $query_login->execute();
        $result_login = $query_login->get_result();

        if ($result_login->num_rows > 0) {
            $final2 = $result_login->fetch_assoc();
            $hashed_password = $final2["password"];
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

function wrong_password_login() {
    echo '<script>
            document.getElementById("error_show2").classList.remove("no_show");
            document.getElementById("error_show2").classList.add("exist2");            
            setTimeout(function(){ document.getElementById("error_show2").classList.add("no_show");}, 3000);        
          </script>';
}

function error() {
    echo "An error occurred. Please try again later.";
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    $uppercase = preg_match("@[A-Z]@", $password);
    $lowercase = preg_match("@[a-z]@", $password);
    $number = preg_match("@[0-9]@", $password);
    $specialChars = preg_match("@[^\w]@", $password);

    return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
}

function validate_name($name)
{
    return preg_match("/^[a-zA-Z]*$/", $name);
}

function show_error_mail() {
    echo "<h3 id='error_show_mail' class='no_show'>Wrong email!</h3>";
    echo '<script>
document.getElementById("error_show_mail").classList.remove("no_show");
document.getElementById("error_show_mail").classList.add("h3_error");
setTimeout(function(){ document.getElementById("error_show_mail").classList.add("no_show");}, 3000);
</script>';
}

function show_error_name() {
    echo "<h3 id='error_show_name' class='no_show'>Only letters in the name!</h3>";
    echo '<script>
document.getElementById("error_show_name").classList.remove("no_show");
document.getElementById("error_show_name").classList.add("h3_error");
setTimeout(function(){ document.getElementById("error_show_name").classList.add("no_show");}, 3000);
</script>';
}

function show_error_password() {
    echo "<h3 id='error_show_password' class='no_show'>Password should contain at least 8 characters, including uppercase, lowercase, numbers, and special characters.</h3>";
    echo '<script>
document.getElementById("error_show_password").classList.remove("no_show");
document.getElementById("error_show_password").classList.add("h3_error");
setTimeout(function(){ document.getElementById("error_show_password").classList.add("no_show");}, 3000);
</script>';
}

function user_exist_error() {
    echo "<h3 id='error_show_exist' class='no_show'>User already exists!</h3>";
    echo '<script>
document.getElementById("error_show_exist").classList.remove("no_show");
document.getElementById("error_show_exist").classList.add("h3_error");
setTimeout(function(){ document.getElementById("error_show_exist").classList.add("no_show");}, 3000);
</script>';
}
?>