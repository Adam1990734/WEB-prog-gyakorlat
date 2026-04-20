<div id="kapcs">
    <h2 >Jelezz vissza nekünk!</h2>
    <h3  id="Output"></h3>
    <form >
        <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="<?= $_SESSION['login'] ?>">
        <?php else: ?>
            <input  type="text" style="display: none;" id="Username" name="felhasznalo" value="vendég">
        <?php endif; ?>
        <textarea name="uzenet" id="ResponseArea"></textarea>
        <br><br>
        <button type="submit" id="ResponseSubmit">Beküld</button>
    </form>
    <!-- itt a CSS még nem működik
    <aside >
        <img  src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80" alt="">
        <p >
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cumque vitae est a sed dolores nisi eaque placeat tempora, commodi perferendis maiores sit nihil consequatur veritatis quia distinctio esse? Officiis, illo!
        </p>
    </aside>
    -->
    <script src="./scripts/visszajelzes.js"></script>
</div>