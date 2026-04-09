<?php
//Itt annyit változtattam hogy nincs id kiírás mert nem látom értelmét csak tesztre max
//Emelett csináltam flag változtatásokat és felesleges változókat kiszedtem így egszerűsítettem.
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['utonev'])) {
    try {
        // Kapcsolódás
        $dbh = new PDO('mysql:host=localhost;dbname=bejelentkezes', 'root', '',
                        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Létezik már a felhasználói név?
        $sth = $dbh->prepare("select id from felhasznalok where bejelentkezes = :bejelentkezes");
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználói név már foglalt!";
            $ujra = true;
        }
        else {
            // Ha nem létezik, akkor regisztráljuk
            $stmt = $dbh->prepare(
                "insert into felhasznalok(csaladi_nev, uto_nev, bejelentkezes, jelszo)
                 values(:csaladinev, :utonev, :bejelentkezes, :jelszo)"
            ); 
            $stmt->execute(array(':csaladinev' => $_POST['vezeteknev'], ':utonev' => $_POST['utonev'],
                                 ':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => sha1($_POST['jelszo']))); 
            if($count = $stmt->rowCount()) {
                $uzenet = "A regisztrációja sikeres.";                     
                $ujra = false;
            }
            else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    }
    catch (PDOException $e) {
        $uzenet = "Hiba: ".$e->getMessage();
        $ujra = true;
    }      
}
else header("Location: .");
?>