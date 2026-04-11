<h3 class="kepek">Kép galéria</h3>
<div class="kepek" id="ResponseArea"></div>
<form class="kepek"  action="./logicals/kephandler.php" method="POST" enctype="multipart/form-data">
    <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
        <input class="kepek" type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
    <?php else: ?>
        <input class="kepek" type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
    <?php endif; ?>
    <input class="kepek" id="Image" type="file" name="kep" accept="image/*" require> <br> <br>
    <button class="kepek" id="Submitbutton" type="submit">Feltöltése</button>
</form>
<div class="kepek" id="Output"></div>
<button class="kepek" id="Loader">Összes</button>

<script src="./scripts/kepek.js"></script>