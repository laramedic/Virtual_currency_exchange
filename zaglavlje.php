<?php
	include("baza.php");

	if (session_id() == "") session_start();
		$veza = spojiSeNaBazu();
		$trenutna = basename($_SERVER["PHP_SELF"]);
		$putanja = $_SERVER['REQUEST_URI'];
		$aktivni_korisnik = 0;
		$aktivni_korisnik_tip = -1;
		$aktivna_valuta = 6;

	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Virtualna mjenjačnica</title>
		<meta name="autor" content="Lara Medić"/>
		<meta charset="utf-8"/>
		<link href="css_stilovi.css" rel="stylesheet" type="text/css"/>
	</head>

	<body>
		<div class="content-banner">
	     <img src="images/logo-novi.jpg" alt="Logo" height="200px"class="img">

			 <span>
				 <?php
				 		if ($aktivni_korisnik === 0){
					 	echo "<p style='padding-left:124px'>Status: Anonimni/neregistrirani korisnik</p>";
				    }
				 		else {
					  echo "<p style='padding-left:124px'>Status: Dobrodošao u virtualnu mjenjačnicu, $aktivni_korisnik_ime!</p><br/>";
				 		}
				 ?>
			 </span>

		</div>

		<?php
			switch (true){
			case $trenutna:
			switch ($aktivni_korisnik_tip){
				case 0:
					echo '<ul id="nav">';
					echo '<li style="padding-left:10px" id="active1"><a class="active" href="index.php">Početna</a></li>';
					echo '<li><a href="o_autoru.html">O autoru</a></li>';
					echo '<li><a href="moja_sredstva.php">Moja sredstva</a></li>';
					echo '<li><a href="moji_zahtjevi.php">Moji zahtjevi</a></li>';
					echo '<li><a href="prihvati_zahtjev.php">Zahtjevi svih korisnika</a></li>';
					echo '<li><a href="korisnici.php">Korisnici</a></li>';
					echo '<li><a href="registracija.php">Registriraj korisnika</a></li>';
					echo '<li ><a href="dodaj_valutu.php">Dodaj valutu</a></li>';
					echo '<li ><a href="ukupno_prodane_valute.php">Ukupno prodane valute</a></li>';
					echo '<li style="float:right; padding-right:100px"><a href="prijavi_se.php?logout=1">Odjava</a></li>';
					echo '</ul>';
					break;

				case 1:
					echo '<ul id="nav">';
					echo '<li style="padding-left:294px"><a class="active" href="index.php">Početna</a></li>';
					echo '<li><a href="o_autoru.html">O autoru</a></li>';
					echo '<li><a href="moja_sredstva.php">Moja sredstva</a></li>';
					echo '<li><a href="moji_zahtjevi.php">Moji zahtjevi</a></li>';
					echo '<li><a href="prihvati_zahtjev.php">Zahtjevi korisnika</a></li>';
					echo '<li style="float:right; padding-right:280px"><a href="prijavi_se.php?logout=1">Odjava</a></li>';
					echo '</ul>';
					break;

				case 2:
					echo '<ul id="nav">';
					echo '<li style="padding-left:294px"><a class="active" href="index.php">Početna</a></li>';
					echo '<li><a href="o_autoru.html">O autoru</a></li>';
					echo '<li><a href="moja_sredstva.php">Moja sredstva</a></li>';
					echo '<li><a href="moji_zahtjevi.php">Moji zahtjevi</a></li>';
					echo '<li style="float:right; padding-right:280px"><a href="prijavi_se.php?logout=1">Odjava</a></li>';
					echo '</ul>';
					break;

				default:
					echo '<ul id="nav">';
				  echo '<li style="padding-left:294px"><a class="active" href="index.php">Početna</a></li>';
					echo '<li><a href="o_autoru.html">O autoru</a></li>';
					echo '<li style="float:right; padding-right:280px"><a href="prijavi_se.php">Prijava</a></li>';
					echo '</ul>';
					break;
					}

			default:
				break;
				}
	?>
