<h2 class="kapcs">Jelezz vissza nekünk!</h2>
<h3 class="kapcs" id="Output"></h3>
<form class="kapcs">
    <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
        <input class="kapcs" type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
    <?php else: ?>
        <input class="kapcs" type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
    <?php endif; ?>
    <textarea class="kapcs" name="uzenet" id="ResponseArea"></textarea>
    <br><br>
    <button class="kapcs" type="submit" id="ResponseSubmit">Beküld</button>
</form>
<script src="./scripts/visszajelzes.js"></script>