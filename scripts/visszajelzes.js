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
        throw new Error("The given given data is empty!");
    if (InputElement.Username.value === null || InputElement.Username.value === "")
        throw new Error("Cannot identify the current user!");
    if (InputElement.ResponseElement.value === null || InputElement.ResponseElement.value === "")
        throw new Error("Nothing has written yet!");
    return {
        felhasznalo: InputElement.Username.value,
        uzenet: InputElement.ResponseElement.value
    };
}

/**@param {Object} Response  */
function SendInput(Response) {
    if (Response == null)
        throw new Error("Unable to fetch with an empty Response message!");
    fetch(Api, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(Response)
    })
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) Output.innerHTML = "A vissza jelzését nem sikerült rögzíteni!";
        else Output.innerHTML = "Sikeres üzenet rögzítés!";
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
        Output.innerHTML = "Sikeretelen üzenet küldés!";
        console.log("Sikertelen üzenet küldés: " + err.message);
    }
    SendInput(InputData);
});