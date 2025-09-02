<!DOCTYPE html>
<html>
<head>
    <title>Inregistrare pentru Mausoleul de la Mateias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #ff0000;
            margin-bottom: 10px;
        }
        .success-message {
            color: #008000;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inregistrare</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="reg_username">Utilizator:</label>
            <input type="text" name="reg_username" id="reg_username" required>

            <label for="reg_password">Parola:</label>
            <input type="password" name="reg_password" id="reg_password" required>

            <input type="submit" value="Inregistrare">
        </form>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['reg_username'];
    $password = $_POST['reg_password'];

    if (empty($username) || empty($password)) {
        echo "<p>Completati toate campurile!</p>";
    } else {
        $conn = new mysqli("localhost", "root", "");

        if ($conn->connect_error) {
            die("Conexiunea a esuat: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS logare";
        $conn->query($sql);

        $conn->close();

        $conn = new mysqli("localhost", "root", "", "logare");

        if ($conn->connect_error) {
            die("Conexiunea la baza de date a esuat: " . $conn->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS utilizatori (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";
        $conn->query($sql);

        $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p>Utilizatorul cu acest nume exista deja!</p>";
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO utilizatori (username, password) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $username, $password);

            if ($stmt_insert->execute()) {
                echo "<p>Contul a fost creat cu succes!</p>";
                // Redirect to the login page
                header("Location: login.php");
                exit(); // Ensure that no other content is sent after the header
            } else {
                echo "<p>Eroare la crearea contului: " . $stmt_insert->error . "</p>";
            }

            $stmt_insert->close();
        }

        $stmt->close();
        $conn->close();
    }
}
?>


    </div>
</body>
</html>
