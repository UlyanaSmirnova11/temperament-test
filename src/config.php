<?php
// Получаем параметры из переменных окружения Docker
$db_host = getenv('DB_HOST') ?: 'postgres';
$db_port = getenv('DB_PORT') ?: '5432';
$db_name = getenv('DB_NAME') ?: 'temperament_db';
$db_user = getenv('DB_USER') ?: 'temperament_user';
$db_pass = getenv('DB_PASSWORD') ?: '';

// Функция подключения к БД
function getDBConnection() {
    global $db_host, $db_port, $db_name, $db_user, $db_pass;
    
    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name};";
    
    try {
        $pdo = new PDO($dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        // В production логируем ошибку, но не показываем детали пользователю
        error_log("Ошибка подключения к БД: " . $e->getMessage());
        die("Ошибка подключения к базе данных");
    }
}

// Функция загрузки вопросов
function loadQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY id");
    return $stmt->fetchAll();
}
?>
