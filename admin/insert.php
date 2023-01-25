<?php

require_once 'config/auth.php';
force_user_to_connect();

require 'config/database.php';
require 'config/form-handling.php';
require '../components/header.php'

?>

<div class="container admin">
    <div class="row">
        <h1><strong>Add a new item</strong></h1>
        <br>
        <?php if (!empty($_POST) && $isSuccess === false) : ?>
            <div class="alert alert-danger" role="alert">
                Sending failed. Please check the missing fields.
            </div>
        <?php endif ?>
        <?php if (!empty($_POST) && $isSuccess === true) : ?>
            <div class="alert alert-success" role="alert">
                The new item has been successfully added to the database.
            </div>
        <?php endif ?>
        <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
            <br>
            <div>
                <label class="form-label" for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>">
                <span class="help-inline"><?php echo $nameError; ?></span>
            </div>
            <br>
            <div>
                <label class="form-label" for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                <span class="help-inline"><?php echo $descriptionError; ?></span>
            </div>
            <br>
            <div>
                <label class="form-label" for="price">Price: (in euros €)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price" value="<?php echo $price; ?>">
                <span class="help-inline"><?php echo $priceError; ?></span>
            </div>
            <br>
            <div>
                <label class="form-label" for="category">Category:</label>
                <select class="form-control" id="category" name="category">
                    <?php
                    $db = Database::connect();
                    foreach ($db->query('SELECT * FROM categories') as $row) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';;
                    }
                    Database::disconnect();
                    ?>
                </select>
                <span class="help-inline"><?php echo $categoryError; ?></span>
            </div>
            <br>
            <div>
                <label class="form-label" for="image">Select an image:</label>
                <input type="file" id="image" name="image">
                <span class="help-inline"><?php echo $imageError; ?></span>
            </div>
            <br>
            <div class="form-actions">
                <button type="submit" class="btn btn-success"><i class="bi-plus-circle"></i> Add</button>
                <a class="btn btn-secondary" href="index.php"><i class="bi-arrow-left"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>