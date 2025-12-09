<?php
require_once 'config.php';

try {
    $pdo = getDBConnection();
    $questions = $pdo->query("SELECT * FROM questions")->fetchAll();
    
    echo "<h1>Тест</h1>";
    echo "<form>";
    echo "<label>Имя: <input type='text' name='name'></label><br><br>";
    
    foreach ($questions as $i => $q) {
        echo "<p><strong>" . ($i+1) . ". " . $q['question_text'] . "</strong></p>";
        echo "1 <input type='radio' name='q" . $q['id'] . "' value='1'> ";
        echo "2 <input type='radio' name='q" . $q['id'] . "' value='2'> ";
        echo "3 <input type='radio' name='q" . $q['id'] . "' value='3'> ";
        echo "4 <input type='radio' name='q" . $q['id'] . "' value='4'> ";
        echo "5 <input type='radio' name='q" . $q['id'] . "' value='5'><br><br>";
    }
    
    echo "<button>Отправить</button>";
    echo "</form>";
    
} catch (Exception $e) {
    echo "<p>Ошибка БД</p>";
}
?>
