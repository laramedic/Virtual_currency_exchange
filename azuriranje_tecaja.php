<?php
include("zaglavlje.php");
include_once("baza.php");
$veza = spojiSeNaBazu();
$valuta = $_GET["id"];

if (isset($_POST["submit"])) {
  $greska = "";
  $poruka = "";
  $tecaj = $_POST["tecaj"];
  $datum = date("Y-m-d");
  $upit3 = "SELECT *FROM valuta WHERE valuta_id='{$valuta}'";
  $rezultat3 = izvrsiUpit($veza, $upit3);
  $red2 = mysqli_fetch_array($rezultat3);
  $date = $red2[8];
  if ($datum == $date) {
    $greska .= "Jednom dnevno moguće je ažurirati valutu! <br>";
  }
  if (!isset($tecaj) || empty($tecaj)) {
    $greska .= "Niste unijeli tecaj! <br>";
  }
  if (empty($greska)) {
    $upit = "UPDATE valuta SET
                    tecaj='{$tecaj}', datum_azuriranja = '{$datum}'
                  WHERE valuta_id='{$valuta}'";
    izvrsiUpit($veza, $upit);
    header("Location:index.php");
  }
}
$upit2 = "SELECT *FROM valuta WHERE valuta_id='{$valuta}'";
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
    <h3 style="text-align:center;">Ažuriranje tecaja</h3>
    <section>
      <form method="post" name="obrazac">
        <br><br>
        <label><b>Naziv:</b></label>
        <input id="naziv" name="naziv" type="text" value="<?php echo $red[2]; ?> " disabled /></br>
        <label><b>Tecaj:</b></label>
        <input id="tecaj" name="tecaj" type="text" value="<?php echo $red[3]; ?>" /></br>
        <button type="submit" name="submit" value="Ažuriraj">Ažuriraj</button>
      </form>
    </section>
  </div>

  <?php
  include("podnozje.php");
  ?>