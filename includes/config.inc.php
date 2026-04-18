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
//A kiemelt kulcs értéknek a lényege hogy külön listába teszi hogy ne keveredjen a sima menü pontokkal (sítul szempontból)
$oldalak = array(
	'/' => array('fajl' => 'fooldal', 'szoveg' => 'Főoldal', 'menun' => array('fiok' => true, 'vendeg' => true), 'kiemelt' => false),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Bejelentkezés', 'menun' => array( 'fiok' => false, 'vendeg' => true), 'kiemelt' => true),
    'kilepes' => array('fajl' => 'kilepes', 'szoveg' => 'Kijelentkezés', 'menun' => array( 'fiok' => true, 'vendeg' => false), 'kiemelt' => true),
    //Rejtett elemek (átmeneti oldal részek):
    'belep' => array('fajl' => 'belep', 'szoveg' => '', 'menun' => array('fiok' => false, 'vendeg' => false)),
    'regisztral' => array('fajl' => 'regisztral', 'szoveg' => '', 'menun' => array('fiok' => false, 'vendeg' => false)),
    //Interaktív oldalak:
    'kapcsolat' => array('fajl' => 'kapcs', 'szoveg' => 'Kapcsolat', 'menun' => array('fiok' => true, 'vendeg' => true), 'kiemelt' => false),
    'uzenetek' => array('fajl' => 'uzenet', 'szoveg' => 'Üzenetek', 'menun' => array('fiok' => true, 'vendeg' => false), 'kiemelt' => false),
    'kepek' => array('fajl' => 'kepek', 'szoveg' => 'Képek', 'menun' => array('fiok' => true, 'vendeg' => true), 'kiemelt' => false),
    'CRUD' => array('fajl' => 'crud', 'szoveg' => 'CRUD', 'menun' => array('fiok' => true, 'vendeg' => true), 'kiemelt' => false)
);
$hiba_oldal = array ('fajl' => '404', 'szoveg' => 'A keresett oldal nem található!');
?>