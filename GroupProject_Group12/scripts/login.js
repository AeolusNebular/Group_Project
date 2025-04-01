// 🎯 Function to handle user login
function Login_User(DBEmail,DBPassword) {

    var Email =  document.getElementById("Login_Email");
    var Password = document.getElementById("Login_Password");

    console.log(`📩 Entered email: ${emailInput.value}`);
    console.log(`🔒 Entered password: ${passwordInput.value}`);

    // ❌ Check if email is blank
    if (Email.value == "") {
        console.error("Email Cannot be left empty");
        Email.focus();
        Email.style.borderColor = "red";
    }
    
    // ❌ Check if password is blank
    if (Password.value == "") {
        console.error("Password cannot be left empty");
        Password.focus();
        Password.style.borderColor = "red";
    }

    if (Email.value == DBEmail && Password.value == DBPassword) {
    }
}

// ⚠️ Login modal error section
document.addEventListener("DOMContentLoaded", function () {
    // 🔍 Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('error');

    if (errorMessage) {
        // 🚨 Show error message inside login modal
        const errorBox = document.getElementById("LoginErrorMessage");
        errorBox.textContent = decodeURIComponent(errorMessage);
        errorBox.classList.remove("d-none"); // Make visible

        // ✅ Open Bootstrap login modal
        let loginModal = new bootstrap.Modal(document.getElementById("LoginModal"));
        loginModal.show();

        // 🧹 Remove error from URL after displaying
        window.history.replaceState(null, "", window.location.pathname);
    }
});