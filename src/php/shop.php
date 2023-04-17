<?php

global $conn;
require "conn.php";

$query = "SELECT * FROM samoloty";

$result = mysqli_query($conn, $query);



// Check if product is coming or not
if (isset($_GET['pro_id'])) {

    $proid = $_GET['pro_id'];

    // If session cart is not empty
    if (!empty($_SESSION['cart'])) {

        // Using "array_column() function" we get the product id existing in session cart array
        $acol = array_column($_SESSION['cart'], 'pro_id');

        // now we compare whther id already exist with "in_array() function"
        if (in_array($proid, $acol)) {

            // Updating quantity if item already exist
            $_SESSION['cart'][$proid]['qty'] += 1;
        } else {
            // If item doesn't exist in session cart array, we add a new item
            $item = [
                'pro_id' => $_GET['pro_id'],
                'qty' => 1
            ];

            $_SESSION['cart'][$proid] = $item;
        }
    } else {
        // If cart is completely empty, then store item in session cart
        $item = [
            'pro_id' => $_GET['pro_id'],
            'qty' => 1
        ];

        $_SESSION['cart'][$proid] = $item;
    }
}
?>


<html lang="en">
<head>
    <link rel="stylesheet" href="../css/shop.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../js/shop.js"></script>

    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>


<header class="p-3 text-bg-dark fixed-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../../index.php" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="" class="nav-link px-2 text-secondary">Sklep</a></li>
                <li><a href="panel.php" class="nav-link px-2 text-white">Panel</a></li>
                <li><a href="cart.php" class="nav-link px-2 text-white">Cart</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" data-dashlane-rid="b0ad484f5a24ee6d" data-form-type="">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">



                <?php if (empty($_SESSION["id"])) {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="login.php">Login</a> </button>';
                } else {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a onclick="added()" class="login_button" href="logout.php">Logout</a> </button>';
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


<div class="container_card">
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10">




                <?php while ($wynik = mysqli_fetch_assoc($result)) {
                    echo '
                       <div id="card_border" class="mt-2 row p-2  ">
                <div class="col-md-3 mt-1 "><img class="img-fluid img-responsive rounded product-image" src="../img/' .
                        $wynik["img_location"] .
                        '"></div>
                <div class="col-md-6 mt-1">
                    <h5>' .
                        $wynik["nazwa"] .
                        " " .
                        $wynik["model"] .
                        '</h5>
   
                    <div class="mt-1 mb-1 spec-1"><span><b>Typ: </b>' .
                        $wynik["typ"] .
                        '</span><span class="dot"></span></div>
                    <div class="mt-1 mb-1 spec-1"><span><b>Naped: </b>' .
                        $wynik["naped"] .
                        '</span><span class="dot"></span></div>
                    <p class="text-justify text-wrapping para mb-0">' .
                        $wynik["description"] .
                        '<br><br></p>
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row align-items-center">
                        <h4 class="price_n mt-4  ">$' .
                        $wynik["cena"] .
                        '</h4>
                    </div>
                    <h6 class="text-success mt-3">Free shipping</h6>
                    
                    <div class="d-flex flex-column mt-4"><button id="whow_page"  class="btn btn-primary btn-sm" type="button">Details</button>
                    <button class="btn btn-outline-dark btn-sm mt-2" type="button"><a onclick="add()" style="text-decoration: none" href="shop.php?pro_id='.$wynik["id"].'">Add to cart</a> </button></div>
                    <h3 id="invisible" class="invisible">Added</h3>
                </div>
            </div>


                
                ';





                } ?>




            </div>
        </div>
    </div>


</div>

<?php

require_once "footer.php";
?>

</body>
</html>

