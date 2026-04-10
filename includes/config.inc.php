<?php
$ablakcim = array(
    'cim' => 'Gyakorlat Beadandó',
);

$fejlec = array(
	'cim' => 'Gyakorlat Beadandó',
	'motto' => ''
);

$lablec = array(
    'keszitok' => array(
        'YB5SIV' => 'Pálmai Ádám',
        'HWF5W0' => 'Debreczeni Ákos'
    ),
    'keltezes' => '2026 tavaszi félév'
);

//Itt annyiba változtattam hogy megjelenítés függű listának adtam string kulcsot mert úgy jobban kezelhető szerintem.
// PLussz meg fordított a működést hogy leírás helyesen menjen mert most fordítva volt valamiért és cseréltem true és false-ra hogy jobban érthető legyen.
$oldalak = array(
	'/' => array('fajl' => 'fooldal', 'szoveg' => 'Főoldal', 'menun' => array('fiok' => true, 'vendeg' => true)),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Bejelentkezés', 'menun' => array( 'fiok' => false, 'vendeg' => true)),
    'kilepes' => array('fajl' => 'kilepes', 'szoveg' => 'Kijelentkezés', 'menun' => array( 'fiok' => true, 'vendeg' => false)),
    //Rejtett elemek (átmeneti oldal részek):
    'belep' => array('fajl' => 'belep', 'szoveg' => '', 'menun' => array('fiok' => false, 'vendeg' => false)),
    'regisztral' => array('fajl' => 'regisztral', 'szoveg' => '', 'menun' => array('fiok' => false, 'vendeg' => false)),
    //Interaktív oldalak:
    'kapcsolat' => array('fajl' => 'kapcs', 'szoveg' => 'Kapcsolat', 'menun' => array('fiok' => true, 'vendeg' => true)),
    'kepek' => array('fajl' => 'kepek', 'szoveg' => 'Képek', 'menun' => array('fiok' => true, 'vendeg' => false)),
    'CRUD' => array('fajl' => 'crud', 'szoveg' => 'CRUD', 'menun' => array('fiok' => true, 'vendeg' => false))
);

$hiba_oldal = array ('fajl' => '404', 'szoveg' => 'A keresett oldal nem található!');
?>