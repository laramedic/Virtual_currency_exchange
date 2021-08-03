	<?php
		include_once("zaglavlje.php");
		include_once("baza.php");
		$veza = spojiSeNaBazu();
		$upit = "SELECT *FROM sredstva WHERE korisnik_id='{$aktivni_korisnik_id}'";
		$rezultat = izvrsiUpit($veza, $upit);
	?>

	  <div id="nav1">
    <h3 style="text-align: center;">Moja raspoloživa sredstva</h3>
        <table style="margin-left:auto; margin-right:auto;">

            <thead>
          			<tr style="background-color:#D8D8D8">
                    <th width="250px">Valuta</th>
                    <th width="250px">Iznos</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (isset($rezultat)) {
                    while ($row = mysqli_fetch_array($rezultat)) {
                        $valuta_id = $row[2];
                        $upit2 = mysqli_query($veza, "SELECT * FROM valuta WHERE valuta_id= $valuta_id");
                        $rezultat2 = mysqli_fetch_array($upit2);
                        $ime_valute = $rezultat2[2];
                        echo "<tr align='center'>";
                        echo "<td>{$ime_valute}</td>";
                        echo "<td>{$row[3]}</td>";
                        echo "</tr>";
                        }
                      }
                ?>
         </tbody>
  </table>
<br><br>
<?php
    include_once("unos_novog_iznosa.php");
?>

</div>

<?php
	include("podnozje.php");
?>
