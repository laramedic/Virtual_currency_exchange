<?php
include("zaglavlje.php");
include_once("baza.php");
$veza = spojiSeNaBazu();
$korisnik_id = $_GET["id"];

if (isset($_POST["submit"])) {
  $greska = "";
  $poruka = "";
  $tip_korisnika_id = $_POST["tip_korisnika_id"];
  $korisnicko_ime = $_POST["korisnicko_ime"];
  $lozinka = $_POST["lozinka"];
  $ime = $_POST["ime"];
  $prezime = $_POST["prezime"];
  $email = $_POST["email"];
  $slika = $_POST["slika"];

  if (!isset($korisnicko_ime) || empty($korisnicko_ime)) {
    $greska .= "Niste unijeli korisničko ime! <br>";
  }
  if (!isset($lozinka) || empty($lozinka)) {
    $greska .= "Niste unijeli lozinku! <br>";
  }
  if (!isset($ime) || empty($ime)) {
    $greska .= "Niste unijeli ime! <br>";
  }
  if (!isset($prezime) || empty($prezime)) {
    $greska .= "Niste unijeli prezime! <br>";
  }
  if (!isset($email) || empty($email)) {
    $greska .= "Niste unijeli email! <br>";
  }
  if (!isset($slika) || empty($slika)) {
    $greska .= "Niste unijeli sliku! <br>";
  }
  if (empty($greska)) {
    $upit = "UPDATE korisnik SET
			tip_korisnika_id='{$tip_korisnika_id}',
			ime='{$ime}',
			prezime='{$prezime}',
			email='{$email}',
			korisnicko_ime='{$korisnicko_ime}',
			lozinka='{$lozinka}' ,
			slika='{$slika}'
			WHERE korisnik_id='{$korisnik_id}'";
    izvrsiUpit($veza, $upit);
    header("Location:korisnici.php");
  }
}
$upit2 = "SELECT *FROM korisnik WHERE korisnik_id='{$korisnik_id}'";
$rezultat2 = izvrsiUpit($veza, $upit2);
$red = mysqli_fetch_array($rezultat2);
?>

<body>
  <div id="nav1">
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
    <h3 style="text-align:center;">Ažuriranje korisnika</h3>
    <section>
      <form method="post" name="obrazac">
        <label><b>Tip korisnika:</b></label>
        <select name="tip_korisnika_id">
          <?php
          $upit3 = "SELECT * FROM tip_korisnika";
          $rezultat3 = izvrsiUpit($veza, $upit3);
          while ($row = mysqli_fetch_array($rezultat3)) {
            echo "<option  value='{$row["tip_korisnika_id"]}'";
            if ($red["tip_korisnika_id"] == $row["tip_korisnika_id"]) {
                echo " selected='selected' ";
            }
            echo ">{$row["naziv"]}</option>";
          }
          ?>
        </select>
        <br><br>
        <label><b>Korisničko ime:</b></label>
        <input id="korisnicko_ime" name="korisnicko_ime" type="text" value="<?php echo $red[2]; ?>" /></br>
        <label><b>Lozinka:</b></label>
        <input id="lozinka" name="lozinka" type="password" value="<?php echo $red[3]; ?>" /></br>
        <label><b>Ime:</b></label>
        <input id="ime" name="ime" type="text" value="<?php echo $red[4]; ?>" /></br>
        <label><b>Prezime:</b></label>
        <input id="prezime" name="prezime" type="text" value="<?php echo $red[5]; ?>" /></br>
        <label><b>e-mail:</b></label>
        <input id="email" name="email" type="text" value="<?php echo $red[6]; ?>" /></br>
        <label><b>Slika:</b></label>
        <input id="slika" name="slika" type="text" value="<?php echo $red[7]; ?>" /></br>
        <button type="submit" name="submit" value="Ažuriraj">Ažuriraj</button>
      </form>
    </section>
  </div>

  <?php
  include("podnozje.php");
  ?>