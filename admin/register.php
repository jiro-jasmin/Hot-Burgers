<?php
// THIS PAGE IS NOT UPLOADED ON PRODUCTION
// For this type of project, only one user account should be enough. 
// However for security reason, I created the user account with this script using php functions to hash the password, 
// rather than adding manually the account info directly into the database (if so, the password would not be hashed in the db)

$success = null;
$error = null;

function verifUser($db, string $user): bool
{
    $query = mysqli_prepare($db, "SELECT * FROM user where username = ?");
    mysqli_stmt_bind_param($query, "s", $user);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $user = mysqli_fetch_assoc($result);

    if ($user === null) {
        return false;
    }

    return true;
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $inputLogin = htmlentities($_POST['login']);
        $inputPassword = htmlentities($_POST['password']);

        $mysqli = mysqli_connect('localhost', 'DB_USER', 'DB_PWD', 'DB_NAME') or die('database connection error');

        if (verifUser($mysqli, $inputLogin)) {
            $error = "This username already exists.";
        } else {
            $query = mysqli_prepare($mysqli, "INSERT INTO user (username, password) VALUES (?,?)");
            $mdpHash = password_hash($inputPassword, PASSWORD_BCRYPT);

            mysqli_stmt_bind_param($query, "ss", $inputLogin, $mdpHash);
            $execute = mysqli_stmt_execute($query);

            if ($execute !== false) {
                $success = "Your account has been successfully created.";
            } else {
                $error = "Error while trying to register. Please try again.";
            }
        }
    } else {
        $error = "Please fill out both inputs";
    }
}

require_once '../components/header.php';

?>

<div class="container admin">
    <div class="row">
        <h1>New Account</h1>
        <?php if ($success) : ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="register.php" method="post" class="col-sm-4 mx-auto text-center">
            <div class="form-group mb-3">
                <input class="form-control" type="text" name="login" placeholder="Username" value="<?= $inputLogin ?? "" ?>">
            </div>
            <div class="form-group mb-3">
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>