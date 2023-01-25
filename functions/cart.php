<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // starts the session if hasn't started yet
}

$mysqli = mysqli_connect('localhost', 'DB_USER', 'DB_PWD', 'DB_NAME') or die('database connection error');

if (isset($_POST['item'])) {
    $idItem = (int)$_POST['item'];
    $query = mysqli_prepare($mysqli, "SELECT id, name, price FROM items WHERE id = ?");

    mysqli_stmt_bind_param($query, "i", $idItem);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    if ($result) {
        $item = mysqli_fetch_assoc($result); // one result here
        if (isset($_SESSION['item'])) {
            array_push($_SESSION['item'], $item);
        } else {
            $_SESSION['item'] = [];
            array_push($_SESSION['item'], $item);
        }

        $information = [];
        $information['item'] = $item;
        $information['nbr_item'] = count($_SESSION['item']);

        echo json_encode($information);
    } else {
        echo "Error in query";
    }
} else {
    echo "Error";
}
