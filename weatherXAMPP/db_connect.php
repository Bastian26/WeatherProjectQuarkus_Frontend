<?php
//Verbindung mit der mysql db in docker container herstllen auf dem port 3310 und die db "weather", user = root, pw = root
//                                                          user=root, password=root
try {
	$pdo = new PDO('mysql:host=localhost:3310;dbname=weather', 'root', 'root',array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
	)
	);
	//echo "Connected successfully";  // Wird bei erfolgreicher Verbindung ausgegeben
} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>