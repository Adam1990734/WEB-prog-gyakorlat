const InputElements = {
    Name: document.getElementById("Name"),
    Born: document.getElementById("Born"),
    Died: document.getElementById("Died")
};
const OutputElement = document.getElementById("OutputArea");
const ResponsElement = document.getElementById("ResponsArea");
const SaveButton = document.getElementById("SaveButton");
const ResetButton = document.getElementById("ResetButton");
const LoadAll = document.getElementById("LoadAll");
const ServerApi = "./logicals/crudhandler.php";

//================================== Fetch rendszer ========================================
let LimitLoadingMode = true;

const SelectedInventor = {
    Id: null,
    isEdit: false
};

/**@param {{Name: String, Born: String | Number, Died: String | Number}} Input  */
function IsValid(Input) {
    const NameRegex = /^([A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]+)(\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]+)+$/;
    if (Input.Name == "" || !NameRegex.test(Input.Name))
        throw new Error("Nem megfelelő név formátum!");
    if (Input.Born == "" || !Number.isInteger(parseInt(Input.Born)))
        throw new Error("Nem megfelelő születési dátum formátum!");
    if (Input.Died != "" && !Number.isInteger(parseInt(Input.Died)))
        throw new Error("Nem megfelelő halálozási dátum formátum!");
}

function ReadUserInput() {
    const InputStreamData = {
        Name: InputElements.Name.value,
        Born: InputElements.Born.value,
        Died: InputElements.Died.value
    };
    return InputStreamData;
}

//Ha ezekbe keletkezik hiba a fetch elkapja majd!
function CreateCell(Data = null) {
    const NewCell = document.createElement("td");
    if (Data === "" || Data === null) NewCell.textContent = "(null)";
    else NewCell.textContent = Data;
    NewCell.className = "crud";
    return NewCell;
}

function CreateButtonRef(Record = null, IsEditBt = false) {
    if (Record === null)
        throw new Error("Cannot create reference button without a reference (id).");

    const Button = document.createElement("button");

    if (IsEditBt) {
        Button.textContent = "Change";
        Button.className = "btn-change";
        Button.addEventListener("click", () => {
            SelectedInventor.Id = Record.fkod;
            SelectedInventor.isEdit = true;
            let index = 1;
            RecordValueList = Object.entries(Record).map(([key, value]) => value);
            Object.entries(InputElements).forEach(([key, elem]) => elem.value = RecordValueList[index++]);

            document.getElementById("InputArea").scrollIntoView({ behavior: "smooth" });
        });
        return Button;
    }

    Button.textContent = "Delete";
    Button.className = "btn-delete";
    Button.addEventListener("click", () => {
        DeleteInventor(Record.fkod);
        SelectedInventor.Id = null;
        SelectedInventor.isEdit = false;
    });
    return Button;
}

function CreateRow(Record = null) {
    if (Record === null)
        throw new Error("Cannot load an empty Record!");
    const NewRow = document.createElement("tr");
    //Adatok betöltése:
    Object.entries(Record).forEach(([key, value]) => {
        if (key !== "fkod") NewRow.appendChild(CreateCell(value));
    });
    const ButtonsCell = CreateCell(""); ButtonsCell.innerHTML = "";
    ButtonsCell.appendChild(CreateButtonRef(Record, true));//= Update button
    ButtonsCell.appendChild(CreateButtonRef(Record));//= Delete button
    NewRow.appendChild(ButtonsCell);
    NewRow.className = "crud";
    return NewRow;
}

function ReadFirstFewInventor() {
    fetch(ServerApi + "?Limit=0")
        .then(Resp => Resp.json())
        .then(Payload => {
            if (Payload.Fail)
                throw new Error("Cannot load in!");
            else {
                if (!Array.isArray(Payload.Records))
                    throw new Error("Cannot load in!");
                //Adatok betöltése:
                OutputElement.innerHTML = "";
                Payload.Records.forEach(Record => { OutputElement.appendChild(CreateRow(Record)); });
            }
        })
        .catch(Err => {
            ResponsElement.innerHTML += "Hiba: Sikeretelen adatbetöltés!<br>";
            console.log("Read: " + Err.message);
        });
}

function ReadInventors() {
    fetch(ServerApi)
        .then(Resp => Resp.json())
        .then(Payload => {
            if (Payload.Fail)
                throw new Error("Cannot load in!");
            else {
                if (!Array.isArray(Payload.Records))
                    throw new Error("Cannot load in!");
                //Adatok betöltése:
                OutputElement.innerHTML = "";
                Payload.Records.forEach(Record => { OutputElement.appendChild(CreateRow(Record)); });
            }
        })
        .catch(Err => {
            ResponsElement.innerHTML += "Hiba: Sikeretelen adatbetöltés!<br>";
            console.log("Read: " + Err.message);
        });
}

/**@param {{ Name: string; Born: number; Died: number; }} Record  */
function CreateInventor(Record) {
    fetch(ServerApi, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(Record)
    })
        .then(Resp => Resp.json())
        .then(Payload => {
            if (Payload.Fail)
                throw new Error("Cannot save Inventor!");
            else {
                ResponsElement.innerHTML += "Sikeres adat rögzítés!<br>";
                if (LimitLoadingMode)
                    ReadFirstFewInventor();
                else ReadInventors();
            }
        })
        .catch(Err => {
            ResponsElement.innerHTML = "Hiba: Sikertelen adat rögzítés!<br>";
            console.log("Create: " + Err.message);
        });
}

function DeleteInventor(Id) {
    if (!confirm("Are you sure you want to delete this inventor?")) return;
    fetch(ServerApi, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(Id)
    })
        .then(Resp => Resp.json())
        .then(Payload => {
            if (Payload.Fail)
                throw new Error("Cannot delete the selected record!");
            else {
                ResponsElement.innerHTML += "A kiválasztott eleme sikeres törlése!<br>";
                if (LimitLoadingMode)
                    ReadFirstFewInventor();
                else ReadInventors();
            }
        })
        .catch(Err => {
            ResponsElement.innerHTML = "Hiba: A kiválasztott eleme sikertelen törlése!<br>";
            console.log("Delete: " + Err.message);
        });
    ResponsElement.innerHTML = "";
}

function UpdateInventor(Id, ToThis) {
    const UpdateToThis = {
        Id: Id,
        ToThis: ToThis
    };
    fetch(ServerApi, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(UpdateToThis)
    })
        .then(Resp => Resp.json())
        .then(Payload => {
            if (Payload.Fail)
                throw new Error("Cannot update the selected record!");
            else {
                ResponsElement.innerHTML += "A kiválasztott eleme sikeres frissítése!<br>";
                if (LimitLoadingMode)
                    ReadFirstFewInventor();
                else ReadInventors();
            }
        })
        .catch(Err => {
            ResponsElement.innerHTML = "Hiba: A kiválasztott eleme sikertelen frissítése!<br>";
            console.log("Update: " + Err.message);
        });
}


//Vezérlő gomb amivel interaktálunk a szerver fele:
SaveButton.addEventListener("click", (e) => {
    e.preventDefault();

    ResponsElement.style.display = "block";
    ResponsElement.style.padding = "15px";
    ResponsElement.style.marginBottom = "20px";
    ResponsElement.style.borderRadius = "5px";

    ResponsElement.innerHTML = "";

    const InputValues = ReadUserInput();
    try { IsValid(InputValues); }
    catch (Err) { ResponsElement.innerHTML = Err.message; return; }

    if (SelectedInventor.isEdit)
        UpdateInventor(SelectedInventor.Id, InputValues);
    else
        CreateInventor(InputValues);

    // Input elemek nullázása:
    Object.entries(InputElements).forEach(([key, elem]) => elem.value = "");

    SelectedInventor.Id = null;
    SelectedInventor.isEdit = false;
});

LoadAll.addEventListener("click", () => {
    LimitLoadingMode = !LimitLoadingMode;
    if (LimitLoadingMode) {
        LoadAll.innerText = "Összes";
        ReadFirstFewInventor();
    }
    else {
        if(!confirm("Biztos vagy benne?"))  {
            LimitLoadingMode = true;
            return;
        }
        LoadAll.innerText = "Néhány";
        ReadInventors();
    }
});

ResetButton.addEventListener("reset", () => {
    SelectedInventor.Id = null;
    SelectedInventor.isEdit = false;
});

document.addEventListener("DOMContentLoaded", ReadFirstFewInventor);