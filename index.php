<?php require 'components/header.php' ?>

<div class="container site">

    <?php
    require 'admin/config/database.php';

    // Navigation menu

    echo '<nav><ul class="nav nav-pills" role="tablist">';

    $db = Database::connect();
    $statement = $db->query('SELECT * FROM categories');
    $categories = $statement->fetchAll();
    foreach ($categories as $category) {
        if ($category['id'] == '1') {
            echo '<li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
        } else {
            echo '<li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
        }
    }

    echo    '</ul></nav><div class="tab-content">';

    foreach ($categories as $category) {
        if ($category['id'] == '1') {
            echo '<div class="tab-pane active" id="tab' . $category['id'] . '" role="tabpanel">';
        } else {
            echo '<div class="tab-pane" id="tab' . $category['id'] . '" role="tabpanel">';
        }

        echo '<div class="row">';

        // List of items

        $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
        $statement->execute(array($category['id']));
        while ($item = $statement->fetch()) {
            echo '<div class="col-md-6 col-lg-4">
                        <div class="img-thumbnail">
                            <img src="assets/images/' . $item['image'] . '" class="img-fluid" alt="...">
                            <div class="price">' . number_format($item['price'], 2, '.', '') . ' €</div>
                                <div class="caption">
                                    <h4>' . $item['name'] . '</h4>
                                    <p>' . $item['description'] . '</p>
                                    <a href="" class="btn btn-order" role="button" data-id=' . $item['id'] . '><span class="bi-cart-fill"></span> Add to cart</a>
                                </div>
                            </div>
                        </div>';
        }

        echo    '</div>
                        </div>';
    }
    Database::disconnect();
    echo  '</div>';
    ?>

</div>
<script src="assets/js/cart.js"></script>
</body>

</html>