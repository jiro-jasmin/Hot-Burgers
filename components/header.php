<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // starts the session if hasn't started yet
}

if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
    $onAdmin = true;
    require_once 'config/auth.php';
} else {
    $onAdmin = false;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        <?php if ($onAdmin) {
            echo 'Admin Panel | Hot Burgers 🍔 for Hot People 🥵';
        } else {
            echo 'Burgers & French Fries Fastfood Restaurant in Berlin | Hot Burgers 🍔 for Hot People 🥵';
        } ?>
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <?php if ($onAdmin) {
        echo '<link rel="stylesheet" href="../assets/css/styles.css">';
    } else {
        echo '<link rel="stylesheet" href="assets/css/styles.css">';
    } ?>

</head>

<body>
    <div class="sticky-top">
        <h1 class="text-logo"><a href="#">Hot Burgers</a></h1>
        <?php if ($onAdmin && is_connected()) : ?>
            <nav class="d-flex justify-content-end">
                <ul class="nav nav-pills mb-1 me-2">
                    <li class="nav-item"><a class="nav-link active fs-5" href="index.php">Panel</a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="/">Client view</a></li>
                    <li class="nav-item"><a class="nav-link fs-5" href="config/logout.php">Logout</a></li>
                </ul>
            </nav>
        <?php elseif(strpos($_SERVER['REQUEST_URI'], 'order-confirmation') === false): ?>
            <div class="my-cart">
                <a href="../user-cart.php" type="button" class="btn position-relative">
                    Cart
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="nbrItem">
                        <?= empty($_SESSION['item']) ? "0" : count($_SESSION['item']);  ?>
                    </span>
                </a>
            </div>
    <div class="position-absolute" id="alert"></div>

    </div>
<?php endif; ?>