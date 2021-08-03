<?php
include("zaglavlje.php");
include_once("baza.php");


if (isset($_POST["submit"])) {
  $greska = "";
  $poruka = "";
  $moderator_id = $_POST["moderator_id"];
  $naziv = $_POST["naziv"];
  $tecaj = $_POST["tecaj"];
  $slika = $_POST["slika"];
  $zvuk = $_POST["zvuk"];
  $aktivno_od = $_POST["aktivno_od"];
  $aktivno_do = $_POST["aktivno_do"];
  $datum_azuriranja = date("Y-m-d");


  if (!isset($naziv) || empty($naziv)) {
    $greska .= "Niste unijeli naziv! <br>";
  }
  if (!isset($tecaj) || empty($tecaj)) {
    $greska .= "Niste unijeli tecaj! <br>";
  }
  if (!isset($slika) || empty($slika)) {
    $greska .= "Niste unijeli sliku! <br>";
  }
  if (!isset($aktivno_od) || empty($aktivno_od)) {
    $greska .= "Niste unijeli aktivno od! <br>";
  }
  if (!isset($aktivno_do) || empty($aktivno_do)) {
    $greska .= "Niste unijeli aktivno do! <br>";
  }


  if (empty($greska)) {
    $poruka = "Nova valuta je kreirana!";

    $upit = "INSERT INTO valuta (moderator_id, naziv, tecaj, slika, zvuk, aktivno_od, aktivno_do, datum_azuriranja) VALUES ('{$moderator_id}', '{$naziv}', '{$tecaj}', '{$slika}', '{$zvuk}','{$aktivno_od}', '{$aktivno_do}', '{$datum_azuriranja}')";
    izvrsiUpit($veza, $upit);
    header("Location:index.php");
  }
}
?>
<div id="nav1">
  <h3 style="text-align: center;">Dodavanje nove valute</h3>
  <section>
    <form method="post" name="obrazac">
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
      </select><br><br>
      <label><b>Valuta:</b></b></label>
      <input id="naziv" name="naziv" type="text" placeholder="Ovdje upišite naziv valute (npr. euro)" /> <br>
      <label><b>Tečaj:</b></label>
      <input id="tecaj" name="tecaj" type="text" placeholder="Ovdje upišite tečaj valute (npr. 7.5)" /> <br>
      <label><b>Slika:</b></label>
      <input id="slika" name="slika" type="text" placeholder="Ovdje dodajte sliku valute (URL do slike na Webu)" /> <br>
      <label><b>Zvuk:</b></label>
      <input id="zvuk" name="zvuk" type="text" placeholder="Ovdje dodajte zvuk (URL do audio zapisa na Webu s himnom države) - opcionalno!" /> <br>
      <label><b>Aktivno od:</b></label>
      <input id="aktivno_od" name="aktivno_od" type="text" placeholder="Ovdje upišite od kad je aktivna valuta" /> <br>
      <label><b>Aktivno do:</b></label>
      <input id="aktivno_do" name="aktivno_do" type="text" placeholder="Ovdje upišite do kad je aktivna valuta" /> <br>
      <button class="submit" type="submit" name="submit">Dodaj</button>
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
</div>


<?php
include("podnozje.php");
?>
