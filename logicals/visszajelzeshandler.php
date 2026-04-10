<?php
    header("Connection-Type: application/json");
    require "./visszajelzesconnect.php";

    function ReadResponses($Limitation = 20, $Specification = "")
    {
        global $LoggingData;
        if(!isset($Specification) || empty($Specification)) {
            try {
                $SQLstmnt = null;
                if($Limitation !== 0) $SQLstmnt = $LoggingData->query("SELECT bejelentkezes felhasznalo, uzenet, kelt
                                                 FROM uzenetek JOIN felhasznalok ON uzenetek.felhaszn_id = felhasznalok.id
                                                 ORDER BY 3 desc
                                                 LIMIT ".$Limitation."
                                                ");
                else $SQLstmnt = $LoggingData->query("SELECT bejelentkezes felhasznalo, uzenet, kelt
                                                 FROM uzenetek JOIN felhasznalok ON uzenetek.felhaszn_id = felhasznalok.id
                                                 ORDER BY 3 desc
                                                ");
                return $SQLstmnt->fetchAll();
            } catch (Exception $e) {
                return [];
            }
        }
        try {
            $SQLstmnt = $LoggingData->prepare("SELECT bejelentkezes felhasznalo, uzenet, kelt
                                               FROM uzenetek JOIN felhasznalok ON uzenetek.felhaszn_id = felhasznalok.id
                                               WHERE uzenet LIKE :Spec
                                               ORDER BY 3 desc
                                               LIMIT ".$Limitation."
                                              ");
            $SQLstmnt->execute([':Spec' => "%".$Specification."%"]);
            return $SQLstmnt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    function CreateResponse($DataSet = null) {
        global $LoggingData;
        try {
            if($DataSet == null)
                throw new Exception("No data given!");
            $SQLstmnt = $LoggingData->prepare("INSERT INTO uzenetek(felhaszn_id, uzenet, kelt) VALUES (
                                               (SELECT id FROM felhasznalok WHERE bejelentkezes = :felhasznalo),
                                               :uzenet,
                                               NOW())
                                              ");
            
            $SQLstmnt->execute([
                ':felhasznalo' => $DataSet['felhasznalo'],
                ':uzenet' => $DataSet['uzenet']
            ]);
            return false;
        } catch(Exception $e) {
            return true;
        }
    }

    $Data = json_decode(file_get_contents("php://input"), true); //Adat fogadása

    //var_dump(ReadResponses());
    //exit();
    //file_put_contents("./debug.log", $Data['Username'], FILE_APPEND);
    //Az átküldött adatnak 2 paramétere lesz: felhasznalo és uzenet
    //if($Data['felhasznalo'] === null || $Data['uzenet'] === null || !empty($Data['felhasznalo']) || !empty($Data['uzenet']))
    //    echo json_encode(["Fail" => true]);
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            if(empty($_GET)) echo json_encode([
                "Fail" => false,
                "DataList" => ReadResponses()
            ]);
            else echo json_encode([
                "Fail" => false,
                "DataList" => ReadResponses(0)
            ]);
            break;
        case "POST":
            //file_put_contents("./debug.log", $Data, FILE_APPEND);
            echo json_encode([
                "Fail" => CreateResponse($Data)
            ]);
            break;
        default:
            echo json_encode(["Fail" => true]); 
            break;
    }
?>