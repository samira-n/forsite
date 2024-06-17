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
    <title>Главная страница</title>
    <!-- Подключение Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
    <div class="navbar-nav">
                <img src="img/logo.png" alt="" class="navbar-logo">
                <a href="index.php" class="nav-item nav-link active">Главная</a>
                <a href="product.php" class="nav-item nav-link">Каталог</a>
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
    <div class="welcome">
        <img src="img/welcome.png" alt="welcome-image" class="welcome-image">
        <div class="welcome-text">
            <h1>FORSITE</h1>
            <h1>Ваш проводник в мир высоких технологий</h1>
        </div>
    </div>

    <div class="about-us">
        <div class="about-1">
            <div class="text">
            <h1>О нас</h1>
            <p>Мы рады приветствовать вас на нашем сайте! Forsite — это ваш надежный партнер в мире высоких технологий. Наша компания стремится сделать новейшие технологии доступными для каждого. Мы верим, что технологии могут улучшить жизнь, и наша миссия — помочь вам открыть для себя их удивительный потенциал.</p>
            <h2>Наша история</h2>
            <p>Forsite был основан в 2017 году с целью предоставить клиентам лучшие технологии по доступным ценам. За годы работы мы стали одним из ведущих поставщиков высокотехнологичных продуктов, заработав доверие тысяч клиентов по всему миру.</p>
            
            </div>
            <div class="text-img">
                <img src="img/aboutus-1.png" alt="" class="img-about">
            </div>
        
        </div>

        <div class="about-2">
            <div class="text">
            <h2>Наши ценности</h2>
            <ul>
            <li><strong>Качество:</strong> Мы предлагаем только проверенные и качественные товары от ведущих мировых брендов.</li>
            <li><strong>Инновации:</strong> Мы постоянно следим за новинками и первыми предлагаем самые современные решения на рынке.</li>
            <li><strong>Доверие:</strong> Мы ценим наших клиентов и строим с ними долгосрочные и доверительные отношения.</li>
            <li><strong>Обслуживание:</strong> Мы всегда готовы помочь вам выбрать нужный продукт и ответить на все ваши вопросы.</li>
            </ul>
            <h2>Почему выбирают нас?</h2>
        <ul>
            <li><strong>Экспертиза:</strong> Наша команда — это профессионалы с многолетним опытом в сфере высоких технологий.</li>
            <li><strong>Лояльность:</strong> Специальные предложения и программы лояльности для постоянных клиентов.</li>
            <li><strong>Поддержка:</strong> Круглосуточная поддержка и помощь в выборе продукции.</li>
        </ul>
            </div>

            <div class="text">
                <img src="img/aboutus-2.png" alt="" class="img-about">
            </div>
        
        </div>
    
    </div>

    <div class="brands">
        <h1>Бренды</h1>
        <div class="swiper-container" >
            <div class="swiper-wrapper">
                <?php
                $sql = "SELECT id, name, logo FROM brands";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="swiper-slide">';
                        echo '    <div class="brand-item">';
                        echo '        <img class="img-brand" src="img/' . $row["logo"] . '" alt="" width="300px">';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Нет брендов для отображения.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h3 class="footer-heading">О нас</h3>
            <p>Мы рады приветствовать вас на нашем сайте! Forsite — это ваш проводник в мире высоких технологий.</p>
            <div class="contact">
                <span><i class="fas fa-envelope"></i> info@forsite.com</span>
                <span><i class="fas fa-phone"></i> +1234567890</span>
            </div>
        </div>
        <div class="footer-section links">
            <h3 class="footer-heading">Ссылки</h3>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="product.php">Каталог</a></li>
                <li><a href="contact.php">Связаться с нами</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; <?php echo date("Y"); ?> Forsite. Все права защищены.
    </div>
</footer>

    <!-- Подключение Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Подключение внешнего JavaScript-файла -->
    <script src="js/main.js"></script>
</body>

</html>
