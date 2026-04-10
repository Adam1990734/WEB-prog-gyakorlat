<?php session_start(); ?>
<?php if(file_exists('./logicals/'.$keres['fajl'].'.php')) { include("./logicals/{$keres['fajl']}.php"); } ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $ablakcim['cim'] . ( (isset($ablakcim['mottó'])) ? ('|' . $ablakcim['mottó']) : '' ) ?></title>
	<link rel="stylesheet" href="./styles/stilus.css" type="text/css">
	<?php var_dump($keres); ?>
	<?php if(file_exists('./styles/'.$keres['fajl'].'.css')): ?>
		<link rel="stylesheet" href="./styles/<?= $keres['fajl']?>.css" type="text/css">
	<?php endif; ?>
</head>
<body>
	<header>
		<h1><?= $fejlec['cim'] ?></h1>
		<?php if (isset($fejlec['motto'])) { ?><h2><?= $fejlec['motto'] ?></h2><?php } ?>
		<?php if(isset($_SESSION['csn']) && isset($_SESSION['un'])) { ?>Bejlentkezve: <strong><?= $_SESSION['csn']." ".$_SESSION['un']." (".$_SESSION['login'].")" ?></strong><?php } ?>
	</header>
    <div id="wrapper">
            <nav>
                <ul>
					<?php foreach ($oldalak as $url => $oldal) { ?>
						<?php if(isset($_SESSION['login']) && $oldal['menun']['fiok'] || ! isset($_SESSION['login']) && $oldal['menun']['vendeg']) { ?>
							<li<?= (($oldal == $keres) ? ' class="active"' : '') ?>>
							<a href="<?= ($url == '/') ? '.' : $url ?>">
							<?= $oldal['szoveg'] ?></a>
							</li>
						<?php } ?>
					<?php } ?>
                </ul>
            </nav>
        <div id="content">
            <?php include("./templates/pages/{$keres['fajl']}.tpl.php"); ?>
        </div>
    </div>
    <footer>
		<!-- Készítők hozzá adaása -->
        <?php if(isset($lablec['keszitok']) && is_array($lablec['keszitok'])): ?>
			<p><?php foreach($lablec['keszitok'] as $Azon => $Nev) {
				echo "$Nev ($Azon) ";
			}?></p>
		<?php endif; ?>
		<?php if(isset($lablec['keltezes'])): ?>
			<p>A készítették: <?= $lablec['keltezes']?></p>
		<?php endif; ?>
    </footer>
</body>
</html>