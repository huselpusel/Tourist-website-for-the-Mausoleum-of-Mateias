<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervări</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Rezervari</h2>
    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Data Vizitei</th>
                <th>Ora Vizitei</th>
                <th>Numar de Bilete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $conn = new mysqli("localhost", "root", "", "rezervari");

            
            if ($conn->connect_error) {
                die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
            }

            
            $sql = "SELECT name, email, phone, visit_date, visit_time, tickets FROM rezervari";
            $result = $conn->query($sql);

            
            if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["visit_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["visit_time"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["tickets"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nu există rezervări înregistrate.</td></tr>";
            }

            
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
