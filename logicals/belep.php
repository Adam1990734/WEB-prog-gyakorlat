<?php
//Ez szerinte jó így ezzel nem kell semmit csinálni
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && !empty($_POST['felhasznalo']) && !empty($_POST['jelszo'])) {
    try {
        // Kapcsolódás
        $dbh = new PDO('mysql:host=localhost;dbname=bejelentkezes', 'root', '',
                        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Felhsználó keresése
        $sth = $dbh->prepare("select id, csaladi_nev, uto_nev from felhasznalok where bejelentkezes = :bejelentkezes and jelszo = sha1(:jelszo)");
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => $_POST['jelszo']));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $_SESSION['csn'] = $row['csaladi_nev'];
            $_SESSION['un'] = $row['uto_nev'];
        }
        $_SESSION['login'] = $_POST['felhasznalo'];
    }
    catch (PDOException $e) {
        $errormessage = "Hiba: Váratlan hiba feldolgozás során.";
    }      
}
else $errormessage = "Nem megfelelő adatbevitel";
?>
