<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="src/css/main.css">
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
                <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="src/php/shop.php" class="nav-link px-2 text-white">Sklep</a></li>
                <li><a href="src/php/panel.php" class="nav-link px-2 text-white">Panel</a></li>
                <li><a href="src/php/cart.php" class="nav-link px-2 text-white">Cart</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" data-dashlane-rid="b0ad484f5a24ee6d" data-form-type="">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" data-dashlane-rid="08ac5c5fec0cede6" data-form-type="">
            </form>

            <div class="text-end">

                <?php

                require "src/php/conn.php";

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

<div class="title">

    <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <h1 class="text-center">Witam w moim sklepie z samolotami</h1>
        </div>
    </div>
</div>

<div class="search_bar">

    <div class="row height d-flex justify-content-center align-items-center">

        <div class="col-md-8">

            <div class="search">
                <i class="fa fa-search"></i>
                <input type="text" class="form-control" placeholder="Szukasz czegoś konkretnego?">
                <button class="btn btn-primary">Szukaj</button>
            </div>

        </div>

    </div>
</div>


<div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
        <div class="col-lg-4">
            <img src="/src/img/boeing.svg" class="bd-placeholder-img" width="140" height="140" role="img" aria-label="Placeholder: 140x140" alt="Boeing Image">
            <p class="mt-3">Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
            <p><a class="btn btn-secondary" href="#">View details »</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img src="/src/img/airbus.svg" class="bd-placeholder-img" width="140" height="140" role="img" aria-label="Placeholder: 140x140" alt="Boeing Image">
            <p class="mt-3">Another exciting bit of representative placeholder content. This time, we've moved on to the second column.</p>
            <p><a class="btn btn-secondary" href="#">View details »</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <img src="/src/img/cessna.svg" class="bd-placeholder-img" width="140" height="140" role="img" aria-label="Placeholder: 140x140" alt="Boeing Image">
            <p class="mt-3">And lastly this, the third column of representative placeholder content.</p>
            <p><a class="btn btn-secondary" href="#">View details »</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading fw-normal lh-1">Boeing. <span class="text-muted">Innowacyjność w lotnictwie.</span></h2>
            <p class="lead">Boeing jest jednym z największych producentów samolotów na świecie, znany ze swoich szerokokadłubowych i wąskokadłubowych samolotów pasażerskich oraz innowacyjnych rozwiązań w dziedzinie lotnictwa.</p>
        </div>
        <div class="col-md-5">
            <img src="/src/img/747.jpg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" alt="Boeing Image">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading fw-normal lh-1">Airbus. <span class="text-muted">Innowacje dla przyszłości lotnictwa.</span></h2>
            <p class="lead">Airbus to międzynarodowy koncern lotniczy znany z produkcji szerokiej gamy samolotów, w tym popularnych modeli A320, A330 i A380, oraz zaawansowanych technologii w zakresie bezpieczeństwa i efektywności.</p>
        </div>
        <div class="col-md-5 order-md-1">
            <img src="/src/img/a320.jpeg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" alt="Airbus Image">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading fw-normal lh-1">Cessna. <span class="text-muted">Doskonałość w lotach turystycznych.</span></h2>
            <p class="lead">Cessna to amerykański producent lekkich samolotów, szczególnie znany z serii jednosilnikowych samolotów turystycznych i biznesowych. Ich samoloty są cenione za niezawodność i łatwość obsługi.</p>
        </div>
        <div class="col-md-5">
            <img src="/src/img/172.jpg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" alt="Cessna Image">
        </div>
    </div>

    <hr class="featurette-divider">


    <!-- /END THE FEATURETTES -->

</div>


<?php
 require_once './src/php/footer.php';
?>

</body>
<script src="src/js/main.js"></script>

