<?php
function is_connected(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connected']); // return true, & if empty = false
}

function force_user_to_connect(): void
{
    if (!is_connected()) {
        header('Location: ./login.php');
        exit();
    }
}
