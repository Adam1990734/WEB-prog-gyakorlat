<?php
    header("Connection-Type: application/json");
    require "./visszajelzesconnect.php";

    function ReadResponses($Column = "", $Specification = "")
    {
        global $LoggingData;
        if(!isset($Column) && !empty($Column)) {
            try {
                $SQLstmnt = $LoggingData->query("SELECT * FROM uzenetek");
                return $SQLstmnt->fetchAll();
            } catch (Exception $e) {
                return [];
            }
        }
        try {
            $SQLstmnt = $LoggingData->prepare("SELECT * FROM uzenetek WHERE ".$Column." LIKE :Spec");
            $SQLstmnt->execute([':Spec' => $Specification]);
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
            $SQLstmnt = $LoggingData->prepare("INSERT INTO uzenetek(felhaszn_id, uzenet) VALUES (
                                               (SELECT id FROM felhasznalok WHERE bejelentkezes = :felhasznalo),
                                               :uzenet)");
            
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
    //file_put_contents("./debug.log", $Data['Username'], FILE_APPEND);
    //Az átküldött adatnak 2 paramétere lesz: felhasznalo és uzenet
    //if($Data['felhasznalo'] === null || $Data['uzenet'] === null || !empty($Data['felhasznalo']) || !empty($Data['uzenet']))
    //    echo json_encode(["Fail" => true]);
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            echo json_encode([
                "Fail" => false,
                "DataList" => ReadResponses()
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