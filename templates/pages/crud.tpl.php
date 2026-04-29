<div id="crud">
    <h3>Feltalálók tábla</h3>
    <!-- Alapból ne jelenjen meg semmi -->
    <div id="ResponsArea"></div>
    <form id="InputArea">
        <label for="Name" >A feltaláló teljes neve*</label> <br>
        <input id="Name" name="Name" type="text" ...> <br>

        <label for="Born">A feltaláló születési éve*</label> <br>
        <input id="Born" name="Born" type="number" ...> <br>

        <label for="Died">A feltaláló halálozási éve</label> <br>
        <input id="Died" name="Died" type="number" ...> <br> <br>

        <button id="SaveButton" type="submit">Mentés</button>
        <button id="ResetButton" type="reset">Visszaállít</button>
    </form>
    <div class="table-header-actions">
        <button id="LoadAll">Összes</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Telejes név</th>
                <th>Születési dátum</th>
                <th>Halálozi dátum</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <!-- Ide jön majd a beolvasott adatok halmaza -->
        <tbody id="OutputArea"></tbody>
    </table>
    <script src="./scripts/crud.js"></script>
</div>