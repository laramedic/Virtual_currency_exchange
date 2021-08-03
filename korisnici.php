<?php
	include("zaglavlje.php");
	include_once("baza.php");
	$veza = spojiSeNaBazu();
	$upit = "SELECT *FROM korisnik";
	$rezultat = izvrsiUpit($veza, $upit);
	zatvoriVezuNaBazu($veza);
	?>
	<body>
		  <div id="nav1">
	    <h3 style="text-align: center;">Ažuriranje korisnika</h3>
	    <table>
	        <thead>
	            <tr style="background-color:#D8D8D8">
	                <th>ID korisnika </th>
	                <th>Tip korisnika</th>
	                <th>Korisničko ime</th>
	                <th>Lozinka</th>
	                <th>Ime</th>
	                <th>Prezime</th>
	                <th>E-mail</th>
	                <th>Slika</th>
	                <th>Ažuriraj</th>
	            </tr>
	        </thead>
	        <tbody>

	            <?php
	            if (isset($rezultat)) {
	                while ($row = mysqli_fetch_array($rezultat)) {
	                    echo "<tr>";
						echo "<td style='text-align:center'>{$row[0]}</td>";
						if($row[1]==0){
						echo "<td style='text-align:center'>Administrator</td>";
						}else if($row[1]==1){
							echo "<td style='text-align:center'>Moderator</td>";
						}else if($row[1]==2){
							echo "<td style='text-align:center'>Korisnik</td>";
						}
	                    echo "<td style='text-align:center'>{$row[2]}</td>";
	                    echo "<td style='text-align:center'>{$row[3]}</td>";
	                    echo "<td style='text-align:center'>{$row[4]}</td>";
	                    echo "<td style='text-align:center'>{$row[5]}</td>";
	                    echo "<td style='text-align:center'>{$row[6]}</td>";
	                    echo "<td style='text-align:center'><img src=\"" . $row[7] . "\" width=40 height=60></td>";
	                    echo "<td style='text-align:center'><a href='azuriranje_korisnika.php?id={$row[0]}'>Ažuriraj</a></td>";
	                    echo "</tr>";
	                }
	            }
	            ?>

	        </tbody>
	    </table>
</div>

	<?php
		include("podnozje.php");
	?>
