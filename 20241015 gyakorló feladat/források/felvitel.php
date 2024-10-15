<?php
// Kapcsolat létrehozása az adatbázissal
require_once 'kapcsolat.php';

// Hibák tömbje
$hibak = [];

// űrlap feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allatnev = trim($_POST['allatnev']);
    $fajta = trim($_POST['fajta']);
    $kora = trim($_POST['kora']);
    
    // Hibák ellenőrzése
    if (empty($allatnev)) {
        $hibak[] = "Nem adtad meg kedvenced nevét!";
    } elseif (strlen($allatnev) < 2) {
        $hibak[] = "Biztos, hogy egy betű kedvenced neve?";
    }
    
    if (empty($fajta)) {
        $hibak[] = "Nem adtad meg kedvenced fajtáját!";
    }
    
    if (empty($kora) || !is_numeric($kora)) {
        $hibak[] = "Nem adtad meg kedvenced korát!";
    }
    
    // Fájl kezelése
    if (isset($_FILES['foto'])) {
        $maxFileSize = 2000000; // 2MB
        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
        $file = $_FILES['foto'];

        if ($file['size'] > $maxFileSize) {
            $hibak[] = "Túl nagy méretű képet töltöttél fel!";
        }

        if (!in_array($file['type'], $allowedMimeTypes)) {
            $hibak[] = "Nem megfelelő képformátum!";
        }

        // Fájl név készítése
        $fileName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $tempPath = $file['tmp_name'];
        $finalPath = "kepek/" . $fileName;

        // Fájl mozgatása
        if (empty($hibak) && !move_uploaded_file($tempPath, $finalPath)) {
            $hibak[] = "Hiba történt a fájl feltöltésekor!";
        }
    }

    // Ha nincsenek hibák, mentés az adatbázisba
    if (empty($hibak)) {
        // Nagybetűvel kezdődik, kisbetűs lesz
        $allatnev = ucfirst(strtolower($allatnev));
        
        $sql = "INSERT INTO cicak (cicafoto, cicaneve, cicafajta, cicakora) VALUES ('$fileName', '$allatnev', '$fajta', $kora)";
        
        if (mysqli_query($dbconn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            $hibak[] = "Hiba történt az adatbázis mentésekor: " . mysqli_error($dbconn);
        }
    }
}

// HTML rész
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Saját CSS -->
    <link rel="stylesheet" href="../css/style.css">
    
    <title>Kedvencek felvitele</title>
</head>
<body>
    <div class="container">
        <div class="form-container mt-5">
            <h1>Kedvenc kisállat felvitele:</h1>

            <?php if (!empty($hibak)): ?>
                <ul class="list-group mb-4">
                    <?php foreach ($hibak as $hiba): ?>
                        <li class="list-group-item list-group-item-danger"><?php echo htmlspecialchars($hiba); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                
                <div class="form-group">
                    <label for="allatnev">Állat neve:</label>
                    <input type="text" id="allatnev" name="allatnev" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fajta">Fajta:</label>
                    <input type="text" id="fajta" name="fajta" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kora">Kor:</label>
                    <input type="number" id="kora" name="kora" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="foto">Kép feltöltése:</label>
                    <input type="file" id="foto" name="foto" accept="image/jpeg, image/gif, image/png" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Küldés</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>

            <a href="index.php" class="btn btn-link mt-4">Vissza a főoldalra</a>
        </div>
    </div>

    <!-- Bootstrap JS és jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
