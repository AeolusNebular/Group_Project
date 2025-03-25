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
        });
    }

    // 🌍 Make accessible globally so other scripts can use it
    window.limitAnimationsEnabled = limitAnimationsEnabled;
});