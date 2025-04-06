var isopen = false;

function toggleNav() {
    const sidebar = document.getElementById("mySidebar");
    const main = document.getElementById("main");

    // 🔍 Check if sidebar is currently open
    const isOpen = sidebar.style.width === "250px";
    
    // 📏 Toggle sidebar width
    sidebar.style.width = isOpen ? "0" : "250px";
    
    // 🔄 Animate menu icon (hamburger to cross and back)
    document.querySelector(".navbar-toggler").classList.toggle("active");
}