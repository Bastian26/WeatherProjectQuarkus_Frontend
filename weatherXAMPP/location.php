<?php
// Diese Datei trägt in der Datenbank den ort ein, für den das gewünschte Wetter angezeigt werden soll 
include "db_connect.php";

$option = $_POST['locations'];

$statement = $pdo->prepare("UPDATE Location SET place = ? WHERE id = 1");
$statement->execute(array($option));

// Bringt einen auf die index.php Seite zurück
header('Location: index.php');

?>