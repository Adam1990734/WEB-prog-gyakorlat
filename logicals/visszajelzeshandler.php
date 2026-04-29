<?php
    header("Connection-Type: application/json");
    require "./visszajelzesconnect.php";

    function ReadResponses($Limitation = 20, $Specification = "")
    {
        global $LoggingData;
        if(!isset($Specification) || empty($Specification)) {
            try {
                $SQLstmnt = $LoggingData->query("SELECT bejelentkezes felhasznalo, uzenet, kelt
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

    function CreateResponse($Username, $Message) {
        global $LoggingData;
        try {
            if(empty($Username) || empty($Message))
                return true;
            $SQLstmnt = $LoggingData->prepare("INSERT INTO uzenetek(felhaszn_id, uzenet, kelt) VALUES (
                                               (SELECT id FROM felhasznalok WHERE bejelentkezes = :felhasznalo),
                                               :uzenet,
                                               NOW())
                                              ");
            
            $SQLstmnt->execute([
                ':felhasznalo' => $Username,
                ':uzenet' => $Message
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
            if(!isset($Data['felhasznalo']) || !isset($Data['uzenet']) || empty($Data['felhasznalo']) || empty($Data['uzenet']) ||
                mb_strlen($Data['uzenet'], 'UTF-8') > 100
            ) {
                echo json_encode(["Fail" => true]);
                break;
            }
            echo json_encode([
                "Fail" => CreateResponse($Data['felhasznalo'], $Data['uzenet'])
            ]);
            break;
        default:
            echo json_encode(["Fail" => true]); 
            break;
    }
?>