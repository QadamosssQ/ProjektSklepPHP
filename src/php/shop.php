<?php

require "conn.php";

$query = "SELECT * FROM samoloty";

$result = mysqli_query($conn, $query);
?>


<html lang="en">
<head>
    <link rel="stylesheet" href="../css/shop.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


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
                <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" data-dashlane-rid="b0ad484f5a24ee6d" data-form-type="">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">



                <?php if (empty($_SESSION["id"])) {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="login.php">Login</a> </button>';
                } else {
                    echo '<button type="button" class="btn btn-outline-light me-2"><a class="login_button" href="logout.php">Logout</a> </button>';
                } ?>


            </div>
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
                    <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm" type="button">Details</button><button class="btn btn-outline-dark btn-sm mt-2" type="button">Add to wishlist</button></div>
                </div>
            </div>

                ';
                } ?>




            </div>
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

