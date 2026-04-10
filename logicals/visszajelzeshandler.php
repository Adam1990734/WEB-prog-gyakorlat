<?php
    header("Connection-Type: application/json");
    require "./visszajelzesconnect.php";

    function ReadResponses($Column, $Specification)
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
            $SQLstmnt->execute(['Spec' => $Specification]);
            return $SQLstmnt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    function CreateResponse($DataSet) {
        global $LoggingData;
        try {
            $SQLstmnt = $LoggingData->prepare("INSERT INTO uzenet(felhaszn_id, uzenet) VALUES (:felhaszn_id, :uzenet)");
            $SQLstmnt->execute([
                $DataSet['felhasznalo'],
                $DataSet['uzenet']
            ]);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST")
        exit();
    $Data = json_decode(file_get_contents("php://input"), true); //Adat fogadása
    //file_put_contents("./debug.log", $Data['Username'], FILE_APPEND);
    //Az átküldött adatnak 2 paramétere lesz: felhasznalo és uzenet
    if($Data['felhasznalo'] === null || $Data['uzenet'] === null) {
        echo json_encode();
    }
?>