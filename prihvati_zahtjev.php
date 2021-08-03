<?php
include("zaglavlje.php");
include_once("baza.php");
$veza = spojiSeNaBazu();

if (isset($_GET["odbijZahtjev"])) {
    $odbijZahtjev = $_GET["odbijZahtjev"];
    $upit = "UPDATE zahtjev SET prihvacen = 0 WHERE zahtjev_id = $odbijZahtjev";
    izvrsiUpit($veza, $upit);
}

if (isset($_GET["idZahtjeva"])) {
    $idZahtjeva = $_GET["idZahtjeva"];

    $upit = "SELECT * FROM zahtjev WHERE zahtjev_id = $idZahtjeva";
    $row = izvrsiUpit($veza, $upit);
    $rez = mysqli_fetch_array($row);

    $idKorisnikZahtjeva = $rez[1];
    $zahtjevIznos = $rez[2];
    $valutaId = $rez[3];
    $valutaKupujemId = $rez[4];

    $upit = "SELECT * FROM sredstva WHERE korisnik_id = $idKorisnikZahtjeva AND valuta_id = $valutaId";
    $row = izvrsiUpit($veza, $upit);
    $rez = mysqli_fetch_array($row);

    $sredstvaId = $rez[0];
    $sredstvaIznos = $rez[3];

    $upit = "SELECT * FROM sredstva WHERE korisnik_id = $idKorisnikZahtjeva AND valuta_id = $valutaKupujemId";
    $row = izvrsiUpit($veza, $upit);

    if (mysqli_num_rows($row) > 0) {
        $rez = mysqli_fetch_array($row);
        $sredstvaKupujemId = $rez[0];
        $sredstvaKupujemIznos = $rez[3];
    }

    if ($sredstvaIznos >= $zahtjevIznos) {
        if (mysqli_num_rows($row) > 0) {
            $upit = "SELECT * FROM valuta WHERE valuta_id = $valutaId";

            $row = izvrsiUpit($veza, $upit);
            $rez = mysqli_fetch_array($row);

            $tecajValuta = $rez[3];

            $upit = "SELECT * FROM valuta WHERE valuta_id = $valutaKupujemId";

            $row = izvrsiUpit($veza, $upit);
            $rez = mysqli_fetch_array($row);

            $tecajKupujemValuta = $rez[3];

            $iznosSredstvaValuteProdajem = $zahtjevIznos * $tecajValuta;
            $iznosSredstvaValuteKupujem = $iznosSredstvaValuteProdajem / $tecajKupujemValuta;

            $upit = "UPDATE sredstva SET iznos = iznos + $iznosSredstvaValuteKupujem
                WHERE valuta_id = $valutaKupujemId AND korisnik_id = $idKorisnikZahtjeva";
            izvrsiUpit($veza, $upit);

            $upit = "UPDATE sredstva SET iznos = iznos - $zahtjevIznos
                WHERE valuta_id = $valutaId AND korisnik_id = $idKorisnikZahtjeva";
            izvrsiUpit($veza, $upit);

            $upit = "UPDATE zahtjev SET prihvacen = 1 WHERE zahtjev_id = $idZahtjeva";
            izvrsiUpit($veza, $upit);
        } else {
            $upit = "SELECT * FROM valuta WHERE valuta_id = $valutaId";

            $row = izvrsiUpit($veza, $upit);
            $rez = mysqli_fetch_array($row);

            $tecajValuta = $rez[3];

            $upit = "SELECT * FROM valuta WHERE valuta_id = $valutaKupujemId";

            $row = izvrsiUpit($veza, $upit);
            $rez = mysqli_fetch_array($row);

            $tecajKupujemValuta = $rez[3];

            $iznosSredstvaValuteProdajem = $zahtjevIznos * $tecajValuta;
            $iznosSredstvaValuteKupujem = $iznosSredstvaValuteProdajem / $tecajKupujemValuta;

            $upit = "INSERT INTO sredstva (korisnik_id, valuta_id, iznos) VALUES ('$idKorisnikZahtjeva', '$valutaKupujemId', '$iznosSredstvaValuteKupujem')";
            izvrsiUpit($veza, $upit);

            $upit = "UPDATE sredstva SET iznos = iznos - $zahtjevIznos
                WHERE valuta_id = $valutaId AND korisnik_id = $idKorisnikZahtjeva";
            izvrsiUpit($veza, $upit);

            $upit = "UPDATE zahtjev SET prihvacen = 1 WHERE zahtjev_id = $idZahtjeva";
            izvrsiUpit($veza, $upit);
        }
    } else {
        echo "<p>Nažalost, nemate dovoljno sredstva za prihvaćanje zahtjeva!</p>";
    }
}
?>

<body>
    <div id="nav1">
        <h3 style="text-align: center;">Zahtjevi svih korisnika koji traže prodaju valute</h3>
        <table style="margin-left:auto; margin-right:auto;">
            <thead>
                <tr style="background-color:#D8D8D8">
                    <th width="120px">Rb. zahtjeva</th>
                    <th width="400px">Korisnik</th>
                    <th width="80px">Iznos</th>
                    <th width="300px">Prodajem valutu</th>
                    <th width="300px">Kupujem valutu</th>
                    <th width="300px">Datum i vrijeme kreiranja</th>
                    <th width="200px">Status</th>
                    <th width="200px">Prihvaćanje zahtjeva</th>
                    <th width="200px">Odbijanje zahtjeva</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($aktivni_korisnik_tip == 1) {
                    $upit = "SELECT z.*, v.naziv, v.tecaj, v.aktivno_od, v.aktivno_do FROM zahtjev z, valuta v
                        WHERE z.prodajem_valuta_id = v.valuta_id AND v.moderator_id='{$aktivni_korisnik_id}' AND z.prihvacen=2";
                    $rezultat = izvrsiUpit($veza, $upit);
                    if (isset($rezultat)) {

                        while ($row = mysqli_fetch_array($rezultat)) {

                            $upit2 = "SELECT * FROM valuta WHERE valuta_id= '{$row[3]}'";
                            $rezultat2 = izvrsiUpit($veza, $upit2);
                            $prodajem_valuta_id = mysqli_fetch_array($rezultat2);

                            $upit3 = "SELECT * FROM valuta WHERE valuta_id= '{$row[4]}'";
                            $rezultat3 = izvrsiUpit($veza, $upit3);
                            $kupujem_valuta_id = mysqli_fetch_array($rezultat3);

                            $vrijeme = strtotime($row[5]);
                            $datumVrijeme = date("d.m.Y H:i:s", $vrijeme);

                            $upit4 = "SELECT * FROM korisnik WHERE korisnik_id= '{$row[1]}'";
                            $rezultat4 = izvrsiUpit($veza, $upit4);
                            $korisnikImePrezime = mysqli_fetch_array($rezultat4);
                            $now = date("H:i:s");

                            echo "<tr>";
                            echo "<td style='text-align:center'>{$row[0]}</td>";
                            echo "<td style='text-align:center'>{$korisnikImePrezime[4]}" . " " . "{$korisnikImePrezime[5]}</td>";
                            echo "<td style='text-align:center'>{$row[2]}</td>";
                            echo "<td style='text-align:center'>{$prodajem_valuta_id[2]}</td>";
                            echo "<td style='text-align:center'>{$kupujem_valuta_id[2]}</td>";
                            echo "<td style='text-align:center'>{$datumVrijeme}</td>";
                            if ($row[6] == 2) {
                                echo '<td style="color: #ac4aed;">Na cekanju</td>"';
                            }
                            if ($now > $prodajem_valuta_id[6] && $now < $prodajem_valuta_id[7]) {
                                echo "<td style='text-align:center'><a href='prihvati_zahtjev.php?idZahtjeva={$row[0]}'>Prihvati zahtjev</a></td>";
                                echo "<td style='text-align:center'><a href='prihvati_zahtjev.php?odbijZahtjev={$row[0]}'>Odbij zahtjev</a></td>";
                            } else {
                                echo "<td >Valuta nije aktivna</td></tr>";
                            }
                        }
                    }
                    zatvoriVezuNaBazu($veza);
                }
                if ($aktivni_korisnik_tip == 0) {
                    $upit = "SELECT z.*, v.naziv, v.tecaj, v.aktivno_od, v.aktivno_do FROM zahtjev z, valuta v
                        WHERE z.prodajem_valuta_id = v.valuta_id AND z.prihvacen=2";
                    $rezultat = izvrsiUpit($veza, $upit);
                    if (isset($rezultat)) {

                        while ($row = mysqli_fetch_array($rezultat)) {

                            $upit2 = "SELECT * FROM valuta WHERE valuta_id= '{$row[3]}'";
                            $rezultat2 = izvrsiUpit($veza, $upit2);
                            $prodajem_valuta_id = mysqli_fetch_array($rezultat2);

                            $upit3 = "SELECT * FROM valuta WHERE valuta_id= '{$row[4]}'";
                            $rezultat3 = izvrsiUpit($veza, $upit3);
                            $kupujem_valuta_id = mysqli_fetch_array($rezultat3);

                            $vrijeme = strtotime($row[5]);
                            $datumVrijeme = date("d.m.Y H:i:s", $vrijeme);

                            $upit4 = "SELECT * FROM korisnik WHERE korisnik_id= '{$row[1]}'";
                            $rezultat4 = izvrsiUpit($veza, $upit4);
                            $korisnikImePrezime = mysqli_fetch_array($rezultat4);
                            $now = date("H:i:s");

                            echo "<tr>";
                            echo "<td style='text-align:center'>{$row[0]}</td>";
                            echo "<td style='text-align:center'>{$korisnikImePrezime[4]}" . " " . "{$korisnikImePrezime[5]}</td>";
                            echo "<td style='text-align:center'>{$row[2]}</td>";
                            echo "<td style='text-align:center'>{$prodajem_valuta_id[2]}</td>";
                            echo "<td style='text-align:center'>{$kupujem_valuta_id[2]}</td>";
                            echo "<td style='text-align:center'>{$datumVrijeme}</td>";
                            if ($row[6] == 2) {
                                echo '<td style="color: #ac4aed;">Na cekanju</td>"';
                            }
                            if ($now > $prodajem_valuta_id[6] && $now < $prodajem_valuta_id[7]) {
                                echo "<td style='text-align:center'><a href='prihvati_zahtjev.php?idZahtjeva={$row[0]}'>Prihvati zahtjev</a></td>";
                                echo "<td style='text-align:center'><a href='prihvati_zahtjev.php?odbijZahtjev={$row[0]}'>Odbij zahtjev</a></td>";
                            } else {
                                echo "<td >Valuta nije aktivna</td></tr>";
                            }
                            echo "<tr>";
                        }
                    }
                    zatvoriVezuNaBazu($veza);
                }

                ?>
            </tbody>
        </table>
    </div>

    <?php
    include("podnozje.php");
    ?>