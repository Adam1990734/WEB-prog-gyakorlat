<!-- <link rel="stylesheet" href="./styles/crudstyle.css" type="text/css"> -->
<h2>Jelezz vissza nekünk!</h2>
<h3 id="Output"></h3>
<form>
    <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
        <input type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
    <?php else: ?>
        <input type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
    <?php endif; ?>
    <textarea name="uzenet" id="ResponseArea"></textarea>
    <br><br>
    <button type="submit" id="ResponseSubmit">Beküld</button>
</form>

<script src="./scripts/visszajelzes.js"></script>