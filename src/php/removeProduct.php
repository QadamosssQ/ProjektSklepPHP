<?php

// Połączenie z bazą danych
require "conn.php";

// Sprawdzenie, czy przekazano identyfikator produktu
if (isset($_GET['id'])) {
    // Przechwycenie identyfikatora produktu z parametru GET
    $productId = $_GET['id'];

    // Zapytanie SQL do usunięcia produktu z bazy danych
    $sql = "DELETE FROM samoloty WHERE id = $productId";

    // Wykonanie zapytania
    if (mysqli_query($conn, $sql)) {
        // Jeśli zapytanie wykonane pomyślnie, zwróć odpowiedź sukcesu
        echo "Product removed successfully";
    } else {
        // Jeśli wystąpił błąd podczas wykonywania zapytania, zwróć odpowiedź błędu
        echo "Error removing product: " . mysqli_error($conn);
    }
} else {
    // Jeśli nie przekazano identyfikatora produktu, zwróć odpowiedź błędu
    echo "Product ID not provided";
}

// Zamknięcie połączenia z bazą danych
mysqli_close($conn);

