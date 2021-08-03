<?php
include("zaglavlje.php");
include_once("baza.php");
$veza = spojiSeNaBazu();
$valuta = $_GET["id"];

if (isset($_POST["submit"])) {
    $greska = "";
    $poruka = "";
    $moderator_id = $_POST["moderator_id"];
    $naziv = $_POST["naziv"];
    $tecaj = $_POST["tecaj"];
    $slika = $_POST["slika"];
    $zvuk = $_POST["zvuk"];
    $aktivno_od = $_POST["aktivno_od"];
    $date1 = strtotime($aktivno_od);
    $date1 = date("H:i:s", $date1);
    $aktivno_do = $_POST["aktivno_do"];
    $date2 = strtotime($aktivno_do);
    $date2 = date("H:i:s", $date2);

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
        $upit = "UPDATE valuta SET
                  moderator_id='{$moderator_id}',
                  slika='{$slika}',
                  zvuk='{$zvuk}',
                  aktivno_od='{$date1}',
                  naziv='{$naziv}',
                  tecaj='{$tecaj}' ,
                  aktivno_do='{$date2}'
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
        <h3 style="text-align:center;">Ažuriranje valute</h3>
        <section>
            <form method="post" name="obrazac">
                <label><b>Moderator:</b></label>
                <select name="moderator_id">
                <?php
                $upit3 = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1";
                $rezultat3 = izvrsiUpit($veza, $upit3);
                while ($red2 = mysqli_fetch_array($rezultat3)) {
                    echo "<option value='{$red2[0]}'";
                    if ($red[1] == $red2[0]) {
                        echo "selected";
                    }
                    echo ">{$red2[4]} " . " {$red2[5]}</option>";
                }
                ?>
            </select>
                <br><br>
                <label><b>Naziv:</b></label>
                <input id="naziv" name="naziv" type="text" value="<?php echo $red[2]; ?>" /></br>
                <label><b>Tecaj:</b></label>
                <input id="tecaj" name="tecaj" type="text" value="<?php echo $red[3]; ?>" /></br>
                <label><b>Slika:</b></label>
                <input id="slika" name="slika" type="text" value="<?php echo $red[4]; ?>" /></br>
                <label><b>Zvuk:</b></label>
                <input id="zvuk" name="zvuk" type="text" value="<?php echo $red[5]; ?>" /></br>
                <label><b>Aktivno od:</b></label>
                <input id="aktivno_od" name="aktivno_od" type="text" value="<?php echo $red[6]; ?>" /></br>
                <label><b>Aktivno do:</b></label>
                <input id="aktivno_do" name="aktivno_do" type="text" value="<?php echo $red[7]; ?>" /></br>
                <button type="submit" name="submit" value="Ažuriraj">Ažuriraj</button>
            </form>
        </section>
    </div>

    <?php
    include("podnozje.php");
    ?>