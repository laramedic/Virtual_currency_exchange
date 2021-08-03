<?php
  include("zaglavlje.php");
  include_once("baza.php");
  $sredstva_id= $_GET["id"];

    if (isset($_POST["buttonNoviZahtjev"])) {
    $greska = "";
    $poruka = "";
    $iznos = $_POST["iznos"];

    if (!isset($iznos) || empty($iznos)) {
        $greska .= "Nažalost, niste unijeli iznos! <br>";
    }
    if (empty($greska)) {
        $poruka = "Uspješno ste kreirali zahtjev!";

        $upit = "UPDATE sredstva SET
			iznos='{$iznos}'
			WHERE sredstva_id='{$sredstva_id}'";
        izvrsiUpit($veza, $upit);
        $poruka = "Uspješno ste ažurirali iznos sredstva za valutu!";
    }
  }
    $upit2 = "SELECT * FROM sredstva WHERE sredstva_id='{$sredstva_id}'";
    $rezultat2 = izvrsiUpit($veza, $upit2);
    $valuta_id = mysqli_fetch_array($rezultat2);
    $upit3 = "SELECT * FROM valuta WHERE valuta_id ='{$valuta_id[2]}'";
    $rezultat3 = izvrsiUpit($veza, $upit3);
    $naziv = mysqli_fetch_array($rezultat3);
    $upit4 = "SELECT *FROM sredstva WHERE sredstva_id='{$sredstva_id}'";
    $rezultat4 = izvrsiUpit($veza, $upit4);
    $stari_iznos = mysqli_fetch_array($rezultat4);
?>

  <div id="nav1">
  <h3 style="text-align: center;">Ažuriranje sredstava</h3>

            <form>
            <?php
            echo "<b>Prodajna valuta:</b> $naziv[2]<br/>";
            ?>

                <label><b>Iznos:</b></label>
                <input name="iznos" type="text" value="<?php echo $stari_iznos[3]; ?>"/></br>
                <button name="submit" type="submit">Ažuriraj</button>
            </form>

            <?php
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
