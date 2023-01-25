<?php
require_once 'components/header.php';

if (!isset($_SESSION['item']) || empty($_SESSION['item'])) {
    header('Location: /');
    exit();
}

require_once 'functions/empty-cart.php';

?>
<div class="container admin">
    <div class="row text-center">
        <h1>Thank you for your order !</h1>
        <p class="fs-1">🍔 🍔 🍔 </p>
        <div class="my-4">
            <a class="btn btn-place-order" href="index.php">Go back to homepage</a>
        </div>
    </div>
</div>
</body>

</html>