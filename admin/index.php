<?php

require_once 'config/auth.php';
force_user_to_connect();

require_once 'config/database.php';
$db = Database::connect();
$statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
require_once '../components/header.php'

?>
<div class="container admin">
  <div class="row">


    <h1><strong>List of all items </strong><a href="insert.php" class="btn btn-success btn-lg"><i class="bi bi-plus-circle"></i> Add</a></h1>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($item = $statement->fetch()) {
          $price = number_format($item['price'], 2, '.', '');
          echo <<<HTML
            <tr>
            <td> {$item['name']} </td>
            <td> {$item['description']} </td>
            <td> {$price}</td>
            <td> {$item['category']} </td>
            <td>
            <div class="d-flex flex-column flex-md-row gap-2 justify-content-around">
            <a class="btn btn-secondary" href="view.php?id={$item['id']}"><i class="bi bi-eye"></i> Preview</a> 
            <a class="btn btn-primary" href="update.php?id={$item['id']}"><i class="bi bi-pencil-square"></i> Edit</a> 
            <a class="btn btn-danger" href="delete.php?id={$item['id']}"><i class="bi bi-trash"></i> Delete</a>
            </div>
            </td>
            </tr>
HTML;
        }
        Database::disconnect();
        ?>
      </tbody>
    </table>
  </div>
</div>
</body>

</html>