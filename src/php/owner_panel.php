<?php
global $conn;
require "conn.php";
if (empty($_SESSION["id"])) {
    header("Location: login.php");
}else if($_SESSION["id"] != 1){
    header("Location: shop.php");
}

if (!isset($_COOKIE["cart"])) {
    $cart = array();
    setcookie("cart", serialize($cart), time() + (86400 * 30), "/");
} else {
    $cart = unserialize($_COOKIE["cart"]);
}
?>


    <!DOCTYPE html>

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
    <div class="container border-top mt-5">
        <h3 class="content_h3 mt-5">Dodaj nowy samolot:</h3>
        <form action="addItemToShop.php" method="post">
            <div class="mb-3">
                <label for="nazwa" class="form-label">Nazwa</label>
                <input type="text" class="form-control" id="nazwa" name="nazwa" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="typ" class="form-label">Typ</label>
                <input type="text" class="form-control" id="typ" name="typ" required>
            </div>
            <div class="mb-3">
                <label for="naped" class="form-label">Napęd</label>
                <input type="text" class="form-control" id="naped" name="naped" required>
            </div>
            <div class="mb-3">
                <label for="cena" class="form-label">Cena</label>
                <input type="number" class="form-control" id="cena" name="cena" required>
            </div>
            <div class="mb-3">
                <label for="img_location" class="form-label">Lokalizacja obrazu</label>
                <input type="text" class="form-control" id="img_location" name="img_location" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Opis</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ilosc" class="form-label">Ilość</label>
                <input type="number" class="form-control" id="ilosc" name="ilosc" required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj samolot</button>
        </form>
    </div>


    <?php
    $order = "ASC";
    if (isset($_GET['order']) && ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC')) {
        $order = $_GET['order'];
    }

    // Fetch data from database with sorting using stored procedure
    $stmt = $conn->prepare("CALL GetSamolotySortedByPrice(?)");
    $stmt->bind_param("s", $order);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>

    <div class="container_card">
        <div class="container mt-5 mb-5">
            <div class="d-flex justify-content-center row">
                <div class="col-md-10">
                    <h3 id="invisible" class="invisible">Added</h3>

                    <!-- Sorting Dropdown -->
                    <div class="mb-3">
                        <form method="GET" action="shop.php">
                            <label for="sort">Sort by Price:</label>
                            <select id="sort" name="order" onchange="this.form.submit()">
                                <option value="ASC" <?php if ($order == 'ASC') echo 'selected'; ?>>Low to High</option>
                                <option value="DESC" <?php if ($order == 'DESC') echo 'selected'; ?>>High to Low</option>
                            </select>
                        </form>
                    </div>

                    <?php while ($wynik = mysqli_fetch_assoc($result)) : ?>
                        <div id="card_border" class="mt-2 row p-2">
                            <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="../img/<?php echo $wynik["img_location"]; ?>"></div>
                            <div class="col-md-6 mt-1">
                                <h5><?php echo $wynik["nazwa"] . " " . $wynik["model"]; ?></h5>
                                <div class="mt-1 mb-1 spec-1"><span><b>Typ: </b><?php echo $wynik["typ"]; ?></span><span class="dot"></span></div>
                                <div class="mt-1 mb-1 spec-1"><span><b>Naped: </b><?php echo $wynik["naped"]; ?></span><span class="dot"></span></div>
                                <p class="text-justify text-wrapping para mb-0"><b>Opis: </b><?php echo $wynik["description"]; ?><br><br></p>
                            </div>
                            <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                <div class="d-flex flex-row align-items-center">
                                    <h4 class="price_n mt-4">$<?php echo $wynik["cena"]; ?></h4>
                                </div>
                                <?php if ($wynik["ilosc"] <= 0) : ?>
                                    <h6 class="text-danger mt-3 ml-4">BRAK NA STANIE</h6>
                                <?php else : ?>
                                    <h6 class="text-success mt-3">Dostępne: <?php echo $wynik["ilosc"]; ?></h6>
                                <?php endif; ?>
                                <div class="d-flex flex-column mt-4">
                                    <button class="btn btn-outline-dark btn-sm mt-2" type="button">
                                        <a onclick="removeProduct(<?php echo $wynik["id"]; ?>)" style="text-decoration: none;">Usuń</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeProduct(productId) {
            if (confirm("Are you sure you want to remove this product?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xhttp.open("GET", "removeProduct.php?id=" + productId, true);
                xhttp.send();
            }
        }
    </script>

    <?php
    require_once "footer.php";
?>


</body>
</Docty>';

