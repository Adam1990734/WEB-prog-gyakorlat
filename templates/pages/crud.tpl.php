<h3 class="crud">Feltalálók tábla</h3>
<!-- Alapból ne jelenjen meg semmi -->
<div id="ResponsArea" class="crud"></div>
<form id="InputArea" class="crud">
    <label for="Name" class="crud">A feltaláló teljes neve*</label> <br>
    <input class="crud" id="Name" name="Name" type="text" ...> <br>

    <label class="crud" for="Born">A feltaláló születési éve*</label> <br>
    <input class="crud" id="Born" name="Born" type="number" ...> <br>

    <label class="crud" for="Died">A feltaláló halálozási éve</label> <br>
    <input class="crud" id="Died" name="Died" type="number" ...> <br> <br>

    <button class="crud" id="SaveButton" type="submit">Save</button>
    <button class="crud" id="ResetButton" type="reset">Clear</button>
</form>
<table class="crud">
    <thead class="crud">
        <tr class="crud">
            <th class="crud">Telejes név</th>
            <th class="crud">Születési dátum</th>
            <th class="crud">Halálozi dátum</th>
            <th class="crud">Műveletek</th>
        </tr>
    </thead>
    <!-- Ide jön majd a beolvasott adatok halmaza -->
    <tbody class="crud" id="OutputArea"></tbody>
</table>
<script src="./scripts/crud.js"></script>