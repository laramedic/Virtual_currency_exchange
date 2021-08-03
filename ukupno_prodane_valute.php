<?php
include("zaglavlje.php");
include_once("baza.php");
$veza = spojiSeNaBazu();

if (isset($_GET["submit"])) {
	$moderator_id = $_GET["moderator_id"];
	$upit = "SELECT v.naziv, SUM(z.iznos) as ukupno_prodani_iznos FROM valuta v, zahtjev z
		WHERE v.valuta_id=z.prodajem_valuta_id AND z.prihvacen=1 AND moderator_id='{$moderator_id}'
	    GROUP BY v.valuta_id ORDER BY ukupno_prodani_iznos DESC";
	$rezultat = izvrsiUpit($veza, $upit);
}
?>

<body>
	<div id="nav1">
		<h3 style="text-align: center;">Ukupno prodane valute</h3>

		<form id="noviZahtjevObrazac" name="obrazac" method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

			<section>
				<label><b>Moderator:</b></label>
				<select name="moderator_id">
					<?php
					$upit2 = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1";
					$rezultat2 = izvrsiUpit($veza, $upit2);
					while ($row = mysqli_fetch_array($rezultat2)) {
						echo "<option value='{$row[0]}'";
						echo ">{$row[4]}" . " {$row[5]}</option>";
					}
					?>
				</select>

				<button class="submit" name="submit" type="submit">Pretraži nove zahtjeve</button>

		</form>
		</section>


		<table style="margin-left:auto; margin-right:auto;">
			<thead>
				<tr>
					<th>Naziv valute</th>
					<th>Ukupni iznos</th>
				</tr>
			</thead>
			<tbody>

				<?php
				if (isset($_GET["submit"])) {
					while ($row2 = mysqli_fetch_array($rezultat)) {
						echo "<tr>";
						echo "<td>{$row2[0]}</td>";
						echo "<td>{$row2[1]}</td>";
						echo "</tr>";
					}
				}
				?>

			</tbody>
		</table>
		<br><br><br>

		<h3 style="text-align: center;">Ukupno prodane valute u odnosu vremena</h3>
		<div class="forms">

			<form id="ukupno_prodane_valute" name="ukupno_prodane_valute" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
				<label><b>Voditelj:</b></label>
				<select name="modValute">
					<?php
					$upit = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1";
					$rezultat = izvrsiUpit($veza, $upit);
					while ($row = mysqli_fetch_array($rezultat)) {
						echo "<option value='{$row["korisnik_id"]}'";

						echo ">{$row["korisnicko_ime"]}</option>";
					}
					?>
				</select> <br>
				<label><b>Vrijeme od:</b></label>
				<input type="text" id="vrijemeOd" name="vrijemeOd" placeholder="d-m-Y H:i:s"> <br>
				<label><b>Vrijeme do:</b></label>
				<input type="text" id="vrijemeDo" name="vrijemeDo" placeholder="d-m-Y H:i:s"> <br>
				<button type="submit" id="submitSuma" name="submitSuma">Pretraži</button>
			</form>
		</div>
		<?php
		if (isset($_POST["submitSuma"])) {
			$moderator = $_POST["modValute"];
			$vrijemeOd = $_POST["vrijemeOd"];
			$vrijemeDo = $_POST["vrijemeDo"];
			$date1 = strtotime($vrijemeOd);
			$date1 = date("Y-m-d H:i:s", $date1);
			$date2 = strtotime($vrijemeDo);
			$date2 = date("Y-m-d H:i:s", $date2);
			$greska = "";
			if (!isset($vrijemeOd) || empty($vrijemeOd)) {
				$greska .= "Niste unijeli aktivno od! <br>";
			}
			if (!isset($vrijemeDo) || empty($vrijemeDo)) {
				$greska .= "Niste unijeli aktivno do! <br>";
			}
			if (empty($greska)) {
		?>
				<table style="margin-left:auto; margin-right:auto;">
					<thead>
						<tr>
							<th>Valuta</th>
							<th>Suma</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$upit = "SELECT v.naziv, SUM(z.iznos) as ukupno_prodani_iznos FROM valuta v, zahtjev z
						WHERE v.valuta_id=z.prodajem_valuta_id AND z.prihvacen=1 AND moderator_id = $moderator
						AND datum_vrijeme_kreiranja BETWEEN '$date1' AND '$date2'
						GROUP BY v.valuta_id ORDER BY ukupno_prodani_iznos DESC";
						$rez = izvrsiUpit($veza, $upit);
						while ($row = mysqli_fetch_array($rez)) {
							echo "<tr>";
							echo "<td>{$row[0]}</td>";
							echo "<td>{$row[1]}</td>";
							echo "
						<tr>";
						}
						?>
					</tbody>
				</table>
		<?php
			}
		}
		if (isset($greska)) {
			echo "<p>$greska</p>";
		}
		if (isset($poruka)) {
			echo "<p>$poruka</p>";
		}
		?>
	</div>
	<?php

	include("podnozje.php");
	?>