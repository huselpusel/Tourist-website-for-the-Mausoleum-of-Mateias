<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $tickets = $_POST['tickets'];

    

    
    $conn = new mysqli("localhost", "root", "");

    
    if ($conn->connect_error) {
        die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
    }

    
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS rezervari";
    if ($conn->query($sql_create_db) === FALSE) {
        die("Eroare la crearea bazei de date: " . $conn->error);
    }

    
    $conn->select_db("rezervari");

    
    $sql_create_table = "CREATE TABLE IF NOT EXISTS rezervari (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        visit_date DATE NOT NULL,
        visit_time TIME NOT NULL,
        tickets INT NOT NULL
    )";
    if ($conn->query($sql_create_table) === FALSE) {
        die("Eroare la crearea tabelului: " . $conn->error);
    }

    
    $stmt = $conn->prepare("INSERT INTO rezervari (name, email, phone, visit_date, visit_time, tickets) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $email, $phone, $date, $time, $tickets);

    if ($stmt->execute()) {
        echo "<h2>Rezervare inregistrata cu succes!</h2>";
        echo "<p>Nume: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Telefon: $phone</p>";
        echo "<p>Data Vizitei: $date</p>";
        echo "<p>Ora Vizitei: $time</p>";
        echo "<p>Numar de Bilete: $tickets</p>";
    } else {
        echo "Eroare la inregistrarea rezervării: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    
    echo "Acces interzis!";
}
?>
