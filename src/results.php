<?php
require_once 'config.php';

try {
    $pdo = getDBConnection();
    
    // Получаем данные из формы
    $user_name = $_POST['name'] ?? 'Аноним';
    
    $scores = [
        'choleric' => 0,
        'sanguine' => 0,
        'phlegmatic' => 0,
        'melancholic' => 0
    ];
    
    // Обрабатываем ответы
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0) {
            $question_id = str_replace('q', '', $key);
            
            // Получаем тип темперамента вопроса
            $stmt = $pdo->prepare("SELECT temperament_type FROM questions WHERE id = ?");
            $stmt->execute([$question_id]);
            $question = $stmt->fetch();
            
            if ($question && isset($question['temperament_type'])) {
                $temperament = $question['temperament_type'];
                // Добавляем балл (значение ответа от 1 до 5)
                $scores[$temperament] += intval($value);
            }
        }
    }
    
    // Определяем доминирующий темперамент
    $max_score = max($scores);
    $dominant_types = array_keys($scores, $max_score);
    
    $russian_names = [
        'choleric' => 'Холерик',
        'sanguine' => 'Сангвиник', 
        'phlegmatic' => 'Флегматик',
        'melancholic' => 'Меланхолик'
    ];
    
    if (count($dominant_types) > 1) {
        // Несколько типов с одинаковым баллом
        $dominant_names = [];
        foreach ($dominant_types as $type) {
            $dominant_names[] = $russian_names[$type];
        }
        $dominant_display = implode(' и ', $dominant_names);
        $dominant_db = $dominant_types[0]; // Для БД берём первый
    } else {
        // Один доминирующий тип
        $dominant_display = $russian_names[$dominant_types[0]];
        $dominant_db = $dominant_types[0];
    }
    
    // Сохраняем результат в БД
    $stmt = $pdo->prepare("
        INSERT INTO test_results 
        (user_name, choleric_score, sanguine_score, phlegmatic_score, melancholic_score, dominant_temperament) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $user_name,
        $scores['choleric'],
        $scores['sanguine'],
        $scores['phlegmatic'],
        $scores['melancholic'],
        $dominant_db
    ]);
    
    echo "<h1>Результаты теста для " . htmlspecialchars($user_name) . "</h1>";
    
    echo "<h3>Баллы по темпераментам:</h3>";
    echo "<ul>";
    echo "<li>Холерик: " . $scores['choleric'] . " баллов</li>";
    echo "<li>Сангвиник: " . $scores['sanguine'] . " баллов</li>";
    echo "<li>Флегматик: " . $scores['phlegmatic'] . " баллов</li>";
    echo "<li>Меланхолик: " . $scores['melancholic'] . " баллов</li>";
    echo "</ul>";
    
    echo "<h3>Ваш доминирующий темперамент: " . $dominant_display . "</h3>";
    
    $descriptions = [
        'choleric' => 'Энергичный, целеустремленный, эмоциональный, склонный к лидерству.',
        'sanguine' => 'Общительный, оптимистичный, активный, легко адаптирующийся.',
        'phlegmatic' => 'Спокойный, уравновешенный, надежный, несколько медлительный.',
        'melancholic' => 'Чувствительный, глубокий, перфекционист, склонный к самоанализу.'
    ];
    
    echo "<p><strong>Описание:</strong> " . $descriptions[$dominant_db] . "</p>";
    
    echo "<p><a href='previous.php'>Посмотреть историю тестов</a></p>";
    echo "<p><a href='test.php'>Пройти тест еще раз</a></p>";
    echo "<p><a href='index.php'>На главную</a></p>";
    
} catch (Exception $e) {
    echo "<h1>Ошибка</h1>";
    echo "<p>Произошла ошибка при обработке теста: " . $e->getMessage() . "</p>";
    echo "<p><a href='test.php'>Вернуться к тесту</a></p>";
}
?>
