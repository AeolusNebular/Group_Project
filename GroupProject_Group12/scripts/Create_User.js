function Element_Empty(Param) {
  if (!Param || Param.value.trim() === "") {
    Param.classList.add("border-danger");
    Param.focus();
    return true;
  } else {
    Param.classList.remove("border-danger");
    return false;
  }
}

function ConfirmedPass(Param1, Param2) {
  if (Param1.value && Param1.value === Param2.value && Param2.value) {
    console.log("Match");
    return true;
  } else {
    document.getElementById("passwordError").innerText =
      "Passwords do not match!";
    return false;
  }
}

function Create_New_User() {
  var Email = document.getElementById("Email");
  var Password = document.getElementById("Password");
  var ConPass = document.getElementById("ConPass");
  var Networks = document.getElementById("Networks")
    ? document.getElementById("Networks").value
    : "";
  var City = document.getElementById("Cities")
    ? document.getElementById("Cities").value
    : "";

  var CorrectInfo =
    !Element_Empty(Email) &&
    !Element_Empty(Password) &&
    !Element_Empty(ConPass) &&
    ConfirmedPass(Password, ConPass);

  console.log("Form valid:", CorrectInfo);

  if (CorrectInfo) {
    // Posts information above into DB if CorrectInfo is true
    alert("User Created");
  }
}

function UserType() {
  var NetworkUser = document.getElementById("Network_User").checked;
  var CityUser = document.getElementById("City_Council_User").checked;

  document.getElementById("Network_Select").style.display = NetworkUser
    ? "block"
    : "none";
  document.getElementById("City_Select").style.display = CityUser
    ? "block"
    : "none";

  if (NetworkUser) {
    document.getElementById("City_Council_User").checked = false;
  }
  if (CityUser) {
    document.getElementById("Network_User").checked = false;
  }
}
