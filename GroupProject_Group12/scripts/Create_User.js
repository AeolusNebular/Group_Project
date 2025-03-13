function Element_Empty(Param) {
    if (Param.value === "") {
        Param.classList.add("border-danger")
        Param.focus();
        return true;        
    } else {
        Param.classList.remove("border-danger")
        return false;
    }
}

function ConfirmedPass(Param1,Param2) {
    if (Param1.value && Param1.value === Param2.value && Param2.value) {
        console.log("Match")
        return true;
        
    } else {
       alert("Passwords do not match!!!!!!!")
       return false;
    }
}

function Create_New_User() {
    var Networks = document.getElementById("Networks").value;
    var City = document.getElementById("Cities").value;
    var Email = document.getElementById("Email");
    var Password = document.getElementById("Password");
    var ConPass = document.getElementById("ConPass");
    var CorrectInfo = !Element_Empty(Email) && !Element_Empty(Password) && !Element_Empty(ConPass) && ConfirmedPass(Password,ConPass);

    console.log(CorrectInfo)
    
    if (CorrectInfo) {
        //Posts Information above into DB if CorrectInfo is true 
    }
}

function UserType() {
    var NetworkUser = document.getElementById("Network User").checked; 
    var CityUser = document.getElementById("City Council User").checked;
    
    if (NetworkUser) {
        document.getElementById("City Council User").checked = false;
        document.getElementById("Network_Select").style.display = "block";
        document.getElementById("City_Select").style.display = "none";
    } else {
        document.getElementById("Network_Select").style.display = "none"; 
    }
    
    if (CityUser) {
        document.getElementById("Network User").checked = false;
        document.getElementById("City_Select").style.display = "block";
        document.getElementById("Network_Select").style.display = "none";          
    } else {
        document.getElementById("City_Select").style.display = "none";
    }
    
}