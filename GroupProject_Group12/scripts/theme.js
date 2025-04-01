document.addEventListener("DOMContentLoaded", function () {
    const icon = document.getElementById("darkModeIcon");
    const defaultThemeMode = "purple-dark"; // 🟣 Default to purple-dark
    
    // 📨 Retrieve stored themeMode from sessionStorage, or apply default
    const storedThemeMode = sessionStorage.getItem("themeMode") || defaultThemeMode;
    const [storedTheme, storedMode] = storedThemeMode.split("-");
    const isLightMode = storedMode === "light";
    
    // 🧹 Check if logout occurred and reset theme
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("logout")) {

        // 🔄 Reset theme, preserve mode
        sessionStorage.setItem("themeMode", `purple-${storedMode}`);
        document.body.classList.forEach(cls => {
            if (cls.endsWith("-theme")) document.body.classList.remove(cls);
        });
        document.body.classList.add(`purple-theme`); // 🟣 Ensure purple is applied without flash
        urlParams.delete("logout");
        window.history.replaceState({}, document.title, window.location.pathname + "?" + urlParams.toString());
        location.reload();
        return; // 👋 Exit to prevent further execution
    }
    
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
    
    // 🛑 Stop theme-specific effects before applying new theme
    stopMatrix();
    stopTumbleweeds();
    
    // 🧹 Clear previous theme
    document.body.classList.forEach(cls => {
        if (cls.endsWith("-theme")) document.body.classList.remove(cls);
    });
    document.body.classList.add(`${newTheme}-theme`);
    
    // 💾 Store theme and mode in sessionStorage
    const currentMode = document.body.classList.contains("light-mode") ? "light" : "dark";
    sessionStorage.setItem("themeMode", `${newTheme}-${currentMode}`);
    
    // ✅ Start theme-specific effects
    if (newTheme === "matrix") {
        startMatrix();
    }
    if (newTheme === "desert") {
        startTumbleweeds();
    }
}

// 🌙 Toggle dark/light mode
function toggleDarkLight() {
    const body = document.body;
    const icon = document.getElementById("darkModeIcon");
    const isDarkMode = !body.classList.contains("light-mode");
    
    // 🌙 Toggle mode
    body.classList.toggle("light-mode", isDarkMode);
    
    // 💾 Update mode in sessionStorage using the existing theme
    const currentTheme = document.body.classList.value.match(/\b(\w+)-theme\b/)?.[1] || "purple";
    const newMode = isDarkMode ? "light" : "dark";
    sessionStorage.setItem("themeMode", `${currentTheme}-${newMode}`);
    
    // ⚙️ Update icon
    icon.innerHTML = isDarkMode ? sunIcon() : moonIcon();
    
    // 📊 Redraw charts
    requestAnimationFrame(drawChart);
}

// ☀️ Sun Icon SVG
function sunIcon() {
    return `
    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" class="sun-icon">
        <!-- ☀️ Sun Core -->
        <circle cx="8" cy="8" r="3"/>
        <!-- 🌞 Sun Rays -->
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

let matrixInterval = null;

// 🧑‍💻 Function to start Matrix Effect
function startMatrix() {
    // ✅ Prevent starting matrix effect if already running
    if (matrixInterval) return;
    
    // 🎨 Create container
    const matrixContainer = document.createElement('div');
    matrixContainer.classList.add('matrix-container');
    document.body.appendChild(matrixContainer);
    
    // 🎥 Create canvas
    const canvas = document.createElement('canvas');
    canvas.classList.add('matrix-canvas');
    matrixContainer.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // 🔡 Characters used for the falling matrix effect
    const characters = "AÁBCÇDEÉFGHIÍJKLMNÑOÓPQRSTUÚÜVWXYZaábcçdeéfghiíjklmnñoópqrstuúüvwxyz1234567890¡!@#$%^&*()_+=-~[]{}|;:'\",./<>¿?あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほみむめもやゆよらりるれろわをん";
    
    // 🔢 Matrix settings
    const fontSize = 18;
    const columns = Math.floor(canvas.width / fontSize);
    const drops = Array(columns).fill(1);

    // 🖼️ Function to draw matrix effect
    function drawMatrix() {
        ctx.fillStyle = "rgba(0, 0, 0, 0.1)";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = "#00ff00";
        ctx.font = fontSize + "px 'Courier New'";
        
        // 🔄 Loop through each column to draw the falling characters
        for (let i = 0; i < drops.length; i++) {
            const text = characters.charAt(Math.floor(Math.random() * characters.length));
            ctx.fillText(text, i * fontSize, drops[i] * fontSize);
            
            if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                drops[i] = 0;
            }
            drops[i]++;
        }
    }

    // 💾 Store interval globally so it can be cleared (50ms)
    matrixInterval = setInterval(drawMatrix, 50);

    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });

    // 🛑 Stop if limitAnimations is enabled
    if (window.limitAnimationsEnabled) {
        stopMatrix();
    }
}

// 🛑 Function to stop Matrix effect
function stopMatrix() {
    console.log("🛑 Stopping Matrix effect...");
    if (matrixInterval) {
        clearInterval(matrixInterval);
        matrixInterval = null;
    }
    document.querySelectorAll(".matrix-container").forEach((el) => el.remove());
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

// 🍂 Tumbleweed for desert theme
let tumbleweedInterval = null;

function createTumbleweed() {
    
    const tumbleweed = document.createElement('div');
    tumbleweed.classList.add('tumbleweed');
    
    // 🎲 Random position and size
    const size = Math.random() * 80 + 40; // Between 40px and 120px
    tumbleweed.style.width = `${size}px`;
    tumbleweed.style.height = `${size}px`;
    tumbleweed.style.bottom = `${Math.random() * 90 + 5}vh`; // Between 5vh and 95vh
    
    // Append to body
    document.body.appendChild(tumbleweed);

    // ⏳ Remove after 12 seconds to prevent buildup
    setTimeout(() => {
        if (document.body.contains(tumbleweed)) {
            tumbleweed.remove();
        }
    }, 12000);
}

// 🎲 Random spawning pattern
function startTumbleweeds() {
    if (tumbleweedInterval) return; // Prevent duplicate intervals
    
    tumbleweedInterval = setInterval(() => {
        if (!window.limitAnimationsEnabled && Math.random() < 0.6) { // 60% chance to spawn
            createTumbleweed();
        }
    }, 300); // Every 0.3 seconds
}

function stopTumbleweeds() {
    console.log("🛑 Stopping tumbleweeds...");
    if (tumbleweedInterval) {
        clearInterval(tumbleweedInterval);
        tumbleweedInterval = null;
    }
    document.querySelectorAll(".tumbleweed").forEach(el => el.remove());
}