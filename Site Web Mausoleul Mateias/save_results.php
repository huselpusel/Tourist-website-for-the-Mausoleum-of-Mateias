<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $q1 = isset($_POST['q1']) ? $_POST['q1'] : '';
    $q2 = isset($_POST['q2']) ? $_POST['q2'] : '';
    $q3 = isset($_POST['q3']) ? $_POST['q3'] : '';

    
    if (!empty($name) && !empty($q1) && !empty($q2) && !empty($q3)) {
        
        $resultsText = "Nume: " . $name . "\n";
        $resultsText .= "Intrebarea 1: " . $q1 . "\n";
        $resultsText .= "Intrebarea 2: " . $q2 . "\n";
        $resultsText .= "Intrebarea 3: " . $q3 . "\n";

        
        $savePath = 'D:/easy php salvare din program files 86/EasyPHP-5.3.5.0/www/proiect mare/mesaje/raspunsuri quizz/';

        
        $fileName = date('YmdHis') . '_' . $name . '_rezultate_quiz.txt';

        
        $filePath = $savePath . $fileName;

        
        if (file_put_contents($filePath, $resultsText) !== false) {
            echo "Rezultatele au fost salvate cu succes în fișierul: " . $filePath;
        } else {
            echo "Eroare la salvarea rezultatelor.";
        }
    } else {
        echo "Toate câmpurile sunt obligatorii.";
    }
} else {
    echo "Acces interzis!";
}
?>
