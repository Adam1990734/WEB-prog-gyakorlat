<?php
    header("Connection-Type: application/json");
    require "./visszajelzesconnect.php";

    function CreatePicture($Username = "", $PicData = null) : bool {
        global $LoggingData;
        try {
            $SQLstmnt = $LoggingData->prepare("INSERT INTO kepek(felhaszn_id, kep_tipus, kep_nev, kep) VALUES(
                                               (SELECT id FROM felhasznalok WHERE bejelentkezes = :felhasznalo),
                                               :tipus,
                                               :nev,
                                               :kep
                                              )");
            $SQLstmnt->bindParam(':felhasznalo', $Username, PDO::PARAM_STR);
            $SQLstmnt->bindParam(':tipus', $PicData['Type'], PDO::PARAM_STR);
            $SQLstmnt->bindParam(':nev', $PicData['Name'], PDO::PARAM_STR);
            $SQLstmnt->bindParam(':kep', $PicData['Content'], PDO::PARAM_LOB);
            $SQLstmnt->execute();
            return false;
        } catch(Exception $e) {
            file_put_contents("./debug.log", 'Hiba a bevitelnél.'.$e->getMessage()."\n", FILE_APPEND);
            return true;
        }
    }

    function ReadPictures($Limitation = 10) {
        global $LoggingData;
        try {
            $SQLstmnt = null;
            if($Limitation === 0) $SQLstmnt = $LoggingData->query("SELECT kep_nev nev, kep_tipus tipus, kep
                                                                   FROM kepek
                                                                 ");
            else $SQLstmnt = $LoggingData->query("SELECT kep_nev nev, kep_tipus tipus, kep
                                                  FROM kepek
                                                  LIMIT ".$Limitation."
                                                 ");
            $Result = $SQLstmnt->fetchAll();
            foreach($Result as $key => $value)
                $Result[$key]['kep'] = base64_encode($value['kep']);
            return $Result;
        } catch(Exception $e) {
            return [];
        }
    }
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            if(empty($GetResult = ReadPictures((empty($_GET) ? 10 : 0))))
                echo json_encode(["Fail" => true]);
            echo json_encode([
                "Fail" => false,
                "DataList" => $GetResult
            ]);
            break;
        case "POST":
            //                    a kép ellenőrzése                                                      a felhasználó ellenőrzése
            if((!isset($_FILES['kep']['name']) || empty($_FILES['kep']['name'])) || !isset($_POST['felhasznalo']) || empty($_POST['felhasznalo'])) {
                file_put_contents("./debug.log", 'Hiba POST-nál', FILE_APPEND);
                echo json_encode(["Fail" => true]);
                break;
            }
            $PictureDataSet = [
                'Name' => substr($_FILES['kep']['name'], 0, strrpos($_FILES['kep']['name'], ".")),
                'Type' => mime_content_type($_FILES['kep']['tmp_name']),
                'Content' => file_get_contents($_FILES['kep']['tmp_name'])
            ];
            echo json_encode(["Fail" => CreatePicture(
                $_POST['felhasznalo'],
                $PictureDataSet
            )]);
            break;
        default:
            echo json_encode(["Fail" => true]);
            break;
    }
?>