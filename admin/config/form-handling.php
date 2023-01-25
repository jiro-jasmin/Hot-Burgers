<?php

// FORM DATA SANITIZATION & VALIDATION
$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (stripos($_SERVER['REQUEST_URI'], 'admin/update.php')) {
    if (!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }
}

if (!empty($_POST)) {
    $name               = checkInput($_POST['name']);
    $description        = checkInput($_POST['description']);
    $price              = checkInput($_POST['price']);
    $category           = checkInput($_POST['category']);
    $image              = checkInput($_FILES["image"]["name"]);
    $imagePath          = '../images/' . basename($image);
    $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess          = true;

    stripos($_SERVER['REQUEST_URI'], 'admin/insert.php') && $isUploadSuccess = false;

    if (empty($name)) {
        $nameError = 'This field cannot be empty';
        $isSuccess = false;
    }
    if (empty($description)) {
        $descriptionError = 'This field cannot be empty';
        $isSuccess = false;
    }
    if (empty($price)) {
        $priceError = 'This field cannot be empty';
        $isSuccess = false;
    }
    if (empty($category)) {
        $categoryError = 'This field cannot be empty';
        $isSuccess = false;
    }
    if (empty($image)) {
        if (stripos($_SERVER['REQUEST_URI'], 'admin/insert.php')) {
            $imageError = 'This field cannot be empty';
            $isSuccess = false;
        } else {
            $isImageUpdated = false;
        }
    } else {
        $isUploadSuccess = true;
        stripos($_SERVER['REQUEST_URI'], 'admin/update.php') && $isImageUpdated = true;

        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "The authorized file types are: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "A file with the same name already exists.";
            $isUploadSuccess = false;
        }
        if ($_FILES["image"]["size"] > 500000) {
            $imageError = "The file cannot exceed 500KB";
            $isUploadSuccess = false;
        }
        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "There was an error during upload. Please try again.";
                $isUploadSuccess = false;
            }
        }
    }

    // INSERT query
    if (stripos($_SERVER['REQUEST_URI'], 'admin/insert.php')) {
        if ($isSuccess && $isUploadSuccess) {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name, $description, $price, $category, $image));
            Database::disconnect();
            header("Location: index.php");
        }
    }

    // UPDATE query
    if (stripos($_SERVER['REQUEST_URI'], 'admin/update.php')) {
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
            $db = Database::connect();
            if ($isImageUpdated) {
                $statement = $db->prepare("UPDATE items  set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $image, $id));
            } else {
                $statement = $db->prepare("UPDATE items  set name = ?, description = ?, price = ?, category = ? WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $id));
            }
            Database::disconnect();
            header("Location: index.php");
        } else if ($isImageUpdated && !$isUploadSuccess) {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM items where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();
        }
    }
} else if (stripos($_SERVER['REQUEST_URI'], 'admin/update.php')) {
    // UPDATE page : display current data (before update)

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

    $name           = $item['name'];
    $description    = $item['description'];
    $price          = $item['price'];
    $category       = $item['category'];
    $image          = $item['image'];
    Database::disconnect();
}
