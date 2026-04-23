<?php if(isset($row)): ?>
    <?php if($row): ?>
        <h1>Bejelentkezett:</h1>
        Név: <strong><?= $row['csaladi_nev']." ".$row['uto_nev'] ?></strong>
        <?php unset($_SESSION["lastusername"]); ?>
    <?php else: ?>
        <h1>A bejelentkezés nem sikerült!</h1>
        <a href="belepes" >Próbálja újra!</a>
    <?php endif; ?>
<?php endif; ?>
<?php if(isset($errormessage)): ?>
    <h2><?= $errormessage ?></h2>
<?php endif; ?>
