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
    
    for ($j = 1; $j <= 5; $j++) {
        echo $j . " <input type='radio' name='q" . $q['id'] . "' value='" . $j . "' required> ";
    }
    
    echo "<br><br>";
}
    
    echo "<button type='submit'>Узнать результат</button>";
    echo "</form>";
    
} catch (Exception $e) {
    echo "<p>Ошибка: " . $e->getMessage() . "</p>";
}
?>
