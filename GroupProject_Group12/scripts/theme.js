document.addEventListener("DOMContentLoaded", function () {
    const icon = document.getElementById("darkModeIcon");
    const defaultTheme = "purple-dark"; // 🟣 Default to purple-dark
    
    // 📨 Retrieve stored theme (session-based) and mode (local-based)
    const storedThemeMode = sessionStorage.getItem("themeMode") || defaultTheme;
    const [storedTheme, storedMode] = storedThemeMode.split("-");
    
    // 📨 Retrieve mode from localStorage (defaults to "dark")
    const savedMode = localStorage.getItem("mode") || "dark";
    const isLightMode = savedMode === "light";
    
    // 🎨 Apply stored theme
    applyTheme(storedTheme);
    
    // 🌙 Apply dark/light mode
    document.body.classList.toggle("light-mode", isLightMode);
    icon.innerHTML = isLightMode ? sunIcon() : moonIcon();
    
    // 🔽 Set dropdown correctly
    document.getElementById("theme").value = storedTheme;
    
    // 🎛️ Theme dropdown listener
    document.getElementById("theme").addEventListener("change", function (event) {
        applyTheme(event.target.value);
    });
});

// 🎨 Function to apply a selected theme
function applyTheme(newTheme) {
    console.log(`🔄 Switching theme to: ${newTheme}`);
    
    // 🧹 Clear previous theme
    document.body.classList.forEach(cls => {
        if (cls.endsWith("-theme")) document.body.classList.remove(cls);
    });
    document.body.classList.add(`${newTheme}-theme`);
    
    // 💾 Store theme in session storage
    const currentMode = document.body.classList.contains("light-mode") ? "light" : "dark";
    sessionStorage.setItem("themeMode", `${newTheme}-${currentMode}`);
}

// 🌙 Toggle dark/light mode
function toggleDarkLight() {
    const body = document.body;
    const icon = document.getElementById("darkModeIcon");
    const isCurrentlyDarkMode = !body.classList.contains("light-mode");
    
    // 🌙 Toggle mode
    body.classList.toggle("light-mode", isCurrentlyDarkMode);
    
    // 💾 Store mode in localStorage (persistent) and sessionStorage (temporary)
    const newMode = isCurrentlyDarkMode ? "light" : "dark";
    localStorage.setItem("mode", newMode);
    
    // 🔄 Update session storage to reflect the mode change
    const currentTheme = document.body.classList.value.match(/\b(\w+)-theme\b/)?.[1] || "purple";
    sessionStorage.setItem("themeMode", `${currentTheme}-${newMode}`);
    
    // ⚙️ Update icon
    icon.innerHTML = isCurrentlyDarkMode ? sunIcon() : moonIcon();
    
    // 📊 Redraw charts
    requestAnimationFrame(drawChart);
}

document.addEventListener("DOMContentLoaded", function () {
    // Check if we are coming from a logout
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("logout")) {
        resetThemeOnLogout(); // Reset the theme if logged out
    }
});

// 🧹 Clear theme when logging out
function resetThemeOnLogout() {
    const currentMode = localStorage.getItem("mode") || "dark"; // Keep stored mode
    sessionStorage.setItem("themeMode", `purple-${currentMode}`); // Reset theme to purple
    
    // Remove the 'logout' query parameter from the URL
    const url = new URL(window.location.href);
    url.searchParams.delete("logout");
    window.history.replaceState({}, document.title, url.toString()); // Update the URL without reloading
    
    // 🔄 Refresh to apply changes
    location.reload();
}

// ☀️ Sun Icon SVG
function sunIcon() {
    return `
    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" class="sun-icon">
        <!-- Sun Core -->
        <circle cx="8" cy="8" r="3"/>
        <!-- Sun Rays -->
        <line x1="8" y1="1" x2="8" y2="3" stroke="white" stroke-width="1" />
        <line x1="8" y1="13" x2="8" y2="15" stroke="white" stroke-width="1" />
        <line x1="1" y1="8" x2="3" y2="8" stroke="white" stroke-width="1" />
        <line x1="13" y1="8" x2="15" y2="8" stroke="white" stroke-width="1" />
        <line x1="2.5" y1="2.5" x2="4" y2="4" stroke="white" stroke-width="1" />
        <line x1="12" y1="12" x2="13.5" y2="13.5" stroke="white" stroke-width="1" />
        <line x1="2.5" y1="13.5" x2="4" y2="12" stroke="white" stroke-width="1" />
        <line x1="12" y1="4" x2="13.5" y2="2.5" stroke="white" stroke-width="1" />
    </svg>
    `;
}
// 🌙 Moon Icon SVG
function moonIcon() {
    return `
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="-4 -2 30 30" class="moon-icon">
            <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
        </svg>
    `;
}

// ⭐ Stars for cosmic theme
document.addEventListener("DOMContentLoaded", function () {
    const starContainer = document.createElement('div');
    starContainer.id = 'star-container';
    document.body.appendChild(starContainer);
    
    // ✨ Total number of stars on the screen
    const numberOfStars = 300;

    for (let i = 0; i < numberOfStars; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        const size = Math.random() * 3 + 1;
        star.style.width = `${size}px`;
        star.style.height = `${size}px`;
        star.style.left = `${Math.random() * 100}vw`;
        star.style.top = `${Math.random() * 100}vh`;
        star.style.animationDuration = `${Math.random() * 5 + 3}s`;
        star.style.animationDelay = `${Math.random() * 5}s`;
        starContainer.appendChild(star);
    }
});