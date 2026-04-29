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
        throw new Error("Betöltési hiba, próbálja újra!");
    if(InputElements.Image.value === null || InputElements.Image.value === "")
        throw new Error("Üres kép nem elfogadható!");
    /**@type {String} */
    const Imagetype = InputElements.Image.value.substring(InputElements.Image.value.lastIndexOf(".")+1, InputElements.Image.value.length);
    if(Imagetype !== "png" && Imagetype !== "jpg") {
        InputElements.Image.value = "";
        UserResponse.innerHTML = "Hiba a feltöltött fájl típusával, csak jpg és png!";
        throw new Error("Nem támogatott formátumok (csak JPG és PNP)!");
    }
    const Size = (Number(InputElements.Image.files[0].size) / (1024 * 1024)).toFixed(2);
    if(Size > 3 || Size === 0)
        throw new Error("Túl nagy a kép fájl, maximum 3Mb!");
    return {
        Username: InputElements.Username.value,
        Image: InputElements.Image.files[0]
    };
}

/**@param {Number} Id  */
function DeletePicture(Id) {
    if(Id == null || isNaN(Id))
        throw new Error("Id specifikációs hiba!");
    if(!confirm("Biztos benne?")) return;
    fetch(Api, {
        headers: { "Connection-Type": "application/json" },
        method: "DELETE",
        body: JSON.stringify({
            felhasznalo: InputElements.Username.value,
            kepid: Id
        })
    })
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) {
            if(Data.hasOwnProperty("Message"))
                UserResponse.innerHTML = Data.Message;
            else UserResponse.innerHTML = "Hiba a képek törlésekor!";
        }
        else {
            UserResponse.innerHTML = "Sikeres kép törlés!";
            Output.innerHTML = "";
            LoadFirstFewPictures();
        }
    })
    .catch(Err => console.log(Err.message));
}

function CreateCard(ImgName, ImgSource, ImgId = null) {
    const Card = document.createElement("div");

    const Img = document.createElement("img");
    Img.src = ImgSource;
    Img.loading = "lazy";
    Img.alt = "Egy betöltött kép";
    Img.className = "CardImage";

    Card.appendChild(Img);
    
    const Paragraph = document.createElement("p");
    Paragraph.innerHTML = ImgName;
    
    Card.appendChild(Paragraph);

    if(ImgId !== null && !isNaN(ImgId)) {
        const RemoveBtn = document.createElement("button");
        RemoveBtn.className = "Deletebtn";
        RemoveBtn.innerHTML = "Törlés";
        RemoveBtn.addEventListener("click", () => DeletePicture(ImgId));
        Card.appendChild(RemoveBtn);
    }

    return Card;
}

function LoadAllPictures() {
    fetch(Api+"?username="+encodeURIComponent(InputElements.Username.value)+"&limit=0")
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) {
            if(Data.hasOwnProperty("Message"))
                UserResponse.innerHTML = Data.Message;
            else UserResponse.innerHTML = "Hiba a képek betöltésekor!";
        }
        else {
            /**@type {Array} */
            const DataSet = Data['DataList'];
            DataSet.forEach(Picture => Output.appendChild(CreateCard(Picture['nev'], Picture['kep'], Picture.hasOwnProperty("id") ? Picture["id"] : null)));
            document.querySelectorAll(".CardImage").forEach(Card => {
                Card.addEventListener("click", () => {
                    localStorage.setItem("ImageName", Card.parentElement.querySelector("p").innerText);
                    localStorage.setItem("ImageData", Card.parentElement.querySelector("img").src);
                    window.open("./nagyitottkep.php", "_blank");
                });
            });
        }
    })
    .catch(Err => console.log(Err.message));
}

function LoadFirstFewPictures() {
    fetch(Api+"?username="+InputElements.Username.value)
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) {
            if(Data.hasOwnProperty("Message"))
                UserResponse.innerHTML = Data.Message;
            else UserResponse.innerHTML = "Hiba a képek betöltésekor!";
        }
        else {
            /**@type {Array} */
            const DataSet = Data['DataList'];
            DataSet.forEach(Picture => Output.appendChild(CreateCard(Picture['nev'], Picture['kep'], Picture.hasOwnProperty("id") ? Picture["id"] : null)));
            document.querySelectorAll(".CardImage").forEach(Card => {
                Card.addEventListener("click", () => {
                    localStorage.setItem("ImageName", Card.parentElement.querySelector("p").innerText);
                    localStorage.setItem("ImageData", Card.parentElement.querySelector("img").src);
                    window.open("./nagyitottkep.php", "_blank");
                });
            });
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
        UserResponse.innerHTML = error.message;
        LoadFirstFewPictures();
        return;
    }
    fetch(Api, {
        method: "POST",
        body: FormDataSet
    })
    .then(Resp => Resp.json())
    .then(Data => {
        if(Data.Fail) {
            if(Data.hasOwnProperty("Message"))
                UserResponse.innerHTML = Data.Message;
            else UserResponse.innerHTML = "Hiba a képek betöltésekor!";
        }
        else UserResponse.innerHTML = "Sikeres kép felötlés!";
        LoadFirstFewPictures();
    })
    .catch(Err => console.log(Err.message));
    //Bemenet ürítése:
    InputElements.Image.value = "";
    InputElements.Image.files = null;

    document.getElementById("fileName").innerHTML = "Kattints a kép kiválasztásához";
    document.getElementById("fileName").style.color = "#2c3e50";

    Submit.style.display = "none";
});

document.addEventListener("DOMContentLoaded", LoadFirstFewPictures);

Loader.addEventListener("click", () => {
    if(!confirm("Biztos vagy benne?")) return;
    Output.innerHTML = "";
    LoadAllPictures();
    Loader.style.display = "none";
})

InputElements.Image.addEventListener("change", function() {
    const fileNameDisplay = document.getElementById("fileName");
    if (this.files && this.files.length > 0) {
        fileNameDisplay.innerHTML = "Kiválasztott fájl: " + this.files[0].name;
        fileNameDisplay.style.color = "#3498db";
        Submit.style.display = "block";
    } else {
        fileNameDisplay.innerHTML = "Kattints a kép kiválasztásához";
        fileNameDisplay.style.color = "#2c3e50";
        Submit.style.display = "none";
    }
});