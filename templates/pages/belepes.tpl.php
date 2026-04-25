<h3 id="Output" style="display: none;"></h3>
<form action="belep" method="post" id="belepes">
  <fieldset>
    <legend>Bejlentkezés</legend>
    <br>
    <input type="text" id="LoginUser"
      <?php if(isset($_SESSION['lastusername']) && !empty($_SESSION['lastusername'])): ?>
        value="<?= $_SESSION['lastusername'] ?>"
      <?php endif; ?>
      name="felhasznalo" placeholder="felhasználó" required><br><br>
    <input type="password" id="LoginPass" name="jelszo" placeholder="jelszó" required><br><br>
    <input type="submit" name="belepes" value="Belépés">
    <br>&nbsp;
  </fieldset>
</form>
<h2>Regisztrálja magát, ha még nem felhasználó!</h2>
<form action="regisztral" method="post" id="regisztracio">
  <fieldset>
    <legend>Regisztráció</legend>
    <br>
    <input type="text" id="LastName" name="vezeteknev" placeholder="vezetéknév" required><br><br>
    <input type="text" id="FirstName" name="utonev" placeholder="utónév" required><br><br>
    <input type="text" id="UserName" name="felhasznalo" placeholder="felhasználói név" required><br><br>
    <input type="password" id="Password" name="jelszo" placeholder="jelszó" required><br><br>
    <input type="submit" name="regisztracio" value="Regisztráció">
    <br>&nbsp;
  </fieldset>
</form>
<script src="./scripts/belep.js"></script>