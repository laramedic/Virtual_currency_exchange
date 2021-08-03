	<?php
	include_once("baza.php");
	$veza = spojiSeNaBazu();
	$sredstva_id = "";

	if (isset($_POST["buttonNoviZahtjev"])) {
		$greska = "";
		$poruka = "";
		$valuta_id = $_POST["valuta_id"];
		$iznos = $_POST["iznos"];

		if (!isset($iznos) || empty($iznos)) {
			$greska .= "Molimo Vas da unesete iznos koji želite dodati!";
		}

		if (empty($greska)) {
			$upit = "SELECT * FROM sredstva WHERE valuta_id= '{$valuta_id}' AND korisnik_id='{$aktivni_korisnik_id}'";
			$rezultat = izvrsiUpit($veza, $upit);
			$row = mysqli_fetch_array($rezultat);

			if (mysqli_num_rows($rezultat) > 0) {
				$iznos_int = $iznos + end($row);
				$upit2 = "UPDATE sredstva SET iznos='{$iznos_int}' WHERE valuta_id= '{$valuta_id}' AND korisnik_id='{$aktivni_korisnik_id}'";

				$rezultat2 = izvrsiUpit($veza, $upit2);
				$sredstva_id = mysqli_insert_id($veza);
				header("Location:moja_sredstva.php");
			} else {
				$upit2 = "INSERT INTO sredstva (korisnik_id, valuta_id, iznos) VALUES ('{$aktivni_korisnik_id}','{$valuta_id}', '{$iznos}')";
				$rezultat2 = izvrsiUpit($veza, $upit2);
				$sredstva_id = mysqli_insert_id($veza);
				header("Location:moja_sredstva.php");
			}
		}
	}
	?>

	<h3 style="text-align: center;">Unos novog iznosa ili azuriranje postojuceg</h3>
	<section>
		<form id="noviZahtjevObrazac" name="obrazac" method="post">
			<label style="margin:30px;"><b>Valuta:</b></label>
			<select name="valuta_id">
				<?php
				$upit3 = "SELECT * FROM valuta";
				$rezultat3 = izvrsiUpit($veza, $upit3);
				while ($row = mysqli_fetch_array($rezultat3)) {
					echo "<option value='{$row[0]}'";
					echo ">{$row[2]}</option>";
				}
				?>
			</select> <br>
			<label style="margin:30px;"><b>Iznos:</b></label>
			<input style="margin-left:30px;" id="iznos" name="iznos" type="text" />
			<button style="margin-left:30px;" name="buttonNoviZahtjev" type="submit">Dodaj</button>
		</form>

		<div>
			<?php
			if (isset($greska)) {
				echo "<p>$greska</p>";
			}
			if (isset($poruka)) {
				echo "<p>$poruka</p>";
			}
			?>
		</div>
	</section>