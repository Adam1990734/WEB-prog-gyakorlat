<?php
    //Adatbázis beállítása:
    header("Content-Type: application/json");
    require("./crudconnect.php");

    function ReadInventors($Limit = 0) {
        global $DatabaseAPI;
        //file_put_contents(__DIR__."/debug.log", "Read: ".$Limit."\n", FILE_APPEND);
        if($Limit <= 0) {
            $SQLstmnt = $DatabaseAPI->query("SELECT * FROM kutato");
            return $SQLstmnt->fetchAll();
        }
        $SQLstmnt = $DatabaseAPI->query("SELECT * FROM kutato LIMIT ".$Limit);
        return $SQLstmnt->fetchAll();
    }

    function CreateInventor($NewInventor) {
        global $DatabaseAPI;
        //file_put_contents(__DIR__."/debug.log", "CREATE: ".print_r(empty($NewInventor["Died"]) ? null : $NewInventor["Died"], true)."\n", FILE_APPEND);
        try {
            $SQLstmnt = $DatabaseAPI->prepare("INSERT INTO kutato(nev, szul, meghal) VALUES (?,?,?)");
            $SQLstmnt->execute([
                $NewInventor["Name"],
                $NewInventor["Born"],
                empty($NewInventor["Died"]) ? null : $NewInventor["Died"]
            ]);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function UpdateInventor($Id, $NewAttributes) {
        global $DatabaseAPI;
        try {
            $SQLstmnt = $DatabaseAPI->prepare("UPDATE kutato SET nev = ?, szul = ?, meghal = ? WHERE fkod = ?");
            $SQLstmnt->execute([
                $NewAttributes["Name"],
                $NewAttributes["Born"],
                empty($NewAttributes["Died"]) ? null : $NewAttributes["Died"],
                $Id
            ]);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    function DeleteInventor($Id) {
        global $DatabaseAPI;
        try {
            $SQLstmnt = $DatabaseAPI->prepare("DELETE FROM kutato WHERE fkod = ?");
            $SQLstmnt->execute([$Id]);
        } catch(Exception $e) {
            //file_put_contents(__DIR__."/debug.log", "DELETE: ".$e->getMessage()."\n", FILE_APPEND);
            throw new Exception($e->getMessage());
        }
    }

    //Inventorra mintázva
    function IsValid($Inventor) {
        if(!isset($Inventor) || empty($Inventor))
            return false;
        if(!isset($Inventor["Name"])
            || empty($Inventor["Name"])
            || preg_match('/^([A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]+)(\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]+)+$/', $Inventor["Name"]) !== 1
        ) return false;
        if(!isset($Inventor["Born"]) || !is_numeric($Inventor["Born"]) || empty($Inventor["Born"]))
            return false;
        if(!isset($Inventor["Died"]) || (!is_numeric($Inventor["Died"]) && !empty($Inventor["Died"])))
            return false;
        return true;
    }
    
    /*Methode szerint feldolgozás
      - GET ===> READ kérelem
      - POST ===> CREATE kérelem
      - PUT ===> UPDATE kérelem
      - DELETE => Törlés kérelem
    */
    $RequestType = $_SERVER["REQUEST_METHOD"];
    switch ($RequestType) {
        case "GET":
            try {
                //file_put_contents(__DIR__."/debug.log", "GET: ".print_r($_GET, true)."\n", FILE_APPEND);
                if(!empty($_GET)) {
                    echo json_encode([
                        "Fail" => false,
                        "Records" => ReadInventors(10)
                    ]);
                    exit();
                }
                echo json_encode([
                    "Fail" => false,
                    "Records" => ReadInventors()
                ]);
            } catch(Exception $e) {
                echo json_encode([
                    "Fail" => true
                ]);
            }
            break;
        case "POST":
            try {
                $Data = json_decode(file_get_contents("php://input"), true);
                if(!IsValid($Data))
                    echo json_encode([
                        "Fail" => true
                    ]);
                CreateInventor($Data);
                echo json_encode([
                    "Fail" => false
                ]);
            } catch(Exception $e) {
                echo json_encode([
                    "Fail" => true
                ]);
            }
            break;
        case "PUT":
            try {
                $Data = json_decode(file_get_contents("php://input"), true);
                if(!IsValid($Data["ToThis"]))
                    echo json_encode([
                        "Fail" => true
                    ]);
                UpdateInventor($Data["Id"], $Data["ToThis"]);
                echo json_encode([
                    "Fail" => false
                ]);
            } catch(Exception $e) {
                echo json_encode([
                    "Fail" => true
                ]);
            }
            break;
        case "DELETE":
            try {
                $Data = json_decode(file_get_contents("php://input"), true);
                DeleteInventor($Data);
                echo json_encode([
                    "Fail" => false
                ]);
            } catch(Exception $e) {
                echo json_encode([
                    "Fail" => true
                ]);
            }
            break;
        default:
            //Ha nincs talált methode akkor egyszerűen hiba üzenet minden más kérelemre!
            echo json_encode([
                "Fail" => true
            ]);
            break;
    }
?>