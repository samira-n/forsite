<?php
include 'php/config.php';
session_start();

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

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$order_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_product_id'])) {
        $remove_product_id = $_POST['remove_product_id'];
        $remove_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        if (!$remove_stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $remove_stmt->bind_param("ii", $user_id, $remove_product_id);
        $remove_stmt->execute();
        header("Location: view_cart.php");
        exit;
    } elseif (isset($_POST['update_product_id']) && isset($_POST['action'])) {
        $update_product_id = $_POST['update_product_id'];
        $action = $_POST['action'];
        
        $current_quantity_stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        if (!$current_quantity_stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $current_quantity_stmt->bind_param("ii", $user_id, $update_product_id);
        $current_quantity_stmt->execute();
        $current_quantity_result = $current_quantity_stmt->get_result();
        
        if ($current_quantity_result->num_rows > 0) {
            $current_quantity_row = $current_quantity_result->fetch_assoc();
            $current_quantity = $current_quantity_row['quantity'];
            
            if ($action == "increase") {
                $new_quantity = $current_quantity + 1;
            } elseif ($action == "decrease") {
                $new_quantity = max(1, $current_quantity - 1);
            }
            
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            if (!$update_stmt) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $update_stmt->bind_param("iii", $new_quantity, $user_id, $update_product_id);
            $update_stmt->execute();
            header("Location: view_cart.php");
            exit;
        }
    } elseif (isset($_POST['total_price'])) {
        $total_price = $_POST['total_price'];

        $cart_check_stmt = $conn->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?");
        if (!$cart_check_stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $cart_check_stmt->bind_param("i", $user_id);
        $cart_check_stmt->execute();
        $cart_check_result = $cart_check_stmt->get_result();
        $cart_count_row = $cart_check_result->fetch_assoc();

        if ($cart_count_row['cart_count'] == 0) {
            $order_message = "Ваша корзина пуста. Пожалуйста, добавьте товары в корзину перед оформлением заказа.";
        } else {
            $conn->begin_transaction();

            try {
                $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Ошибка подготовки запроса: " . $conn->error);
                }
                $stmt->bind_param("id", $user_id, $total_price);
                $stmt->execute();
                $order_id = $stmt->insert_id;

                $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
                if (!$stmt) {
                    throw new Exception("Ошибка подготовки запроса: " . $conn->error);
                }
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($result && $row = $result->fetch_assoc()) {
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];

                    $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM products WHERE id = ?))");
                    if (!$stmt) {
                        throw new Exception("Ошибка подготовки запроса: " . $conn->error);
                    }
                    $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $product_id);
                    $stmt->execute();
                }

                $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
                if (!$stmt) {
                    throw new Exception("Ошибка подготовки запроса: " . $conn->error);
                }
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                $conn->commit();

                $order_message = "Заказ успешно оформлен!";
            } catch (Exception $e) {
                $conn->rollback();
                $order_message = "Не удалось оформить заказ: " . $e->getMessage();
            }
        }
    }
}

$stmt = $conn->prepare("SELECT products.id, products.name, products.price, cart.quantity FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="navbar-nav">
        <img src="img/logo.png" alt="" width="100px" height="70px">
        <a href="index.php" class="nav-item nav-link">Главная</a>
        <a href="product.php" class="nav-item nav-link">Каталог</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="view_cart.php" class="nav-item nav-link active">Корзина</a>
            <a href="php/logout.php" class="nav-item nav-link">Выйти</a>
            <p class="nav-item nav-user"><?php echo $username; ?></p>
        <?php else: ?>
            <a href="login.html" class="nav-item nav-link">Войти</a><br>
        <?php endif; ?>
        <a href="contact.php" class="nav-item">Связаться с нами <i class="bi-arrow-right"></i></a>
    </div>
</header>

<div class="cart-container">
    <h1>Ваша корзина</h1>
    <?php if ($order_message): ?>
        <div class="alert alert-info">
            <?php echo $order_message; ?>
        </div>
    <?php endif; ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?> рублей</td>
                <td>
                    <form action="view_cart.php" method="post" class="update-form">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="quantity-btn">-</button>
                    </form>
                    <?php echo $row['quantity']; ?>
                    <form action="view_cart.php" method="post" class="update-form">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="increase">
                        <button type="submit" class="quantity-btn">+</button>
                    </form>
                </td>
                <td><?php echo $row['price'] * $row['quantity']; ?> рублей</td>
                <td>
                    <form action="view_cart.php" method="post">
                        <input type="hidden" name="remove_product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="remove-btn">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php $total_price += $row['price'] * $row['quantity']; ?>
        <?php endwhile; ?>
        </tbody>
    </table>
    <h2>Общая сумма: <?php echo $total_price; ?> рублей</h2>
    <form action="view_cart.php" method="post" class="order-form">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <button type="submit" class="order-btn">Оформить заказ</button>
    </form>
</div>
</body>
</html>
