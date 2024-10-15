<?php
// 13. Kapcsolat létrehozása az adatbázissal
require_once 'kapcsolat.php'; 

// 14. SQL változó létrehozása
$sql = "SELECT * FROM cicak";

// 15. Eredmény változó létrehozása
$eredmeny = mysqli_query($dbconn, $sql);

// 16. Keresőmező kezelése
$keresett_allat = isset($_POST['kifejezes']) ? $_POST['kifejezes'] : '';

// Keresési feltétel
if ($keresett_allat) {
    $sql .= " WHERE cicanev LIKE '%$keresett_allat%' OR cicafajta LIKE '%$keresett_allat%'";
    $eredmeny = mysqli_query($dbconn, $sql);
}

// HTML kimenet kezdet
$output = '';

// 20. Ha nincs keresési feltétel, jelenítse meg az összes kártyát
if ($eredmeny && $eredmeny->num_rows > 0) {
    while ($row = $eredmeny->fetch_assoc()) {
        $output .= '
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <img src="kepek/' . htmlspecialchars($row['cicafoto']) . '" class="card-img-top" alt="' . htmlspecialchars($row['cicaneve']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['cicaneve']) . '</h5>
                    <h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row['cicakora']) . ' éves, ' . htmlspecialchars($row['cicafajta']) . '</h6>
                    <a href="torles.php?id=' . $row['azonosito'] . '" class="card-link">Törlés</a>
                </div>
            </div>
        </div>';
    }
} else {
    $output = '<h2>Nincs ilyen kedvenc!</h2>';
    $output .= '<a href="index.php">Vissza a kedvencekhez</a>';
}

// Kapcsolat lezárása
$dbconn->close(); 
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Saját CSS -->
    <link rel="stylesheet" href="../css/style.css">
    
    <title>Cicák</title>
</head>

<body>

<!-- Navigáció -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Cicák <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kapcsolat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="felvitel.php">Felvétel</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post">
            <input class="form-control mr-sm-2" type="search" id="kifejezes" name="kifejezes" placeholder="Keresés" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Keresés</button>
        </form>
    </div>
</nav>

<!-- Kártyák -->
<div class="container">
    <div class="row justify-content-md-center">   
        <?php print $output; ?>
    </div>
</div>

<!-- Bootstrap JS és jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
