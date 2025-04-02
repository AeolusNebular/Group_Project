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
        
        // ✅ Apply class on load
        if (limitAnimationsEnabled) {
            document.body.classList.add("limitAnimations");
        }
        
        // 🔽 Update localStorage, global variable, and body when toggled
        checkbox.addEventListener("change", () => {
            limitAnimationsEnabled = checkbox.checked;
            localStorage.setItem("limitAnimations", checkbox.checked);
            window.limitAnimationsEnabled = limitAnimationsEnabled;
            
            // ✅ Toggle the class so styles apply
            if (limitAnimationsEnabled) {
                document.body.classList.add("limitAnimations");
            } else {
                document.body.classList.remove("limitAnimations");
            }
            
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