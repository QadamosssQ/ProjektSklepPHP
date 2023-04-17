<?php
global $conn;
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
        <script src="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.js"></script>


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
        <h1 class=" border-bottom text-center">Owner Panel</h1>
    </div>
    </div>
</div>

    <div class="diagram">

    <table class="charts-css line" id="my-chart">

        <tbody>
        <tr>
            <td style="--start: 0.0; --size: 0.4"> <span class="data"> $ 40K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.4; --size: 0.2"> <span class="data"> $ 20K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.2; --size: 0.6"> <span class="data"> $ 60K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.6; --size: 0.4"> <span class="data"> $ 40K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.4; --size: 0.8"> <span class="data"> $ 80K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.8; --size: 0.6"> <span class="data"> $ 60K </span> </td>
        </tr>
        <tr>
            <td style="--start: 0.6; --size: 1.0"> <span class="data"> $ 100K </span> </td>
        </tr>
        </tbody>

    </table>


    </div>



    <div class="container border-top mt-5">
        <h3 class="content_h3 mt-5 ">Products worth:</h3>
        <h3 class="content_h3  "><?php
            $sql = "SELECT SUM(cena*ilosc) as number FROM samoloty;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['number'];
                }
            }
            ?>
        $</h3>
    </div>

    <div class="container border-top mt-5">
        <h3 class="content_h3 mt-5 ">Products:</h3>
        <table>
            <tr>
                <td>Nazwa</td>
                <td>Cena</td>
                <td>Ilość</td>

            </tr>


                    <?php

            $sql = "SELECT * FROM samoloty;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            while ($row = mysqli_fetch_assoc($result)) {
                echo' <tr><td>  '.$row["nazwa"].' </td>
                <td>  '.$row["cena"].'</td>
                <td>  '.$row["ilosc"].'</td></tr>';
            }

            ?>

        </table>
    </div>

    <div class="container border-top mt-5">
        <h3 class="content_h3 mt-5 ">Users:</h3>
        <h3 class="content_h3  ">            <?php
            $sql = "SELECT COUNT(*) as number FROM users;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['number'];
                }
            }
            ?></h3>
    </div>












    <div class="diagrams">

    </div>



<?php
    require_once "footer.php";
?>




</body>
</html>';

