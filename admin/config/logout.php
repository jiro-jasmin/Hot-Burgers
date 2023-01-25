<?php
session_start(); // here session continues
unset($_SESSION['connected']);
header('Location: /');