const InputElements = {
    Username: document.getElementById("Username"),
    Image: document.getElementById("Image")
};
const Api = "./logicals/kephandler.php";
const Submit = document.getElementById("Submitbutton");
const UserResponse = document.getElementById("ResponseArea");
const Output = document.getElementById("Output");
const Loader = document.getElementById("Loader");

function ReadInput() {
    if(InputElements.Username.value === null || InputElements.Username.value === "")
        throw new Error("There must be an owner of the picture!");
    if(InputElements.Image.value === null || InputElements.Image.value === "")
        throw new Error("There must a be picture attached!");
    /**@type {String} */
    const Imagetype = InputElements.Image.value.substring(InputElements.Image.value.lastIndexOf(".")+1, InputElements.Image.value.length);
    if(Imagetype !== "png" && Imagetype !== "jpg") {
        InputElements.Image.value = "";
        UserResponse.innerHTML = "Hiba a feltöltött fájl típusával, csak jpg és png!";
        throw new Error("Not compatible type of image given! (only jpg and png accepted)");
    }
    return {
        Username: InputElements.Username.value,
        Image: InputElements.Image.files[0]
    };
}

function CreateCard(ImgName, ImgType, ImgSource) {
    const Card = document.createElement("div");
    Card.className = "kepek";

    const Img = document.createElement("img");
    Img.className = "kepek";
    Img.src = "data:" + ImgType + ";base64," + ImgSource;
    Img.alt = "Egy betöltött kép";

    Card.appendChild(Img);
    
    const Paragraph = document.createElement("p");
    Paragraph.className = "kepek";
    Paragraph.innerHTML = ImgName;
    
    Card.appendChild(Paragraph);

    return Card;
}

function LoadAllPictures() {
    fetch(Api+"?limit=0")
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) UserResponse.innerHTML = "Hiba a képek betöltésekor!";
        else {
            /**@type {Array} */
            const DataSet = Data['DataList'];
            DataSet.forEach(Picture => Output.appendChild(CreateCard(Picture['nev'], Picture['tipus'], Picture['kep'])));
        }
    })
    .catch(Err => console.log(Err.message));
}

function LoadFirstFewPictures() {
    fetch(Api)
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) UserResponse.innerHTML = "Hiba a képek betöltésekor!";
        else {
            /**@type {Array} */
            const DataSet = Data['DataList'];
            DataSet.forEach(Picture => Output.appendChild(CreateCard(Picture['nev'], Picture['tipus'], Picture['kep'])));
        }
    })
    .catch(Err => console.log(Err.message));
}

Submit.addEventListener("click", (e) => {
    e.preventDefault();
    Output.innerHTML = "";
    const FormDataSet = new FormData();
    try {
        const DataSet = ReadInput();
        FormDataSet.append("felhasznalo", DataSet.Username);
        FormDataSet.append("kep", DataSet.Image);
    } catch (error) {
        console.log(error.message);
    }
    fetch(Api, {
        method: "POST",
        body: FormDataSet
    })
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) UserResponse.innerHTML = "Hiba a kép feltöltéskor!";
        else UserResponse.innerHTML = "Sikeres kép felötlés!";
        LoadAllPictures();
    })
    .catch(Err => console.log(Err.message));
    //Bemenet ürítése:
    InputElements.Image.value = "";
    InputElements.Image.files = null;
});

document.addEventListener("DOMContentLoaded", LoadFirstFewPictures);

Loader.addEventListener("click", () => {
    if(!confirm("Biztos vagy benne?")) return;
    Output.innerHTML = "";
    LoadAllPictures();
    Loader.style.display = "none";
})