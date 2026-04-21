<div id="kapcs">
    <h2>Jelezz vissza nekünk!</h2>
    <h3  id="Output"></h3>
    <form>
        <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
        <?php else: ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
        <?php endif; ?>
        <textarea name="uzenet" id="ResponseArea"></textarea>
        <br><br>
        <button type="submit" id="ResponseSubmit">Beküld</button>
    </form>
    <aside>
        <img  src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80" alt="">
        <p>
            Új technológiák használatával készült felületek. <br>
            Modern kinézet és gyorsaság.
        </p>
    </aside>
    <article>
        Számunkra nagyon fontos minden fajta visszajelzés, mely nem offenzív, hanem építő jellegű. <br>
        Ez segít nekünk abban, hogy mindig fejlődhessünk! <br> <br>
        Köszönjük: Készítők
    </article>
    <script src="./scripts/visszajelzes.js"></script>
</div>