<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();
?>

	<?php
		if(isset($_GET['logout'])){
			unset($_SESSION["aktivni_korisnik"]);
			unset($_SESSION['aktivni_korisnik_ime']);
			unset($_SESSION["aktivni_korisnik_tip"]);
			unset($_SESSION["aktivni_korisnik_id"]);
			session_destroy();
			header("Location:index.php");
			}

	$greska= "";
	if(isset($_POST['submit'])){
		$kor_ime=mysqli_real_escape_string($bp,$_POST['korisnicko_ime']);
		$lozinka=mysqli_real_escape_string($bp,$_POST['lozinka']);

		if(!empty($kor_ime)&&!empty($lozinka)){
			$sql="SELECT korisnik_id,tip_korisnika_id,ime,prezime FROM korisnik WHERE korisnicko_ime='$kor_ime' AND lozinka='$lozinka'";
			$rs=izvrsiUpit($bp,$sql);
			if(mysqli_num_rows($rs)==0)$greska="Nažalost, ne postoji korisnik s navedenim korisničkim imenom i lozinkom!";
			else{
				list($id,$tip,$ime,$prezime)=mysqli_fetch_array($rs);
				$_SESSION['aktivni_korisnik']=$kor_ime;
				$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
				$_SESSION["aktivni_korisnik_id"]=$id;
				$_SESSION['aktivni_korisnik_tip']=$tip;
				header("Location:index.php");
			}
		}
		else $greska = "Molimo Vas da unesete korisničko ime i lozinku!";
	}
?>

<form id="nav1" name="prijava" method="POST" action="prijavi_se.php" onsubmit="return validacija();">
	<table>
		<h3 style="text-align:center">Prijava u sustav</h3>
		<tbody>
			<tr>
					<td colspan="2" style="text-align:center;">
						<label class="greska"><?php if($greska!="")echo $greska; ?></label>
					</td>
			</tr>

			<tr>
				<td width="150px" style="padding-left:10px">
					<label for="korisnicko_ime"><strong>Korisničko ime:</strong></label>
				</td>
				<td>
					<input name="korisnicko_ime" id="korisnicko_ime" type="text" size="110" placeholder="Ovdje upišite korisničko ime"/>
				</td>
			</tr>

			<tr>
				<td  width="150px" style="padding-left:10px">
					<label for="lozinka"><strong>Lozinka:</strong></label>
				</td>
				<td>
					<input name="lozinka"	id="lozinka" type="password" size="110" placeholder="Ovdje upišite lozinku"/>
				</td>
			</tr>

			<tr>
				<td colspan="2" style="text-align:center;">
					<button name="submit" type="submit">Prijavi se</button>
				</td>
			</tr>

		</tbody>
	</table>
</form>

<?php
	zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>
