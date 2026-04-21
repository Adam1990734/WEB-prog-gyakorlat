<div id="kepek">
    <h3 >Kép galéria</h3>
    <div id="ResponseArea"></div>
    <form action="./logicals/kephandler.php" method="POST" enctype="multipart/form-data">
        <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
        <?php else: ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
        <?php endif; ?>
        <input id="Image" type="file" name="kep" accept="image/*" require> <br> <br>
        <button id="Submitbutton" type="submit">Feltöltése</button>
    </form>
    <div id="Output"></div>
    <button id="Loader">Összes</button>

    <script src="./scripts/kepek.js"></script>
</div>