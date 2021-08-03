<?php
	include("zaglavlje.php");
	include_once("baza.php");
	$veza = spojiSeNaBazu();
	$upit = "SELECT * FROM valuta";
	$rezultat = izvrsiUpit($veza, $upit);
?>

<body>
<div id="nav1">

	<h2 style="padding-left:10px">Valute</h2>
	<p style="padding-left:10px">Dobro došli u virtualnu mjenjačnicu!<br>Povucite mišem preko valute za prikaz informacija o tečaju.</p>

			<?php
				if (isset($rezultat)) {
					while ($row = mysqli_fetch_array($rezultat)) {
						echo "<div class=gallery>";
							echo "<div class=flip-card>";
								echo "<div class=flip-card-inner>";
									echo "<div class=flip-card-front>";
										echo "<img src=\"" . $row[4] . "\" alt=" . $row[2] . " height=200 class=img>";
									 	echo "<p>" . $row[2] . "</p>";
									  echo "</div>";
											echo "<div class=flip-card-back>";
												echo "<h2>" . $row[2] . "</h2>";
												echo " <p>Tečaj: " . $row[3] . "</p>";
												if(!empty($row[5])) {
														echo "<p>Himna: <a href="  . $row[5] . " style='color:white' target='_blank'>Pokreni</a></p>";
													}
													if (isset($aktivni_korisnik_id)) {
													if($aktivni_korisnik_tip==0){
														 echo "<a href='azuriranje_valute.php?id=" . $row[0] . "'><p>Azuriraj</p></a>";
													}
													else if($aktivni_korisnik_id==$row[1]){
														echo "<a href='azuriranje_tecaja.php?id=" . $row[0] . "'><p>Azuriraj</p></a>";
												   }
												}
											echo "</div>";
										echo "</div>";
									echo "</div>";
								echo "</div>";

					}
				} else {
					echo "<p>Greška pri dohvaćanju rezultata iz baze podataka." . $upit .  "</p>";
				}
			?>
</div>

<?php
	include("podnozje.php");
?>
