<!DOCTYPE html>
<html>
    <head>
        <title>Regisztráció</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php if(isset($uzenet)): ?>
            <h1><?= $uzenet ?></h1>
            <?php if($ujra): ?>
                <a href="belepes">Próbálja újra!</a>
            <?php endif; ?>
        <?php endif; ?>
    </body>  
</html>