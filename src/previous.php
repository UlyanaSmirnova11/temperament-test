<?php
require_once 'config.php';

try {
    $pdo = getDBConnection();
    
    // Получаем все результаты
    $stmt = $pdo->query("SELECT * FROM test_results ORDER BY test_date DESC");
    $results = $stmt->fetchAll();
    
    echo "<h1>История тестов</h1>";
    
    if (empty($results)) {
        echo "<p>Пока нет пройденных тестов.</p>";
    } else {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                <th>Имя</th>
                <th>Холерик</th>
                <th>Сангвиник</th>
                <th>Флегматик</th>
                <th>Меланхолик</th>
                <th>Доминирующий</th>
                <th>Дата</th>
              </tr>";
        
        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($result['user_name']) . "</td>";
            echo "<td>" . $result['choleric_score'] . "</td>";
            echo "<td>" . $result['sanguine_score'] . "</td>";
            echo "<td>" . $result['phlegmatic_score'] . "</td>";
            echo "<td>" . $result['melancholic_score'] . "</td>";
            echo "<td>" . ucfirst($result['dominant_temperament']) . "</td>";
            echo "<td>" . $result['test_date'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
    echo "<p><a href='test.php'>Пройти тест</a></p>";
    echo "<p><a href='index.php'>На главную</a></p>";
    
} catch (Exception $e) {
    echo "<h1>Ошибка</h1>";
    echo "<p>Ошибка при загрузке истории: " . $e->getMessage() . "</p>";
    echo "<p><a href='index.php'>На главную</a></p>";
}
?>
