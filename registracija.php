	<?php
    include("zaglavlje.php");
    include_once("baza.php");

    if (isset($_POST["submit"])) {
        $greska = "";
        $poruka = "";
        $tipKorisnikaId = $_POST["tipKorisnikaId"];
        $korisnickoIme = $_POST["korisnickoIme"];
        $lozinka = $_POST["lozinka"];
        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $email = $_POST["email"];
        $slika = $_POST["slika"];

        if (!isset($korisnickoIme) || empty($korisnickoIme)) {
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
            $poruka = "Kreirali ste novog korisnika!";

            $upit = "INSERT INTO korisnik (tip_korisnika_id, korisnicko_ime, lozinka, ime, prezime, email, slika )
			VALUES ($tipKorisnikaId, '{$korisnickoIme}', '{$lozinka}', '{$ime}', '{$prezime}', '{$email}', '{$slika}')";
            izvrsiUpit($veza, $upit);
            header("Location:korisnici.php");
        }
    }
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
	        <h3 style="text-align: center;">Dodavanje novog korisnika</h3>
	        <section>
	            <div class="forms">
	                <form  name="obrazac" method="post" action="registracija.php">
	                    <label>Tip Korisnika:</label>
	                    <select name="tipKorisnikaId">
	                        <?php
                            $upit = "SELECT * FROM tip_korisnika";
                            $rezultat = izvrsiUpit($veza, $upit);
                            while ($row = mysqli_fetch_array($rezultat)) {
                                echo "<option value='{$row["tip_korisnika_id"]}'";

                                echo ">{$row["naziv"]}</option>";
                            }
                            ?>
	                    </select>
	                    <label>Korisničko ime:</label>
	                    <input id="korisnickoIme" name="korisnickoIme" type="text" /> <br>
	                    <label>Lozinka:</label>
	                    <input id="lozinka" name="lozinka" type="password" /> <br>
	                    <label>Ime:</label>
	                    <input id="ime" name="ime" type="text" /> <br>
	                    <label>Prezime:</label>
	                    <input id="prezime" name="prezime" type="text" /> <br>
	                    <label>E-mail:</label>
	                    <input id="email" name="email" type="text" /> <br>
	                    <label>Slika:</label>
	                    <input id="slika" name="slika" type="text" /> <br>
	                    <button type="submit" value="Dodaj" name="submit">Dodaj</button>
	                </form>
	                <div>
	        </section>
	    </div>
	    <?php
        include("podnozje.php");
        ?>