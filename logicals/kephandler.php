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
            //file_put_contents("./debug.log", 'Hiba a bevitelnél.'.$e->getMessage()."\n", FILE_APPEND);
            return true;
        }
    }

    function ReadPictures($Username = "", $Limitation = 10) {
        global $LoggingData;
        try {
            $SQLstmnt = null;
            if(!isset($Username) || empty($Username) || $Username === 'vendég') {
                if($Limitation === 0) $SQLstmnt = $LoggingData->query("SELECT kep_nev nev, id kep
                                                                       FROM kepek");
                else $SQLstmnt = $LoggingData->query("SELECT kep_nev nev, id kep
                                                      FROM kepek
                                                      LIMIT ".
                                                      $Limitation
                                                    );
                $SQLstmnt->execute();
                $Result = $SQLstmnt->fetchAll();
                foreach($Result as $key => $value)
                    $Result[$key]['kep'] = './imgwrapper.php?id='.$Result[$key]['kep'];
                return $Result;
            }
            if($Limitation === 0) $SQLstmnt = $LoggingData->prepare("SELECT id, kep_nev nev, id kep
                                                                   FROM kepek
                                                                   WHERE felhaszn_id = (
                                                                        SELECT id FROM felhasznalok
                                                                        WHERE bejelentkezes = :felhasznalonev
                                                                   )
                                                                   UNION ALL
                                                                   SELECT NULL, kep_nev nev, id kep
                                                                   FROM kepek
                                                                   WHERE NOT felhaszn_id = (
                                                                        SELECT id FROM felhasznalok
                                                                        WHERE bejelentkezes = :felhasznalonev
                                                                   )
                                                                  ");
            else $SQLstmnt = $LoggingData->prepare("SELECT id, kep_nev nev, id kep
                                                  FROM kepek
                                                  WHERE felhaszn_id = (
                                                        SELECT id FROM felhasznalok
                                                        WHERE bejelentkezes = :felhasznalonev
                                                  )
                                                  UNION ALL
                                                  SELECT NULL, kep_nev nev, id kep
                                                  FROM kepek
                                                  WHERE NOT felhaszn_id = (
                                                    SELECT id FROM felhasznalok
                                                    WHERE bejelentkezes = :felhasznalonev
                                                  )
                                                  LIMIT "
                                                  .$Limitation
                                                );
            $SQLstmnt->execute([
                'felhasznalonev' => $Username
            ]);
            $Result = $SQLstmnt->fetchAll();
            foreach($Result as $key => $value)
                $Result[$key]['kep'] = './imgwrapper.php?id='.$Result[$key]['kep'];
            return $Result;
        } catch(Exception $e) {
            return [];
        }
    }

    function DeletePicture($Username, $PicId) {
        if(!isset($PicId) || empty($PicId) || !isset($Username) || empty($Username))
            return true;//A visszadási értékhez igazodik azért true
        global $LoggingData;
        try {
            $SQLstmnt = $LoggingData->prepare("DELETE FROM kepek
                                               WHERE id = :kepid
                                               AND felhaszn_id = (
                                                    SELECT id
                                                    FROM felhasznalok
                                                    WHERE bejelentkezes = :felhasznalonev
                                             )");
            $SQLstmnt->execute([
                'felhasznalonev' => $Username,
                'kepid' => $PicId
            ]);
            return false;
        } catch(Exception $e) {
            return true;
        }
    }

    //Ez vizsgálja hogy a user max 5 képet tölthet fel (szűkös hely használat miatt csináltam)
    function NumberOfPic($Username) {
        if(!isset($Username) && empty($Username))
            return -1;//-1 lesz a hiba érték
        global $LoggingData;
        try {
            $SQLstmnt =$LoggingData->prepare("SELECT COUNT(*)
                                               FROM kepek
                                               WHERE felhaszn_id = (
                                                    SELECT id
                                                    FROM felhasznalok
                                                    WHERE bejelentkezes = ?
                                               )");
            $SQLstmnt->execute([$Username]);
            return $SQLstmnt->fetchColumn();
        } catch(Exception $e) {
            return -1;
        }
    }
    
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            if(empty($GetResult = ReadPictures((empty($_GET['username']) ? "" : $_GET['username']), (isset($_GET['limit']) ? 0 : 10))))
                echo json_encode(["Fail" => true]);
            echo json_encode([
                "Fail" => false,
                "DataList" => $GetResult
            ]);
            break;
        case "POST":
            //                    a kép ellenőrzése                                                      a felhasználó ellenőrzése
            if((!isset($_FILES['kep']['name']) || empty($_FILES['kep']['name'])) || !isset($_POST['felhasznalo']) || empty($_POST['felhasznalo'])) {
                //file_put_contents("./debug.log", 'Hiba POST-nál', FILE_APPEND);
                echo json_encode(["Fail" => true]);
                break;
            }
            $Size = $_FILES['kep']['size'] / (1024 * 1024);
            //file_put_contents("./debug.log", $Size.' képméret', FILE_APPEND);
            if($Size > 3 || $Size == 0) {
                echo json_encode([
                    "Fail" => true,
                    "Message" => "Túl nagy a feltötlött kép mérete a megengedettnél (3Mb max)!"
                ]);
                break;
            }
            if($_POST['felhasznalo'] == 'vendég') {
                echo json_encode([
                    "Fail" => true,
                    "Message" => "Nem engedélyezett felhasználó"
                ]);
                break;
            }
            $HasPicNum = NumberOfPic($_POST['felhasznalo']);
            //file_put_contents("./debug.log", 'A képek száma: '.$HasPicNum."\n", FILE_APPEND);
            if($HasPicNum >= 5 || NumberOfPic($_POST['felhasznalo']) === -1) {
                echo json_encode([
                    "Fail" => true,
                    "Message" => "A felhasznaló túllépte a megengedett kép számot! (max 5 kép)"
                ]);
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
        case "DELETE":
            $Data = json_decode(file_get_contents("php://input"), true);
            //file_put_contents("./debug.log", 'A kép száma: '.print_r($Data, true)."\n", FILE_APPEND);
            //break;
            if(!isset($Data['felhasznalo']) || empty($Data['felhasznalo']) && !isset($Data['kepid']) || empty($Data['kepid'])) {
                echo json_encode([ "Fail" => true ]);
                break;
            }
            echo json_encode([
                "Fail" => DeletePicture($Data['felhasznalo'], $Data['kepid'])
            ]);
            break;
        default:
            echo json_encode(["Fail" => true]);
            break;
    }
?>