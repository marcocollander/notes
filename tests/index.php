<?php
$host = '127.0.0.1';
$db = 'notes';  // Nazwa twojej bazy danych
$user = 'user_notes';     // Twoja nazwa użytkownika
$pass = ']Jmw7VD-.-B!Utnc';     // Twoje hasło
$port = 8889;                // Port, przez który się łączysz

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    // Utworzenie nowej instancji PDO
    $pdo = new PDO($dsn, $user, $pass);
    // Ustawienie trybu błędów na tryb wyjątku
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Połączenie z bazą danych powiodło się!";
} catch (PDOException $e) {
    echo "Połączenie z bazą danych nie powiodło się: " . $e->getMessage();
}


