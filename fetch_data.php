<?php
$servername = "127.0.0.1";
$username = "coachbimbaj";
$password = "AraujoTopCB1";
$dbname = "coachbimbaj";

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zapytanie SQL do pobrania danych
$sql = "SELECT nick, vip FROM Vipdnia";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Tablica, do której będą dodawane wiersze
    $rows = array();

    // Pobieranie danych z wyniku zapytania
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Zwracanie danych jako JSON
    echo json_encode($rows);
} else {
    echo "0 results";
}

// Zamykanie połączenia
$conn->close();
?>
