let holdTimer;
let heldLongEnough = false;

// ✅ Only allow sparks if animations are NOT limited
document.addEventListener("mousedown", (e) => {
    if (!window.limitAnimationsEnabled && isInteractive(e.target)) {
        createSparks(e.clientX, e.clientY); // 1️⃣ Normal click = sparks
    }

    // ⌛ Start hold timer
    holdTimer = setTimeout(() => {
        heldLongEnough = true;
    }, 500); // ⌛ 0.5 second hold time
});

document.addEventListener("mouseup", (e) => {
    clearTimeout(holdTimer); // 🛑 Stop countdown if released early

    if (!window.limitAnimationsEnabled && heldLongEnough && isInteractive(e.target)) {
        createSparks(e.clientX, e.clientY); // 2️⃣ Long press = another spark
    }

    heldLongEnough = false; // Reset flag
});

function isInteractive(element) {
    return (
        ["BUTTON", "A", "SELECT", "LABEL", "SVG"].includes(element.tagName) || 
        element.closest("svg") || // Check if inside an SVG
        element.hasAttribute("data-interactive") ||
        (element.tagName === "INPUT" && element.type === "checkbox") // ✅ Allow checkboxes
    );
}

function createSparks(x, y) {
    for (let i = 0; i < 8; i++) { // ✨ More sparks per click
        const spark = document.createElement("div");
        spark.classList.add("spark");

        // 💨 Random direction and speed
        const angle = Math.random() * Math.PI * 2; // 🧭 Random direction
        const speed = Math.random() * 5 + 2; // Speed range (2 to 7)
        const velocityX = Math.cos(angle) * speed;
        let velocityY = Math.sin(angle) * speed;
        let gravity = 0.2;

        // 📍 Set initial position
        spark.style.left = `${x}px`;
        spark.style.top = `${y}px`;
        spark.style.transform = `rotate(${Math.random() * 360}deg)`;

        document.body.appendChild(spark);

        let time = 0;
        const move = setInterval(() => {
            time += 1;
            velocityY += gravity; // 🧲 Gravity pulls it down

            spark.style.left = `${x + velocityX * time}px`;
            spark.style.top = `${y + velocityY * time}px`;
        }, 16);

        // ✅ Auto-delete after 1 second
        setTimeout(() => {
            clearInterval(move);
            spark.remove();
        }, 1000);
    }
}