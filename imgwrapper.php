<?php
    if($_SERVER["REQUEST_METHOD"] !== "GET" || empty($_GET)) {
        http_response_code(500);
        exit();
    }
    if(!isset($_GET["id"]) || empty($_GET["id"])) {
        http_response_code(500);
        exit();
    }
    require "./logicals/visszajelzesconnect.php";

    $SQLstatment = $LoggingData->prepare("SELECT kep_tipus tipus, kep
                                          FROM kepek
                                          WHERE id = :id
                                        ");
    $SQLstatment->execute([
        "id" => $_GET["id"]
    ]);
    $Result = $SQLstatment->fetch(PDO::FETCH_ASSOC);

    if(empty($Result)) {
        http_response_code(404);
        exit();
    }

    header("Content-Type: ".$Result['tipus']);
    header("Content-Length: ".strlen($Result['kep']));
    header('Cache-Control: public, max-age=86400');

    echo $Result['kep'];
?>