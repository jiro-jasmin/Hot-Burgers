<?php
// Check is user is already connected
require_once 'config' . DIRECTORY_SEPARATOR . 'auth.php';
if (is_connected()) {
    header('Location: ./index.php'); 
    exit();
}

// User authentication 
$error = null;

if (isset($_POST['login']) && isset($_POST['password'])) {
    $inputLogin = htmlentities($_POST['login']);
    $inputPassword = htmlentities($_POST['password']);

    $mysqli = mysqli_connect('localhost', 'root', 'root', 'burgercode', 8889) or die('database connection error');
    $query = mysqli_prepare($mysqli, "SELECT * FROM user WHERE username = ?");

    mysqli_stmt_bind_param($query, "s", $inputLogin);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $user = mysqli_fetch_assoc($result);

    if ($user !== null) {
        if (password_verify($inputPassword, $user['password'])) {
            $_SESSION['login'] = $inputLogin;
            $_SESSION['connected'] = 1; 
            header('Location: ./index.php'); // connection succeeds
            exit();
        } else {
            $error = "Incorrect Password";
        }
    } else {
        $error = "Username unknown";
    }
}

require_once '../components/header.php';
?>

<div class="container admin">
    <div class="row">
        <h1>Admin Panel Connection</h1>
        <?php if ($error) : ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="col-sm-4 mx-auto text-center mb-3">
            <div class="form-group mb-3">
                <input class="form-control" type="text" name="login" placeholder="Username">
            </div>
            <div class="form-group mb-3">
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-success">Login</button>
        </form>
            <p class="text-center my-3 fs-4">Are you lost ?<br> <a class="link-success" href="../index.php">Click here to go back to the shop</a></p>
    </div>
</div>