const Output = document.getElementById("Output");
const Loader = document.getElementById("Loader");
const Api = "./logicals/visszajelzeshandler.php";

/**@param {Object} Record  */
function CreateRow(Record) {
    if(Record === null)
        throw new Error("Not loadable record data given!");
    const Row = document.createElement("tr");
    Object.entries(Record).forEach(([key, value]) => {
        const Cell = document.createElement("td");
        Cell.className = "uzenet";
        Cell.innerText = value;
        Row.appendChild(Cell);
    });
    Row.className = "uzenet";
    return Row;
}

function LoadFirstFewResponses() {
    fetch(Api)
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) throw new Error("Error while trying to load in data!");
        Data["DataList"].forEach(Record => Output.appendChild(CreateRow(Record)));
    })
    .catch(Err => console.log(Err.message));
}

function LoadAllResponses() {
    fetch(Api+"?limit=0")
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) throw new Error("Error while trying to load in data!");
        Data["DataList"].forEach(Record => Output.appendChild(CreateRow(Record)));
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