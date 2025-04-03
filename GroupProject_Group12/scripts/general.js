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

document.addEventListener("DOMContentLoaded", function () {
    const fontSizeSelect = document.getElementById("fontSize");
    const defaultFontSize = "default"; // 🔤 Default font size
    
    // 📦 Retrieve stored font size
    const storedFontSize = sessionStorage.getItem("fontSize") || defaultFontSize;
    applyFontSize(storedFontSize);
    
    // 🎛️ Ensure dropdown reflects the stored value
    if (fontSizeSelect) {
        fontSizeSelect.value = storedFontSize;
        
        // 🎧 Listen for font size selection changes
        fontSizeSelect.addEventListener("change", function (event) {
            applyFontSize(event.target.value);
        });
    } else {
        console.error("⚠️ Element with ID 'fontSize' not found.");
    }
});

// 🎨 Function to apply the selected font size
function applyFontSize(size) {
    console.log(`🔠 Applying font size: ${size}`);
    
    // 📜 Remove previous font size classes
    document.documentElement.classList.remove("font-large", "font-extra-large");
    
    // 🔠 Apply new font size class if not "default"
    if (size === "large") {
        document.documentElement.classList.add("font-large");
    } else if (size === "extra-large") {
        document.documentElement.classList.add("font-extra-large");
    }
    
    // 💾 Store the selected font size in sessionStorage
    sessionStorage.setItem("fontSize", size);
}