<?php

require_once 'config/auth.php';
force_user_to_connect();

require 'config/database.php';

if (!empty($_GET['id'])) {
  $id = checkInput($_GET['id']);
} else {
  // if no id in the URL, 404
  http_response_code(404);
  header("Location: ../../404.php");
  die();
}

$db = Database::connect();
$statement = $db->prepare("SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");
$statement->execute(array($id));
$item = $statement->fetch();
// if item doesn't exist, 404
if (!$item) {
  Database::disconnect();
  http_response_code(404);
  header("Location: ../../404.php");
  die();
}
Database::disconnect();

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
      <div class="col-md-6">
        <h1><strong>Preview of the item</strong></h1>
        <br>
        <form>
          <div>
            <label>Name:</label><?php echo '  ' . $item['name']; ?>
          </div>
          <br>
          <div>
            <label>Description:</label><?php echo '  ' . $item['description']; ?>
          </div>
          <br>
          <div>
            <label>Price:</label><?php echo '  ' . number_format((float)$item['price'], 2, '.', '') . ' €'; ?>
          </div>
          <br>
          <div>
            <label>Category:</label><?php echo '  ' . $item['category']; ?>
          </div>
          <br>
          <div>
            <label>Image:</label><?php echo '  ' . $item['image']; ?>
          </div>
        </form>
        <br>
        <div class="form-actions mb-4">
          <a class="btn btn-secondary" href="index.php"><i class="bi-arrow-left"></i> Go back</a>
        </div>
      </div>
      <div class="col-md-6 site">
        <div class="img-thumbnail">
          <img src="<?php echo '../images/' . $item['image']; ?>" alt="...">
          <div class="price"><?php echo number_format((float)$item['price'], 2, '.', '') . ' €'; ?></div>
          <div class="caption">
            <h4><?php echo $item['name']; ?></h4>
            <p><?php echo $item['description']; ?></p>
            <a href="#" class="btn btn-order" role="button"><i class="bi-cart-fill"></i> Add to cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>