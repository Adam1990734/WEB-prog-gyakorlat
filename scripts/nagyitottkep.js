const Panel = document.getElementById("nagyitottkep");
const Name = localStorage.getItem("ImageName");
const Src = localStorage.getItem("ImageData");
if (Name && Src) {
    const ImageElement = document.getElementById("ChosenPic");
    const ImageName = document.getElementById("ChosenPicName");
    ImageElement.src = Src;
    ImageName.innerHTML = Name;
}
else
    Panel.innerHTML = "Hiba a betöltés során!";
localStorage.clear();