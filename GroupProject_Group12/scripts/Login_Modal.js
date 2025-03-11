//Assign Databse Credentials here can be further discussed how when DB is connected
var DBEmail = "";
var DBPassword = "";

function Login_User() {

    var Email =  document.getElementById("Login_Email");
    var Password = document.getElementById("Login_Password");

    console.log(Email.value)
    console.log(Password.value)
    //Error checking to see if Email is left blank 
    if (Email.value == "") {
        console.error("Email Cannot be left empty");
        Email.focus();
        Email.style.borderColor = "red";
    }
    //Error checking to see if Password is left blank 
    if (Password.value == "") {
        console.error("Password cannot be left empty");
        Password.focus();
        Password.style.borderColor = "red";
    }

    if (Email.value == DBEmail && Password.value == DBPassword) {
        // Write whatever code we want to happen after login is successful


    }

}