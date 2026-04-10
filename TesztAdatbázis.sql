CREATE DATABASE Bejelentkezes
CHARACTER SET utf8 COLLATE utf8_general_ci;

USE Bejelentkezes;

CREATE TABLE `felhasznalok` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `csaladi_nev` varchar(45) NOT NULL default '',
  `uto_nev` varchar(45) NOT NULL default '',
  `bejelentkezes` varchar(12) NOT NULL default '',
  `jelszo` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `felhasznalok` (`id`,`csaladi_nev`,`uto_nev`,`bejelentkezes`,`jelszo`) VALUES 
 (1,'Családi_1','Utónév_1','Login1',sha1('login1')),
 (2,'Családi_2','Utónév_2','Login2',sha1('login2')),
 (3,'Családi_3','Utónév_3','Login3',sha1('login3')),
 (4,'Családi_4','Utónév_4','Login4',sha1('login4')),
 (5,'Családi_5','Utónév_5','Login5',sha1('login5')),
 (6,'Családi_6','Utónév_6','Login6',sha1('login6')),
 (7,'Családi_7','Utónév_7','Login7',sha1('login7')),
 (8,'Családi_8','Utónév_8','Login8',sha1('login8')),
 (9,'Családi_9','Utónév_9','Login9',sha1('login9')),
 (10,'Családi_10','Utónév_10','Login10',sha1('login10')),
 (11,'Családi_11','Utónév_11','Login11',sha1('login11')),
 (12,'Családi_12','Utónév_12','Login12',sha1('login12'));

-- Vendég felhasználó egy 'statikus' személy mindig benne van.
INSERT INTO felhasznalok(bejelentkezes, jelszo) VALUES('vendég', '');

CREATE TABLE Uzenetek (
    id int(10) unsigned PRIMARY KEY AUTO_INCREMENT,
	felhaszn_id int(10) unsigned,
    uzenet varchar(300) NOT NULL
)
ENGINE=INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE uzenetek ADD CONSTRAINT uzenetek_fk
FOREIGN KEY(felhaszn_id) REFERENCES felhasznalok(id) ON DELETE CASCADE ON UPDATE CASCADE;