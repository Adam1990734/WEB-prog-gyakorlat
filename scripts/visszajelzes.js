//Beviteli elemek html referenciái:
const InputElement = {
    Username: document.getElementById("Username"),
    ResponseElement: document.getElementById("ResponseArea")
};
const Output = document.getElementById("Output");//Ez csak azér van hogy vissza jelezen a user-nek.
const SubmitButton = document.getElementById("ResponseSubmit");
const Api = "./logicals/visszajelzeshandler.php";

function ReadUserInput() {
    if(InputElement == null)
        throw new Error("Nem lehet üres adat bevitel!");
    if (InputElement.Username.value === null || InputElement.Username.value === "")
        throw new Error("Hiba történt az oldal betöltésekor!");
    if (InputElement.ResponseElement.value === null || InputElement.ResponseElement.value === "")
        throw new Error("Nem lehet üres beviteli mező!");
    if(InputElement.ResponseElement.value.length > 100)
        throw new Error("Nem megfelelő méret, nem lehet 100 karakternél több!");
    return {
        felhasznalo: InputElement.Username.value,
        uzenet: InputElement.ResponseElement.value
    };
}

/**@param {Object} Response  */
function SendInput(Response) {
    if (Response == null)
        throw new Error("Üres adat küldés nem lehetséges!");
    fetch(Api, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(Response)
    })
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) Output.innerHTML = "A vissza jelzését nem sikerült rögzíteni!";
        else {
            Output.style.display = "block";
            Output.innerHTML = "Sikeres üzenet rögzítés!";
        }
    })
    .catch(err => console.log(err.message));
}

//Küldés szervernek:
SubmitButton.addEventListener("click", (e) => {
    e.preventDefault();
    let InputData;
    try {
        InputData = ReadUserInput();
    } catch(err) {
        Output.style.display = "block";
        Output.innerHTML = "Sikertelen üzenet küldés!";
        console.log("Sikertelen üzenet küldés: " + err.message);
    }
    SendInput(InputData);
    InputElement.ResponseElement.value = "";
    Output.style.display = "none";
    Output.innerHTML = "";
});