<!DOCTYPE html>
<html>
<head>
    <title>Autentificare pentru Mausoleul de la Mateias</title>
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
        input[type="button"] {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="button"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Autentificare</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login_username">Utilizator:</label>
            <input type="text" name="login_username" id="login_username" required>

            <label for="login_password">Parola:</label>
            <input type="password" name="login_password" id="login_password" required>

            <input type="submit" value="Autentificare">

            
            <a href="register.php"><input type="button" value="Inregistrare"></a>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['login_username'];
            $password = $_POST['login_password'];

            if (!empty($username) && !empty($password)) {
                $conn = new mysqli("localhost", "root", "", "logare");

                if ($conn->connect_error) {
                    die("Conexiunea la baza de date a esuat: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT password FROM utilizatori WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $db_password = $row['password'];

                    if ($password === $db_password) {
                        
                        header("Location: index.html");
                        exit;
                    } else {
                        echo "<p class='error-message'>Autentificare esuata! Verificati numele de utilizator si parola.</p>";
                    }
                } else {
                    echo "<p class='error-message'>Autentificare esuata! Utilizatorul nu exista.</p>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<p class='error-message'>Completati toate campurile!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
