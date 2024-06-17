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
    <title>Связаться с нами</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="navbar-nav">
                <img src="img/logo.png" alt="" width="100px" height="70px">
                <a href="index.php" class="nav-item nav-link">Главная</a>
                <a href="product.php" class="nav-item nav-link">Каталог</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="view_cart.php" class="nav-item nav-link">Корзина</a>
                        <a href="php/logout.php" class="nav-item nav-link">Выйти</a>
                        <p class="nav-item nav-user"><?php echo $username; ?></p>
                    <?php else: ?>
                        <a href="login.html" class="nav-item nav-link">Войти</a><br>
                    <?php endif; ?>
                <a href="contact.php" class="nav-item  active">Связаться с нами <i class="bi-arrow-right"></i></a>
            </div>
    </header>

    <div class="message">
        <form action="php/contact.php" method="post">
            <input type="text" class="form-control" name="name" placeholder="Ваше имя"  required>
            <input type="email" class="form-control" name="email" placeholder="Ваша почта"  required>
            <input type="text" class="form-control" name="subject" placeholder="Тема обращения"  required>
            <textarea class="form-control" name="message" rows="8" placeholder="Сообщение" required></textarea>
            <button class="btn" type="submit">Отправить письмо</button>
        </form>
    </div>
</body>
</html>