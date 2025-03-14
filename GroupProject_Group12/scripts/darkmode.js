document.addEventListener("DOMContentLoaded", function () {
    const icon = document.getElementById("darkModeIcon");

    // 🎨 Check and apply theme on page load
    const theme = localStorage.getItem("theme") === "dark";
    
    // ⚙️ Apply relevant icon
    document.body.classList.toggle("light-mode", theme);
    icon.innerHTML = theme ? sunIcon() : moonIcon();
});

// 📊 Redrawn javascript charts to match toggled mode
function toggleDarkLight() {
    const body = document.body;
    const icon = document.getElementById("darkModeIcon");
    const theme = !body.classList.contains("light-mode");

    body.classList.toggle("light-mode", theme);

    // ⚙️ Store selected mode
    localStorage.setItem("theme", theme ? "dark" : "light");

    // ⚙️ Apply relevant icon
    icon.innerHTML = theme ? sunIcon() : moonIcon();

    // 📊 Redraw charts
    requestAnimationFrame(drawChart);
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