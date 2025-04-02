let holdTimer;
let heldLongEnough = false;

// ✅ Only allow sparks if animations are NOT limited
document.addEventListener("mousedown", (e) => {
    if (!window.limitAnimationsEnabled && isInteractive(e.target)) {
        createSparks(e.clientX, e.clientY); // 1️⃣ Normal click = sparks
    }
    
    // ⌛ Start hold timer (prevents instant clicks from triggering double spark)
    holdTimer = setTimeout(() => {
        heldLongEnough = true; // ✅ Eligible for second spark on release
    }, 400); // ⌛ 0.4 second hold time
});

document.addEventListener("mouseup", (e) => {
    clearTimeout(holdTimer); // 🛑 Stop countdown if released early

    if (!window.limitAnimationsEnabled && heldLongEnough && isInteractive(e.target)) {
        createSparks(e.clientX, e.clientY); // 2️⃣ Long press = another spark
    }

    heldLongEnough = false; // ⏱️ Reset flag
});

// 🎯 Define interactive elements
function isInteractive(element) {
    return element.closest("[data-interactive], button, a, select, label, svg, input[type='checkbox']");
}

function createSparks(x, y) {
    for (let i = 0; i < 8; i++) { // ✨ Sparks per click
        const spark = document.createElement("div");
        spark.classList.add("spark");
        
        // ☄️ Spark moves in a random direction with physics-based movement:
        const angle = Math.random() * Math.PI * 2; // 🧭 Random trajectory (0° to 360°)
        const speed = Math.random() * 5 + 2; // 💨 Speed Random speed (between 2px and 7px per frame)
        
        const velocityX = Math.cos(angle) * speed; // ➡️ Horizontal movement
        let velocityY = Math.sin(angle) * speed; // ⬇️ Vertical movement
        
        let gravity = 0.2; // 🔻 Small downward pull to emulate gravity
        
        // 📍 Set initial position
        spark.style.left = `${x}px`;
        spark.style.top = `${y}px`;
        spark.style.transform = `rotate(${Math.random() * 360}deg)`;
        
        document.body.appendChild(spark);
        
        let time = 0;
        const move = setInterval(() => {
            time += 1;
            velocityY += gravity; // 🧲 Apply gravity
            
            let newX = x + velocityX * time;
            let newY = y + velocityY * time;
            
            // ✅ Check if spark is out of bounds
            if (newX < 4 || newX > window.innerWidth - 4 || newY < 4 || newY > window.innerHeight - 4) {
                clearInterval(move);
                spark.remove();
                return; // 🛑 Stop function early to prevent errors
            }
            
            spark.style.left = `${newX}px`;
            spark.style.top = `${newY}px`;
        }, 16);
        
        // 🗑️ Auto-delete after 1 second
        setTimeout(() => {
            clearInterval(move);
            spark.remove();
        }, 1000);
    }
}