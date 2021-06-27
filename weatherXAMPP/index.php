<?php
include "db_connect.php";

// Holt heutigen timestamp
$timestamp = time();
$datum = date("d.m.Y - H:i", $timestamp);

// Speichert den heutigen Tag ausgeschrieben in Englisch (z.B. Monday)
$day = date('l', $timestamp);
$wochentagZahl = -1;

//Tag aus der DB in Deutsch umändern (z.B. Monday -> Montag)
switch ($day) {
	case "Monday":
		$wochentagZahl = 1;
		$day = "Montag";
        break;
	case "Tuesday":
		$wochentagZahl = 2;
		$day = "Dienstag";
        break;
	case "Wednesday":
		$wochentagZahl = 3;
        $day = "Mittwoch";
		break;
	case "Thursday":
		$wochentagZahl = 4;
		$day = "Donnerstag";
		break;
	case "Friday":
		$wochentagZahl = 5;
		$day = "Freitag";
		break;
	case "Saturday":
		$wochentagZahl = 6;
		$day = "Samstag";
		break;
	case "Sunday":
		$wochentagZahl = 7;
		$day = "Sonntag";
		break;
}

//Funktion, die je nach Wetter (kommt aus der DB aus "main" und "description") das geeignete Icon dem HTML zurück gibt
function wetterIconAuswahl($mainDescription, $description){
	$mainDescriptionIcon = "error";
	switch ($mainDescription) {
		//Clouds
		case "Clouds":
			switch  ($description){
				//Leicht bewölkt
				case "few clouds":
					$mainDescriptionIcon = "images/icons/icon-5.svg";
					break;
				case "scattered clouds":
					$mainDescriptionIcon = "images/icons/icon-5.svg";
					break;
				//Mittel bis stark bewölkt
				case "broken clouds":
					$mainDescriptionIcon = "images/icons/icon-6.svg";
					break;
				case "overcast clouds":
					$mainDescriptionIcon = "images/icons/icon-6.svg";
					break;
			}
			break;
		//Clear
		case "Clear":
			$mainDescriptionIcon = "images/icons/icon-1.svg";
			break;
		//Atmosphere
		case "Mist":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Smoke":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Haze":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Dust":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Fog":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Sand":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Ash":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Squall":
			$mainDescriptionIcon = "images/icons/icon-7.svg";
			break;
		case "Tornado":
			$mainDescriptionIcon = "images/icons/icon-8.svg";
			break;
		//Snow
		case "Snow":
			$mainDescriptionIcon = "images/icons/icon-14.svg";
			break;
		//Rain
		case "Rain":
			switch  ($description){
				//Leicht bewölkt
				case "light rain":
					$mainDescriptionIcon = "images/icons/icon-9.svg";
					break;
				case "moderate rain":
					$mainDescriptionIcon = "images/icons/icon-9.svg";
					break;
				//Mittel bis stark bewölkt
				case "heavy intensity rain":
					$mainDescriptionIcon = "images/icons/icon-10.svg";
					break;
				case "very heavy rain":
					$mainDescriptionIcon = "images/icons/icon-10.svg";
					break;
				case "extreme rain":
					$mainDescriptionIcon = "images/icons/icon-10.svg";
				break;
				case "freezing rain":
					$mainDescriptionIcon = "images/icons/icon-13.svg";
					break;
				case "light intensity shower rain":
					$mainDescriptionIcon = "images/icons/icon-9.svg";
					break;
				case "shower rain":
					$mainDescriptionIcon = "images/icons/icon-9.svg";
					break;
				case "heavy intensity shower rain":
					$mainDescriptionIcon = "images/icons/icon-10.svg";
					break;
				case "ragged shower rain":
					$mainDescriptionIcon = "images/icons/icon-10.svg";
					break;
			}
			break;
		//Drizzle
		case "Drizzle":
			$mainDescriptionIcon = "images/icons/icon-4.svg";
			break;
		//Thunderstorm
		case "Thunderstorm":	
			//Man könnte auch "images/icons/icon-11.svg" nehmen, da ist nur ein Blizu zu sehen
			$mainDescriptionIcon = "images/icons/icon-11.svg";
			break;

	}
	return $mainDescriptionIcon;
}

//gibt den letzten (aktuellsten) Reihe aus
$statement = $pdo->prepare("SELECT * FROM CurrentWeatherReworked ORDER BY id DESC LIMIT 1"); 
$statement->execute(array(1));     
$currentWeather = $statement->fetchAll(PDO::FETCH_ASSOC);
//print_r($currentWeather);  // TESTEN, ob DB auch erkannt wurde und die Daten vorhanden sind   

// Tag 1 (Morgen)     //DailyWeatherReworked_Day1 kommt nicht, weil das hier durch CurrentWeaherReworked erfüllt wird (aktuelles/dertzeitiges, Tageswetter wird bei CurrentWeatehrReworked ausgelassen)
$statement1 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day2 ORDER BY idDaily DESC LIMIT 1"); 
$statement1->execute(array(1));    
$dailyWeatherReworked_Day1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
//print_r($dailyWeatherReworked_Day1);  // TESTEN, ob DB auch erkannt wurde und die Daten vorhanden sind   

// Tag 2 (Übermorgen)
$statement2 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day3 ORDER BY idDaily DESC LIMIT 1"); 
$statement2->execute(array(1));    
$dailyWeatherReworked_Day2 = $statement2->fetchAll(PDO::FETCH_ASSOC);

// Tag 3 (usw ...)
$statement3 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day4 ORDER BY idDaily DESC LIMIT 1"); 
$statement3->execute(array(1));    
$dailyWeatherReworked_Day3 = $statement3->fetchAll(PDO::FETCH_ASSOC);

// Tag 4
$statement4 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day5 ORDER BY idDaily DESC LIMIT 1"); 
$statement4->execute(array(1));   
$dailyWeatherReworked_Day4 = $statement4->fetchAll(PDO::FETCH_ASSOC);

// Tag 5
$statement5 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day6 ORDER BY idDaily DESC LIMIT 1"); 
$statement5->execute(array(1));    
$dailyWeatherReworked_Day5 = $statement5->fetchAll(PDO::FETCH_ASSOC);

// Tag 6
$statement6 = $pdo->prepare("SELECT * FROM DailyWeatherReworked_Day7 ORDER BY idDaily DESC LIMIT 1"); 
$statement6->execute(array(1));   
$dailyWeatherReworked_Day6 = $statement6->fetchAll(PDO::FETCH_ASSOC);

// Location (Ort)
$statement7 = $pdo->prepare("SELECT * FROM Location"); 
$statement7->execute(array(1));   
$location = $statement7->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		<title>Aktuelles Wetter</title> 
		<!-- Lädt die Main-Css-Datei -->
		<link rel="stylesheet" href="styl.css">
	</head>
	<body>  <!-- Kann hier im moment nur über inline CSS verändern style="background-color:#bcd2e6;"   -->
		<div class="site-content">
			<header>
				
			</header>
			<main class="forecast-table">
				<div class="container" style="min-width: 1500px;">
					<div class="forecast-container">
						<div class="today forecast">
							<div class="forecast-header">
								<!-- Heutiger Tag (das aktuelle/momentane Wetter) -->
								<div class="day">
									<?php
										echo $day
									?>
								</div>
								<div class="date"><?php echo $datum ?></div>  <!-- alternative  z.B 6 Okt  (Oct)  -->
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="location">
								<!-- Zeigt Location an (Wenn Null, dann leerer String-->
								<?php 
									echo $location[0]["place"];
								?>
								</div> 
								<div class="degree">
									<div class="num">
										<!-- momentane Temperatur in Celsius-->
										<?php 
										$resultTempCurrent = $currentWeather[0]["temp"];
										echo number_format($resultTempCurrent, 0, '.', '');  //Runden auf 2 Nachkommastllen wäre) echo number_format($result, 2, '.', ''); 
										?>  
										<sup>o</sup>C <!-- Grad Celsius Ausgabe -->
									</div>  
									<!-- Das Icon muss erst herausgefunden werden anhand von den Attributen description/main in der DB --> 
									<div class="forecast-icon">
										<!-- Zeigt ein Icon für den heutigen Tag an -->
										<img src=
										<?php
										echo wetterIconAuswahl($currentWeather[0]["main"],$currentWeather[0]["description"]);
										?>
										alt="" width=90 class="todayForecastIcon">
									</div>	
								</div>
								<!-- Luftfeuchtigkeit (humidity) -->
								<span><img src="images/humidityReworked.png" alt="" class="miniIcon">
								<?php
									$resultHumidityToday = $currentWeather[0]["humidity"];  
									echo $resultHumidityToday;
								?>
								%</span>
								<span><img src="images/icon-wind.png" alt="" class="miniIcon">
								<!-- Windgeschwindigkeit -->
								<?php 
									$resultWindToday = $currentWeather[0]["windSpeed"];  // Wird von m/s in Km/h umgewandelt
									$resultWindToday = $resultWindToday * 3.6;
									echo number_format($resultWindToday, 0, '.', ''); //Runden
								?> 
								km/h</span>
								<!-- Windrichtung -->
								<span><img src="images/icon-compass.png" alt="" class="miniIcon">
								<?php
								//Die Gradzahl aus der Db (z.B 180) wird in eine Richtung (ausgeschrieben) umgewandelt (z.B. Osten)
								$WindrichtungAusgabe;

								$degreeWindToday = $currentWeather[0]["windDeg"];
								if ($degreeWindToday == 0 || $degreeWindToday == 0) {
									$WindrichtungAusgabe = "Norden";
								} elseif ($degreeWindToday > 0 && $degreeWindToday <90) {
									$WindrichtungAusgabe = "Nordosten";
								} elseif ($degreeWindToday == 90) {
									$WindrichtungAusgabe = "Osten";
								} elseif ($degreeWindToday > 90 && $degreeWindToday < 180) {
									$WindrichtungAusgabe = "Südosten";
								} elseif ($degreeWindToday == 180) {
									$WindrichtungAusgabe = "Süden";
								} elseif ($degreeWindToday > 180 && $degreeWindToday < 270) {
									$WindrichtungAusgabe = "Südwesten";
								} elseif ($degreeWindToday == 270) {
									$WindrichtungAusgabe = "Westen";
								} elseif ($degreeWindToday > 270 && $degreeWindToday < 360) {
									$WindrichtungAusgabe = "Nordwest";
								} 
								echo $WindrichtungAusgabe; 
								?>
								</span>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 1. Tag (Morgen) -->
									<?php 
									$day1 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day1 = "Dienstag";
										break;
									case 2:
										$day1 = "Mittwoch";
										break;
									case 3:
										$day1 = "Donnerstag";
										break;
									case 4:
										$day1 = "Freitag";
										break;
									case 5:
										$day1 = "Samstag";
										break;
									case 6:
										$day1 = "Sonntag";
										break;
									case 7:
										$day1 = "Montag";
										break;
									}
									echo $day1;   
									// Die nächsten Tage werden genau nach dem gleichen Prinzip weiter gemacht
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<!-- Zeigt icon an von dem 1.Tag (Morgen) -->
									<img src=
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day1[0]["main"],$dailyWeatherReworked_Day1[0]["description"]);
									?>
									 alt="" width=48 class="dailyForecastIcon">
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 1. Tages -->
										<?php
										$resultTempMaxDay1 = $dailyWeatherReworked_Day1[0]["max"];
										echo number_format($resultTempMaxDay1, 0, '.', '');  //Runden auf 2 Nachkommastellen
										?>
									<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 2. Tages -->
										<?php
										$resultTempMinDay1 = $dailyWeatherReworked_Day1[0]["min"];
										echo number_format($resultTempMinDay1, 0, '.', '');  //Runden auf 2 Nachkommastellen
										?>
										<sup>o</sup>
									</div>
								<!--C  Wenn man Celsius in min angezeigt bekommen möchte -->
								</small>
								<small>	
									<?php
									//echo $dailyWeatherReworked_Day1[0]["description"];  //Entkommentieren, wenn man unter MIN nochmal die genaue Beschreibung des Tages anzeigen lassen möchte
									?>
								</small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 2. Tag (Übermorgen) -->
									<?php 
									$day2 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day2 = "Mittwoch";
										break;
									case 2:
										$day2 = "Donnerstag";
										break;
									case 3:
										$day2 = "Freitag";
										break;
									case 4:
										$day2 = "Samstag";
										break;
									case 5:
										$day2 = "Sonntag";
										break;
									case 6:
										$day2 = "Montag";
										break;
									case 7:
										$day2 = "Dienstag";
										break;
									}
									echo $day2;   
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
								<!-- Zeigt icon für den 2.Tag (Übermorgen) -->
									<img src=
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day2[0]["main"],$dailyWeatherReworked_Day2[0]["description"]);
									?>
									 alt="" width=48 class="dailyForecastIcon"> 
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 2. Tages -->
										<?php
										$resultTempMaxDay2 = $dailyWeatherReworked_Day2[0]["max"];
										echo number_format($resultTempMaxDay2, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 2. Tages -->
										<?php
										$resultTempMinDay2 = $dailyWeatherReworked_Day2[0]["min"];
										echo number_format($resultTempMinDay2, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>
									</div>
								</small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 3. Tag -->
									<?php 
									$day3 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day3 = "Donnerstag";
										break;
									case 2:
										$day3 = "Freitag";
										break;
									case 3:
										$day3 = "Samstag";
										break;
									case 4:
										$day3 = "Sonntag";
										break;
									case 5:
										$day3 = "Montag";
										break;
									case 6:
										$day3 = "Dienstag";
										break;
									case 7:
										$day3 = "Mittwoch";
										break;
									}
									echo $day3;   
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<!-- ICON für den 3. Tag-->
									<img src=
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day3[0]["main"],$dailyWeatherReworked_Day3[0]["description"]);
									?>
									 alt="" width=48 class="dailyForecastIcon">
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 3. Tages -->
										<?php
										$resultTempMaxDay3 = $dailyWeatherReworked_Day3[0]["max"];
										echo number_format($resultTempMaxDay3, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 3. Tages -->
										<?php
										$resultTempMinDay3 = $dailyWeatherReworked_Day3[0]["min"];
										echo number_format($resultTempMinDay3, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>
									</div>
								</small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 4. Tag -->
									<?php 
									$day4 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day4 = "Freitag";
										break;
									case 2:
										$day4 = "Samstag";
										break;
									case 3:
										$day4 = "Sonntag";
										break;
									case 4:
										$day4 = "Montag";
										break;
									case 5:
										$day4 = "Dienstag";
										break;
									case 6:
										$day4 = "Mittwoch";
										break;
									case 7:
										$day4 = "Donnerstag";
										break;
									}
									echo $day4;   
									// Nächsten Tag genau nach dem Prinzip weiter machen
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<!--  ICON für den 4. Tag -->
									<img src=
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day4[0]["main"],$dailyWeatherReworked_Day4[0]["description"]);
									?>
									 alt="" width=48 class="dailyForecastIcon">
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 4. Tages -->
										<?php
										$resultTempMaxDay4 = $dailyWeatherReworked_Day4[0]["max"];
										echo number_format($resultTempMaxDay4, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 4. Tages -->
										<?php
										$resultTempMinDay4 = $dailyWeatherReworked_Day4[0]["min"];
										echo number_format($resultTempMinDay4, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>
									</div>
								</small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 5. Tag -->
									<?php 
									$day5 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day5 = "Samstag";
										break;
									case 2:
										$day5 = "Sonntag";
										break;
									case 3:
										$day5 = "Montag";
										break;
									case 4:
										$day5 = "Dienstag";
										break;
									case 5:
										$day5 = "Mittwoch";
										break;
									case 6:
										$day5 = "Donnerstag";
										break;
									case 7:
										$day5 = "Freitag";
										break;
									}
									echo $day5;   
									// Nächsten Tag genau nach dem Prinzip weiter machen
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<!--  ICON für den 5. Tag-->
									<img src=
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day5[0]["main"],$dailyWeatherReworked_Day5[0]["description"]);
									?>
									alt="" width=48 class="dailyForecastIcon">
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 5 tages -->
										<?php
										$resultTempMaxDay5 = $dailyWeatherReworked_Day5[0]["max"];
										echo number_format($resultTempMaxDay5, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 5 tages -->
										<?php
										$resultTempMinDay5 = $dailyWeatherReworked_Day5[0]["min"];
										echo number_format($resultTempMinDay5, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>
									</div>
								</small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">
									<!-- 6. Tag -->
									<?php 
									$day6 = "Error";
									switch ($wochentagZahl) {
									case 1:
										$day6 = "Sonntag";
										break;
									case 2:
										$day6 = "Montag";
										break;
									case 3:
										$day6 = "Dienstag";
										break;
									case 4:
										$day6 = "Mittwoch";
										break;
									case 5:
										$day6 = "Donnerstag";
										break;
									case 6:
										$day6 = "Freitag";
										break;
									case 7:
										$day6 = "Samstag";
										break;
									}
									echo $day6;   
									// Nächsten Tag genau nach dem Prinzip weiter machen
									?>
								</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<!-- ICON für den 6. Tag-->
									<img src= 
									<?php
									echo wetterIconAuswahl($dailyWeatherReworked_Day6[0]["main"],$dailyWeatherReworked_Day6[0]["description"]);
									?>
									alt="" width=48 class="dailyForecastIcon">
								</div>
								<div class="degree">
									<div class="degreeDays">
										<!-- Grad Celsius MAX des 6 tages -->
										<?php
										$resultTempMaxDay6 = $dailyWeatherReworked_Day6[0]["max"];
										echo number_format($resultTempMaxDay6, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>C
									</div>
								</div>
								<small>
									<div class="minDaily">
										<!-- Grad Celsius MIN des 6 tages -->
										<?php
										$resultTempMinDay6 = $dailyWeatherReworked_Day6[0]["min"];
										echo number_format($resultTempMinDay6, 0, '.', '');  //Runden auf 2 Nachkommastllen
										?>
										<sup>o</sup>
									</div>
								</small>
							</div>
						</div>
					</div>
				</div>
			</main> <!-- .main-content -->

			<footer class="site-footer">
				<div class="container">	
					<p class="colophon">Aktuelles Wetter <?php echo $location[0]["place"] ?></p>
				</div>
				<div class="container">
					<form method="post" action="location.php">
						<label for="locations">Wählen Sie eine Stadt:</label>
						<select name="locations" id="locations">
							<option selected value="Berlin">Berlin</option>
							<option value="Hamburg">Hamburg</option>
							<option value="Frankfurt">Frankfurt</option>
							<option value="Hannover" selected>Hannover</option>
							<option value="München" selected>München</option>
							<option value="Köln" selected>Köln</option>
						</select> 
						<input id="formBtn" type="submit" value="Daten abfragen">
					</form>
				</div>
			</footer> <!-- .site-footer  -->
		</div>
		
	</body>

</html>