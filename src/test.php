<?php
require_once 'config.php';

try {
    $pdo = getDBConnection();
    $questions = $pdo->query("SELECT * FROM questions")->fetchAll();
    
    echo "<h1>Тест на темперамент</h1>";
    echo "<form method='POST' action='results.php'>";
    echo "<label>Ваше имя: <input type='text' name='name' required></label><br><br>";
    
    foreach ($questions as $i => $q) {
        echo "<p><strong>" . ($i+1) . ". " . $q['question_text'] . "</strong></p>";
        
        // Показываем варианты ответов если они есть
        $options = [$q['option_a'], $q['option_b'], $q['option_c'], $q['option_d']];
        $hasOptions = false;
        
        foreach ($options as $index => $option) {
            if (!empty($option)) {
                $hasOptions = true;
                echo ($index+1) . " <input type='radio' name='q" . $q['id'] . "' value='" . ($index+1) . "' required> " . htmlspecialchars($option) . " ";
            }
        }
        
        // Если нет вариантов, показываем шкалу 1-5
        if (!$hasOptions) {
            for ($j = 1; $j <= 5; $j++) {
                echo $j . " <input type='radio' name='q" . $q['id'] . "' value='" . $j . "' required> ";
            }
        }
        
        echo "<br><br>";
    }
    
    echo "<button type='submit'>Узнать результат</button>";
    echo "</form>";
    
} catch (Exception $e) {
    echo "<p>Ошибка: " . $e->getMessage() . "</p>";
}
?>
