<?php
session_start();

global $conn;
require_once "conn.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Generowanie tokena CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

mysqli_begin_transaction($conn);

try {
    $query = "SELECT * FROM samoloty";
    $result = mysqli_query($conn, $query);

    $total_prices = 0;

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart) {
            $pro_id = (int)$cart['pro_id'];
            $qty = (int)$cart['qty'];

            $stmt = mysqli_prepare($conn, "SELECT ilosc, cena FROM samoloty WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $pro_id);
            mysqli_stmt_execute($stmt);
            $result_product = mysqli_stmt_get_result($stmt);
            $product_info = mysqli_fetch_assoc($result_product);
            mysqli_stmt_close($stmt);

            if (!$product_info) {
                throw new Exception("Produkt o ID $pro_id nie istnieje.");
            }

            $available_quantity = $product_info['ilosc'];

            // Sprawdź, czy dostępna ilość w magazynie pozwala na aktualizację
            if ($available_quantity >= $qty) {
                // Przygotowane zapytanie do aktualizacji stanu magazynowego
                $stmt = mysqli_prepare($conn, "UPDATE samoloty SET ilosc = ilosc - ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "ii", $qty, $pro_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Nie udało się zaktualizować stanu magazynowego dla produktu o ID $pro_id.");
                }
                mysqli_stmt_close($stmt);

                $total_prices += $qty * $product_info["cena"];
            } else {
                throw new Exception("Niewystarczająca ilość samolotu o ID $pro_id w magazynie.");
            }
        }
    }

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Wystąpił błąd: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}

?>

    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Sklep</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/cart.css">
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
                    <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
                </form>

                <div class="text-end">
                    <?php
                    if(empty($_SESSION["id"])) {
                        echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="src/php/login.php">Login</a></button>';
                    } else {
                        echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="src/php/logout.php">Logout</a></button>';
                    }
                    ?>
                </div>
                <p class="username">
                    <?php
                    if(isset($result_show_username)) {
                        echo htmlspecialchars($result_show_username["username"], ENT_QUOTES, 'UTF-8');
                    }
                    ?>
                </p>
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
                                    <!-- Tabela koszyka -->
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
if (isset($_SESSION['cart'])) {
    $i = 1;
    foreach ($_SESSION['cart'] as $cart) {
        $pro_id = (int)$cart['pro_id'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM samoloty WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $pro_id);
        mysqli_stmt_execute($stmt);
        $cart_wynik = mysqli_stmt_get_result($stmt);
        $product_name = mysqli_fetch_assoc($cart_wynik);
        mysqli_stmt_close($stmt);
        ?>
        <tr class="text-center">
            <td><?php echo $i; ?> #</td>
            <td><?php echo htmlspecialchars($product_name["nazwa"] . "," . $product_name["model"], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <form action="update.php" method="post">
                    <input type="number" value="<?= htmlspecialchars($cart['qty'], ENT_QUOTES, 'UTF-8'); ?>" name="qty" min="1">
                    <input type="hidden" name="upid" value="<?= htmlspecialchars($cart['pro_id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            </td>
            <td>
                <input type="submit" name="update" value="Update" class="btn btn-sm btn-warning">
                </form>
            </td>
            <td><a class="btn btn-sm btn-danger" href="remove_cart_item.php?id=<?= htmlspecialchars($cart['pro_id'], ENT_QUOTES, 'UTF-8'); ?>">Remove</a></td>
            <td><?php echo htmlspecialchars($cart['qty']*$product_name["cena"], ENT_QUOTES, 'UTF-8')."$";
                $total_prices += ($cart['qty']*$product_name["cena"]);
                ?></td>
        </tr>
        <?php
        $i++;
    }
}
?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="mb-0">Card details</h5>
                                            </div>
                                            <form class="mt-4">
                                                <!-- Formularz płatności -->
                                                <div class="form-outline form-white mb-4">
                                                    <input type="text" id="typeName" class="form-control form-control-lg" size="17" placeholder="Cardholder's Name" />
                                                    <label class="form-label" for="typeName">Cardholder's Name</label>
                                                </div>
                                                <div class="form-outline form-white mb-4">
                                                    <input type="text" id="typeText" class="form-control form-control-lg" size="17" placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                                                    <label class="form-label" for="typeText">Card Number</label>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="form-outline form-white">
                                                            <input type="text" id="typeExp" class="form-control form-control-lg" placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                                                            <label class="form-label" for="typeExp">Expiration</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-outline form-white">
                                                            <input type="password" id="typeText" class="form-control form-control-lg" size="1" minlength="3" maxlength="3" placeholder="123"/>
                                                            <label class="form-label" for="typeText">Cvv</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr class="my-4">
                                            <!-- Podsumowanie koszyka -->
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Shipping</p>
                                                <p class="mb-2">Free</p>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2">Total(Incl. taxes)</p>
                                                <p class="mb-2"><?php echo htmlspecialchars($total_prices, ENT_QUOTES, 'UTF-8') . "$"; ?></p>
                                            </div>
                                            <!-- Przycisk do płatności -->
                                            <button type="button" class="btn btn-info btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span><?php echo htmlspecialchars($total_prices, ENT_QUOTES, 'UTF-8') . "$"; ?></span>
                                                    <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
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

    <?php
    include_once "footer.php";
    ?>

</body>
</html>


