// 👤 Account icon click
document.addEventListener("DOMContentLoaded", function () {
    const accountButton = document.getElementById("accountButton");

    accountButton.addEventListener("click", function () {
        window.location.href = "/Group_Project/GroupProject_Group12/pages/account.php";
    });
});

// ✅ Limited animations checkbox status
document.addEventListener("DOMContentLoaded", () => {
    let limitAnimationsEnabled = localStorage.getItem("limitAnimations") === "true";

    const checkbox = document.getElementById("limitAnimations");

    if (checkbox) {
        // 🔄 Load stored preference
        checkbox.checked = limitAnimationsEnabled;

        // 🔽 Update localStorage and global variable when toggled
        checkbox.addEventListener("change", () => {
            limitAnimationsEnabled = checkbox.checked;
            localStorage.setItem("limitAnimations", checkbox.checked);
            window.limitAnimationsEnabled = limitAnimationsEnabled;
            
            // 🛑 Stop Matrix effect if limited animations is enabled
            if (limitAnimationsEnabled) {
                stopMatrix();
            } else if (document.body.classList.contains("matrix-theme")) {
                startMatrix();
            }
            // 🛑 Stop tumbleweeds if limited animations is enabled
            if (limitAnimationsEnabled) {
                stopTumbleweeds();
            } else if (document.body.classList.contains("desert-theme")) {
                startTumbleweeds();
            }
        });
    }

    // 🌍 Make accessible globally so other scripts can use it
    window.limitAnimationsEnabled = limitAnimationsEnabled;
});

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