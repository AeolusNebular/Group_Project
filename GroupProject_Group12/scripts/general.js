// 🔊 Play sound
function playSound(url) {
    const audio = new Audio(url);
    audio.volume = 0.7;
    audio.play().catch(err => console.warn("Sound error:", err));
}

// 🔄 Loading screen
window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => preloader.remove(), 500); // ⏱️ Clean up after fade
    }
});

// 👤 Account icon click
document.addEventListener("DOMContentLoaded", function () {
    const accountButton = document.getElementById("accountButton");
    
    accountButton.addEventListener("click", function () {
        window.location.href = "/Group_Project/GroupProject_Group12/pages/account.php";
    });
});

// 🎞️ Limited animations checkbox
document.addEventListener("DOMContentLoaded", () => {
    let limitAnimationsEnabled = localStorage.getItem("limitAnimations") === "true";
    const checkbox = document.getElementById("limitAnimations");
    
    if (checkbox) {
        // 🔄 Load stored preference
        checkbox.checked = limitAnimationsEnabled;
        
        // 🎯 Apply class on load
        if (limitAnimationsEnabled) {
            document.body.classList.add("limitAnimations");
        }
        
        // 🔽 Update localStorage, global variable, and body when toggled
        checkbox.addEventListener("change", () => {
            limitAnimationsEnabled = checkbox.checked;
            localStorage.setItem("limitAnimations", checkbox.checked);
            window.limitAnimationsEnabled = limitAnimationsEnabled;
            
            // 🔁 Toggle the class so styles apply
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
    
    // 🔽 Ensure dropdown reflects stored value
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

// 🔠 Function to apply selected font size
function applyFontSize(size) {
    console.log(`🔠 Applying font size: ${size}`);
    
    // 📜 Remove previous font size classes
    document.documentElement.classList.remove("font-large", "font-extra-large");
    
    // 🔠 Apply new font size class if not default
    if (size === "large") {
        document.documentElement.classList.add("font-large");
    } else if (size === "extra-large") {
        document.documentElement.classList.add("font-extra-large");
    }
    
    // 💾 Store the selected font size in sessionStorage
    sessionStorage.setItem("fontSize", size);
}

document.addEventListener("DOMContentLoaded", function () {
    const highContrastCheckbox = document.getElementById("highContrast");
    const body = document.body; // 🎯 Apply the filter to the entire body

    // 🧩 Load stored high contrast preference from sessionStorage
    const highContrastEnabled = sessionStorage.getItem("highContrast") === "true";

    // 🎯 Apply high contrast filter based on the stored preference
    if (highContrastEnabled) {
        body.style.filter = "contrast(160%)"; // 🎯 Apply 160% contrast filter
        highContrastCheckbox.checked = true;
    } else {
        body.style.filter = ""; // 🧹 Clear filter
        highContrastCheckbox.checked = false;
    }

    // 🎧 Listen for changes to the High Contrast checkbox
    highContrastCheckbox.addEventListener("change", function () {
        const isChecked = highContrastCheckbox.checked;

        // 🔁 Toggle high contrast filter on body
        if (isChecked) {
            body.style.filter = "contrast(160%)"; // 🎯 Apply 160% contrast filter
        } else {
            body.style.filter = ""; // 🧹 Clear filter
        }

        // 💾 Save the preference to sessionStorage
        sessionStorage.setItem("highContrast", isChecked.toString());
    });
});

// 🎨 Function to apply selected colourblind filter size
window.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.getElementById("colourblind");
    const target = document.documentElement;
    
    // 💾 Get saved filter from localStorage or use default
    const saved = localStorage.getItem("cb-filter") || "default";
    dropdown.value = saved;
    
    // 🧩 Apply saved filter class
    if (saved !== "default") {
        target.classList.add("filter-" + saved);
    }
    
    // 🔄 Update filter on dropdown change
    dropdown.addEventListener("change", function () {
        localStorage.setItem("cb-filter", this.value);
        
        // 🧹 Remove existing filter
        target.classList.remove("filter-deuteranopia", "filter-tritanopia", "filter-achromatopsia");
        
        // 🎯 Apply new filter
        if (this.value !== "default") {
            target.classList.add("filter-" + this.value);
        }
    });
});

// 📖 Toggle notification navbar dropdown
function toggleNotifications() {
    const bell = document.querySelector('.bell-icon');
    
    // 🌀 Add the wiggle class
    bell.classList.add('wiggle');
    
    // 🧽 Remove it after the animation ends so it can be re-triggered
    bell.addEventListener('animationend', () => {
        bell.classList.remove('wiggle');
    }, { once: true });
    
    var notificationsDropdown = document.getElementById("notificationsDropdown");
    console.log("Toggling notifications dropdown...");
    if (notificationsDropdown.style.display === "none" || notificationsDropdown.style.display === "") {
        notificationsDropdown.style.display = "block";
    } else {
        notificationsDropdown.style.display = "none";
    }
}

// 📖 Toggle notification read status (dot ↔ circle)
function toggleReadStatus(notifId, element) {
    // 📖 Determine new read status
    let isRead = 0;
    
    // 🟣 Toggle classes on the clicked dot only
    if (element.classList.contains('unread-dot')) {
        element.classList.remove('unread-dot'); // 🟣 Mark as read
        element.classList.add('read-dot');
        isRead = 1;
    } else if (element.classList.contains('read-dot')) {
        element.classList.remove('read-dot');   // ⭕ Mark as unread
        element.classList.add('unread-dot');
        isRead = 0;
    }
    
    // 📡 Send AJAX request to update the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'notifications.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('✅ Notification read status updated for NotifID:', notifId);
        } else {
            console.warn('⚠️ Failed to update read status for NotifID:', notifId);
        }
    };
    xhr.send(
        'markAsRead=true' +
        '&NotifID=' + encodeURIComponent(notifId) +
        '&isRead=' + encodeURIComponent(isRead)
    );
}