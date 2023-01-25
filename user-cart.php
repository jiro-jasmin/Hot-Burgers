<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // starts the session if hasn't started yet
}

if (isset($_SESSION['item'])) {
    $cart = $_SESSION['item'];
}
$total = 0;

require_once 'components/header.php';
?>

<div class="container admin">
    <div class="row">
        <h1>My cart</h1>
        <?php if (!isset($_SESSION['item']) || empty($_SESSION['item'])) : ?>
            <p>The cart is currently empty!</p>
        <?php else : ?>
            <table class="table table-stripped">
                <thread>
                    <th scope="col">Items</th>
                    <th scope="col"></th>
                </thread>
                <tbody>
                    <?php foreach ($cart as $item) : ?>
                        <?php $total += $item['price']; ?>
                        <tr>
                            <td><?= $item['name']; ?></td>
                            <td><?= number_format($item['price'], 2); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Total :</strong> </td>
                        <td><?= number_format($total, 2); ?> €</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mb-4">
                <a href="functions/empty-cart.php" class="link-secondary"><i class="bi-trash"></i> Empty Cart</a>
            </div>
        <?php endif ?>

        <div class="d-flex justify-content-between container-fluid cart">
            <a class="btn btn-secondary" href="index.php"><i class="bi-arrow-left"></i> Go back to shop</a>
            <?php if (isset($_SESSION['item']) || !empty($_SESSION['item'])) : ?>
                <a href="order-confirmation.php" class="btn btn-place-order" role="button"><span class="bi-cart-fill"></span>Order</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="assets/js/cart.js"></script>
</body>

</html>