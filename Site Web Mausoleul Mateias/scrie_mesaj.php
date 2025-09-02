<?php
session_start();


date_default_timezone_set('Europe/Bucharest');


$message = $_POST['message'];


$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Utilizator';


$filename = "mesaje/mesaje.txt";


$timestamp = date("d-m-Y H:i:s");
$content = "[$timestamp] $username: $message\n";


if (!file_exists($filename)) {
    if (!is_dir("mesaje")) {
        mkdir("mesaje");
    }
    file_put_contents($filename, $content);
} else {
    file_put_contents($filename, $content, FILE_APPEND);
}


header("Location: about.html");
exit;
?>
