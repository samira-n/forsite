<?php
session_start();
include 'php/config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        $username = "Пользователь";
    }
} else {
    $username = "Гость";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="navbar-nav">
        <img src="img/logo.png" alt="" width="100px" height="70px">
        <a href="index.php" class="nav-item nav-link">Главная</a>
        <a href="products.php" class="nav-item nav-link active">Каталог</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="view_cart.php" class="nav-item nav-link">Корзина</a>
            <a href="php/logout.php" class="nav-item nav-link">Выйти</a>
            <p class="nav-item nav-user"><?php echo $username; ?></p>
        <?php else: ?>
            <a href="login.html" class="nav-item nav-link">Войти</a><br>
        <?php endif; ?>
        <a href="contact.php" class="nav-item">Связаться с нами <i class="bi-arrow-right"></i></a>
    </div>
</header>

<div class="products-section">
    <h1>Игровые ПК</h1>
    <div class="products-grid">
        <?php
        $sql = "SELECT id, name, description, price, image FROM products WHERE category_id=2";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '    <img class="product-image" src="img/' . $row["image"] . '" alt="" width="100px">';
                echo '    <h6 class="product-name">' . $row["name"] . '</h6>';
                echo '    <h5 class="product-price">' . $row["price"] . ' рублей</h5>';
                echo '    <div class="btn-action">';
                echo '        <form action="php/add_to_cart.php" method="post">';
                echo '            <input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '            <input type="hidden" name="quantity" value="1">';
                echo '            <button type="submit" class="btn btn-primary"><i class="bi bi-cart"> В корзину</i></button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Нет товаров для отображения.</p>';
        }
        ?>
    </div>

    <h1>Офисные ПК</h1>
    <div class="products-grid">
        <?php
        $sql = "SELECT id, name, description, price, image FROM products WHERE category_id=1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '    <img class="product-image" src="img/' . $row["image"] . '" alt="" width="100px">';
                echo '    <h6 class="product-name">' . $row["name"] . '</h6>';
                echo '    <h5 class="product-price">' . $row["price"] . ' рублей</h5>';
                echo '    <div class="btn-action">';
                echo '        <form action="php/add_to_cart.php" method="post">';
                echo '            <input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '            <input type="hidden" name="quantity" value="1">';
                echo '            <button type="submit" class="btn btn-primary"><i class="bi bi-cart"> В корзину</i></button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Нет товаров для отображения.</p>';
        }
        ?>
    </div>

    <h1>Ноутбуки</h1>
    <div class="products-grid">
        <?php
        $sql = "SELECT id, name, description, price, image FROM products WHERE category_id=3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '    <img class="product-image" src="img/' . $row["image"] . '" alt="" width="200px">';
                echo '    <h6 class="product-name">' . $row["name"] . '</h6>';
                echo '    <h5 class="product-price">' . $row["price"] . ' рублей</h5>';
                echo '    <div class="btn-action">';
                echo '        <form action="php/add_to_cart.php" method="post">';
                echo '            <input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '            <input type="hidden" name="quantity" value="1">';
                echo '            <button type="submit" class="btn btn-primary"><i class="bi bi-cart"> В корзину</i></button>';
                echo '        </form>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Нет товаров для отображения.</p>';
        }
        ?>
    </div>
</div>
</body>
</html>
