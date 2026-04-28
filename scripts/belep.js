const ResponseElement = document.getElementById("Output");

/**@param {Object} Input  */
function IsNullAny(Input) {
    for(const Elem of Object.values(Input))
        if(Elem == null || Elem == "")
            return true;
    return false;
}

function ValidateRegistration() {
    const CurrentInput = {
        UserName: document.getElementById("UserName").value.trim(),
        LastName: document.getElementById("LastName").value.trim(),
        FirstName: document.getElementById("FirstName").value.trim(),
        Password: document.getElementById("Password").value.trim()
    };
    if(IsNullAny(CurrentInput))
        throw new Error("Üres beviteli mező sehol nem engedélyezett!");
    const NameRegex = /^\p{Lu}\p{Ll}+$/u;
    if(!NameRegex.test(CurrentInput.LastName))
        throw new Error("Nem megfelelő vezetéknév formátum!");
    if(!NameRegex.test(CurrentInput.FirstName))
        throw new Error("Nem megfelelő keresztnév formátum!");
}

function ValidateLogin() {
    const CurrentInput = {
        UserName: document.getElementById("LoginUser").value.trim(),
        Password: document.getElementById("LoginPass").value.trim()
    };
    if(IsNullAny(CurrentInput))
        throw new Error("Üres beviteli mező sehol nem engedélyezett!");
}

document.getElementById("belepes").addEventListener("submit", (e) => {
    try { ValidateLogin(); }
    catch(Err) {
        e.preventDefault();
        ResponseElement.style.display = "block";
        ResponseElement.innerHTML = Err.message;
    }
});

document.getElementById("regisztracio").addEventListener("submit", (e) => {
    try { ValidateRegistration(); }
    catch(Err) {
        e.preventDefault();
        ResponseElement.style.display = "block";
        ResponseElement.innerHTML = Err.message;
    }
});