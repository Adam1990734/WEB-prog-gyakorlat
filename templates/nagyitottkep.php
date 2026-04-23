<!DOCTYPE html>
<html lang="hu">
    <head>
        <title id="ChosenPicName"></title>
    </head>
    <body>
        <div id="nagyitottkep">
            <img id="ChosenPic" alt="valasztott kép">
        </div>
    </body>
</html>

<script>
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
</script>