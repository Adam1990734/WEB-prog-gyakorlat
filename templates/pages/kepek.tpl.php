<div id="kepek">
    <h3 >Kép galéria</h3>
    <div id="ResponseArea"></div>
    <form action="./logicals/kephandler.php" method="POST" enctype="multipart/form-data" id="uploadForm">
    <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
        <input type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
    <?php else: ?>
        <input type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
    <?php endif; ?>

    <div class="upload-container">
        <label for="Image" class="custom-file-upload">
            <span class="upload-icon">📁</span>
            <span id="fileName">Kattints a kép kiválasztásához</span>
            <p class="file-hint">(Csak JPG vagy PNG fogadott)</p>
        </label>
        <input id="Image" type="file" name="kep" accept="image/*" required>
    </div>

    <button id="Submitbutton" type="submit">Feltöltés indítása</button>
    </form>
    <div id="Output"></div>
    <button id="Loader">Összes</button>

    <script src="./scripts/kepek.js"></script>
</div>