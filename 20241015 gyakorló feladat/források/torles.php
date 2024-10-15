<?php
// Kapcsolat létrehozása az adatbázissal
require_once 'kapcsolat.php';

// 29. Ha megkapjuk a törlendő kedvenc id-jét
if (isset($_GET['id'])) {
    // Az id lekérése és biztonságos kezelése
    $id = intval($_GET['id']); // biztosítjuk, hogy szám legyen

    // Törlés SQL lekérdezés
    $sql = "DELETE FROM cicak WHERE azonosito = $id";

    if (mysqli_query($dbconn, $sql)) {
        // Törlés sikeres, irányítás az index.php oldalra
        header("Location: index.php");
        exit(); // Megakadályozza a további kód végrehajtását
    } else {
        echo "Hiba történt a törlés során: " . mysqli_error($dbconn);
    }
} else {
    // Ha az id nem volt megadva, irányítás az index.php oldalra
    header("Location: index.php");
    exit();
}

// Kapcsolat lezárása
$dbconn->close();
?>
