<?php

require_once 'config/auth.php';
force_user_to_connect();

require 'config/database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);

    // check if item exists
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM items where id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    // if item doesn't exist, 404
    if (!$item) {
        Database::disconnect();
        http_response_code(404);
        header("Location: ../../404.php");
        die();
    }
}

if (!empty($_POST)) {
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location: index.php");
    die();
}

// if user tries to type in url, check item in db or 404
if (!$item['name']) {
    http_response_code(404);
    header("Location: ../../404.php");
    die();
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require '../components/header.php'
?>

<div class="container admin">
    <div class="row">
        <h1><strong>Delete the item</strong></h1>
        <br>
        <form class="form" action="delete.php" role="form" method="post">
            <br>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <p class="alert alert-danger">Do you really want to delete <strong><?= $item['name'] ?></strong> ?</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Yes, delete</button>
                <a class="btn btn-secondary" href="index.php"><i class="bi-arrow-left"></i> No, cancel</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>