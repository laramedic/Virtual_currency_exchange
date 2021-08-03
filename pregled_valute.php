<?php
	include("zaglavlje.php");
	include_once("baza.php");
	$veza = spojiSeNaBazu();
	$valuta = $_GET["id"];
	$upit = "SELECT * FROM valuta WHERE valuta_id = $valuta";
	$rezultat = izvrsiUpit($veza, $upit);

	$upit2 = "SELECT * FROM valuta WHERE valuta_id = $valuta";
	$rezultat2 = izvrsiUpit($veza, $upit2);
	$moderator_id = mysqli_fetch_array($rezultat2);
?>

	<body>
		<h1>Pregled valute</h1>
			<div>
				<?php
					if (isset($rezultat)) {
						while ($row = mysqli_fetch_array($rezultat)) {
							echo "<p>".$row[2]."</p>";
							echo "<p>".$row[3]."</p>";
							echo "<img src=\"" .$row[4]. "\">";

						if(strlen($row[5]) > 0) {
									echo "<audio controls='controls'>
											<source src=\"" . $row[5] . "\"/>
										</audio>";
							}
							if($aktivni_korisnik_id == $moderator_id[1]){
								echo "<p><a href='azuriranje_valte.php?id={$valuta}'>Ažuriraj</a></p>";
							}else if($aktivni_korisnik_id == 1) {
								echo "<p><a href='azuriranje_valute.php?id={$valuta}'>Ažuriraj</a></p>";
							}
						}
					}
				?>
			</div>
<?php
	include("podnozje.php");
?>
