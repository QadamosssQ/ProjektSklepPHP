<?php

require "conn.php";
if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
$query = "SELECT * FROM samoloty";

$result = mysqli_query($conn, $query);


$total_prices = 0;


?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cart.css">
    <title>Sklep </title>
</head>

<body>

<header class="p-3 text-bg-dark fixed-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../../index.php" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="../php/shop.php" class="nav-link px-2 text-white">Sklep</a></li>
                <li><a href="../php/panel.php" class="nav-link px-2 text-white">Panel</a></li>
                <li><a href="../php/cart.php" class="nav-link px-2 text-secondary">Cart</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" data-dashlane-rid="08ac5c5fec0cede6" data-form-type="">
            </form>

            <div class="text-end">



                <?php



                if(empty($_SESSION["id"])) {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="src/php/login.php">Login</a> </button>';
                }else{
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="src/php/logout.php">Logout</a> </button>';
                }


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




<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-lg-7">
                                <h5 class="mb-3">Shopping cart</h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>

                                        <a href="#!" class="text-body"><i
                                                    class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a>

                                    </div>

                                </div>




<!--//--------------------------------------------------------------------------------------------------------->



                                <div class="container">
                                    <table class="table my-3">
                                        <a href="empty_cart.php" class="btn btn-sm btn-danger mt-2">Empty Cart</a>
                                        <thead>
                                        <tr class="text-center">
                                            <th>Num</th>
                                            <th>Product Name</th>
                                            <th>Count</th>

                                            <th colspan="2">Action</th>
                                            <th>Price</th>


                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php





                                        if (isset($_SESSION['cart'])) :
                                            $i = 1;








                                            foreach ($_SESSION['cart'] as $cart) :
                                                ?>
                                                <tr class="text-center">
                                                    <td><?php echo $i; ?> # </td>
                                                    <td><?php
                                                        $show_product_name = "SELECT * FROM samoloty WHERE id = '$cart[pro_id]'";
                                                        $cart_wynik = mysqli_query($conn, $show_product_name);

                                                        $product_name = mysqli_fetch_assoc($cart_wynik);

                                                        echo $product_name["nazwa"];
                                                        echo ",";
                                                        echo $product_name["model"];

                                                        ;?></td>
                                                    <td>
                                                        <form action="update.php" method="post">
                                                            <input type="number" value="<?= $cart['qty']; ?>" name="qty" min="1">
                                                            <input type="hidden" name="upid" value="<?= $cart['pro_id']; ?>">
                                                    </td>
                                                    <td>
                                                        <input type="submit" name="update" value="Update" class="btn btn-sm btn-warning">
                                                        </form>
                                                    </td>
                                                    <td><a class="btn btn-sm btn-danger" href="remove_cart_item.php?id=<?= $cart['pro_id']; ?>">Remove</a></td>
                                                    <td><?php echo  $cart['qty']*$product_name["cena"]."$";
                                                            $total_prices = $total_prices + ($cart['qty']*$product_name["cena"]);
                                                        ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            endforeach;
                                        endif;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php





//                                echo '<div class="card mb-3">
//                                    <div class="card-body">
//                                        <div class="d-flex justify-content-between">
//                                            <div class="d-flex flex-row align-items-center">
//                                                <div>
//                                                    <img
//                                                            src="../img/sample.jpg"
//                                                            class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
//                                                </div>
//                                                <div class="ms-3">
//                                                    <h5>Cessna 152</h5>
//                                                    <p class="small mb-0">Type: solo, Drive: propeller  </p>
//                                                </div>
//                                            </div>
//                                            <div class="d-flex flex-row align-items-center">
//
//                                                <div style="width: 80px;">
//                                                    <h5 class="mb-0">$8 000</h5>
//                                                </div>
//                                                <a href="#!" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
//                                            </div>
//                                        </div>
//                                    </div>
//                                </div>';


?>
<!--//--------------------------------------------------------------------------------------------------------->





                            </div>
                            <div class="col-lg-5">

                                <div class="card bg-primary text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">Card details</h5>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"
                                                 class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">
                                        </div>

                                        <p class="small mb-2">Card type</p>
                                        <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-visa fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-amex fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-paypal fa-2x"></i></a>

                                        <form class="mt-4">
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeName" class="form-control form-control-lg" siez="17"
                                                       placeholder="Cardholder's Name" />
                                                <label class="form-label" for="typeName">Cardholder's Name</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeText" class="form-control form-control-lg" siez="17"
                                                       placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                                                <label class="form-label" for="typeText">Card Number</label>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="text" id="typeExp" class="form-control form-control-lg"
                                                               placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                                                        <label class="form-label" for="typeExp">Expiration</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="password" id="typeText" class="form-control form-control-lg"
                                                                size="1" minlength="3" maxlength="3" />
                                                        <label class="form-label" for="typeText">Cvv</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                        <hr class="my-4">

<!--                                        <div class="d-flex justify-content-between">-->
<!--                                            <p class="mb-2">Subtotal</p>-->
<!--                                            <p class="mb-2">$4798.00</p>-->
<!--                                        </div>-->


                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2">Shipping</p>
                                            <p class="mb-2">Free</p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-2">Total(Incl. taxes)</p>
                                            <p class="mb-2">  <?php

                                                echo $total_prices."$"."<br>";
                                                ?></p>
                                        </div>

                                        <button type="button" class="btn btn-info btn-block btn-lg">
                                            <div class="d-flex justify-content-between">
                                                <span>  <?php

                                                    echo $total_prices."$"."<br>";
                                                    ?></span>
                                                <span> Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




</body>
</html>
