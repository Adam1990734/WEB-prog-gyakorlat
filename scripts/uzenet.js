const Output = document.getElementById("Output");
const Loader = document.getElementById("Loader");
const Api = "./logicals/visszajelzeshandler.php";

/**@param {{felhasznalo: "", uzenet: "", kelt: ""}} Record  */
function CreateMessage(Record) {
    if(Record === null)
        throw new Error("Not loadable record data given!");
    const Row = document.createElement("div"); Row.className = "uzenet";

    const Header = document.createElement("div"); Header.className = "uzenet";
    Header.innerHTML = "<span class=\"uzenet\">" + Record.felhasznalo + "</span> <br>" + Record.kelt + "<br> <br>";

    const Content = document.createElement("article"); Content.className = "uzenet";
    Content.innerText = Record.uzenet;

    Row.appendChild(Header);
    Row.appendChild(Content);
    return Row;
}

function LoadFirstFewResponses() {
    fetch(Api)
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) throw new Error("Error while trying to load in data!");
        console.log(Data["DataList"]);
        Data["DataList"].forEach(Record => Output.appendChild(CreateMessage(Record)));
    })
    .catch(Err => console.log(Err.message));
}

function LoadAllResponses() {
    fetch(Api+"?limit=0")
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) throw new Error("Error while trying to load in data!");
        Data["DataList"].forEach(Record => Output.appendChild(CreateMessage(Record)));
    })
    .catch(Err => console.log(Err.message));
}

document.addEventListener("DOMContentLoaded", LoadFirstFewResponses);

Loader.addEventListener("click", () => {
    if(!confirm("Biztos vagy benne?")) return;
    Output.innerHTML = "";
    LoadAllResponses();
    Loader.style.display = "none";
})