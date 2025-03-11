function toggledarklight() {
    document.body.classList.toggle("dark-mode");
    isDarkMode = document.body.classList.contains("dark-mode");
    setTimeout(() => {
        drawChart(); // 🔄 Ensure chart updates AFTER state change
    }, 10);
}