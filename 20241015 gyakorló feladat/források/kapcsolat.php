<?php
// 1. Tartalom típus és karakterkódolás beállítása
header('Content-Type: text/html; charset=utf-8');

define("DBHOST","localhost");
define("DBUSER","root");
define("DBPASS","");
define("DBNAME","cicak");

$dbconn = @mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Hiba az adatbázis csatlakozásakor!");

mysqli_query($dbconn, "SET NAMES utf8");
?>
