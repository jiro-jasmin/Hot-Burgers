<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // starts the session if hasn't started yet
}

unset($_SESSION['item']);

if (strpos($_SERVER['REQUEST_URI'], 'order-confirmation') === false) {
    header('Location: ../user-cart.php');
}
