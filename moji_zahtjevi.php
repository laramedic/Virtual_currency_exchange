	<?php
	include("zaglavlje.php");
	include_once("baza.php");
	$veza = spojiSeNaBazu();
	$upit = "SELECT *FROM zahtjev WHERE korisnik_id = '{$aktivni_korisnik_id}'";
	$rezultat = izvrsiUpit($veza, $upit);

	if (isset($_POST["submit"])) {
		$datum = date("Y-m-d H:i:s");
		$iznos = $_POST["iznos"];
		$kupujem = $_POST["kupujem"];
		$prodajem = $_POST["prodajem"];
		$greska = "";

		if (!isset($iznos) || empty($iznos)) {
			$greska .= "Niste unijeli iznos! Molimo Vas da unesete iznos.<br>";
		}
		if (!isset($prodajem) || empty($prodajem)) {
			$greska .= "Niste unijeli valutu! Molimo Vas da unesete valutu.<br>";
		}
		if (!isset($kupujem) || empty($kupujem)) {
			$greska .= "Niste unijeli valutu! Molimo Vas da unesete valutu.<br>";
		}
		if (empty($greska)) {
			$poruka = "Uspješno ste kreirali zahtjev!";
			$upit = "INSERT INTO zahtjev (korisnik_id, iznos, prodajem_valuta_id, kupujem_valuta_id, datum_vrijeme_kreiranja, prihvacen)
							 VALUES ('$aktivni_korisnik_id', '$iznos', '$prodajem', '$kupujem', '$datum', 2)";
			izvrsiUpit($veza, $upit);
			$id_novi_zahtjev = mysqli_insert_id($veza);
			header("Location:moji_zahtjevi.php");
		}
	}
	?>
	<!DOCTYPE html>

	<head>
		<meta charset="utf-8" />
		<link href="css_stilovi.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<div id="nav1">
			<h3 style="text-align: center;">Moji zahtjevi</h3>
			<table style="margin-left:auto; margin-right:auto;">
				<thead>
					<tr style="background-color:#D8D8D8">
						<th width="330px">Datum i vrijeme kreiranja zahtjeva</th>
						<th width="220px">Prodajna valuta</th>
						<th width="220px">Kupovna valuta</th>
						<th width="80px">Iznos</th>
						<th width="140px">Status</th></br>
					</tr>
				</thead>

				<tbody>
					<?php
					while ($row = mysqli_fetch_array($rezultat)) {
						$prodajem_valutu_id = $row[3];
						$upit2 = mysqli_query($veza, "SELECT * FROM valuta WHERE valuta_id= $prodajem_valutu_id");
						$rezultat2 = mysqli_fetch_array($upit2);
						$ime_valute = $rezultat2[2];
						$kupujem_valutu_id = $row[4];
						$upit3 = mysqli_query($veza, "SELECT * FROM valuta WHERE valuta_id= $kupujem_valutu_id");
						$rezultat3 = mysqli_fetch_array($upit3);
						$ime_valute2 = $rezultat3[2];
						$vrijeme = strtotime($row[5]);
						$date = date("d.m.Y H:i:s", $vrijeme);
						echo "<tr>";
						echo "<td  style='text-align:center'>{$date}</td>";
						echo "<td style='text-align:center'>{$ime_valute}</td>";
						echo "<td style='text-align:center'>{$ime_valute2}</td>";
						echo "<td  style='text-align:center'>{$row[2]}</td>";
						if ($row[6] == 0) {
							echo '<td style="color: #d6409d;">Odbijeno</td>"';
						} else if ($row[6] == 1) {
							echo '<td style="color: #4aed70;">Prihvaceno</td>"';
						} else if ($row[6] == 2) {
							echo '<td style="color: #ac4aed;">Na cekanju</td>"';
						}
						echo "</tr>";
					}
					?>
				</tbody>
			</table>

			<?php

			if (isset($greska)) {
				echo '<p style="text-align: center;">' . $greska . '</p>';
			}
			?>
			<br><br>
			<h3 style="text-align: center;">Dodavanje novih zahtjeva</h3>

			<form name="obrazac" method="post" action="moji_zahtjevi.php">
				<label style="margin:20px;">Iznos:</label>
				<input style="margin:20px;" id="iznos" name="iznos" type="text" />

				<label style="margin:20px;">Prodajem valutu:&nbsp;</label>
				<select name="prodajem">
					<?php
					$upit = "SELECT v.* FROM valuta v, sredstva s WHERE v.valuta_id = s.valuta_id AND s.korisnik_id = $aktivni_korisnik_id";
					$rezultat = izvrsiUpit($veza, $upit);
					while ($row = mysqli_fetch_array($rezultat)) {
						echo "<option value='{$row["valuta_id"]}'";
						echo ">{$row["naziv"]}</option>";
					}
					?>
				</select>
				<br>
				<label style="margin:20px;">Kupujem valutu: &nbsp;</label>
				<select name="kupujem">
					<?php
					$upit = "SELECT v.* FROM valuta v, sredstva s WHERE v.valuta_id = s.valuta_id AND s.korisnik_id = $aktivni_korisnik_id";
					$rezultat = izvrsiUpit($veza, $upit);
					while ($row = mysqli_fetch_array($rezultat)) {
						echo "<option value='{$row["valuta_id"]}'";
						echo ">{$row["naziv"]}</option>";
					}
					?>
				</select>

				<button style="margin:18px;" name="submit" type="submit">Dodaj</button>
			</form>

		</div>
		<?php
		include("podnozje.php");
		?>