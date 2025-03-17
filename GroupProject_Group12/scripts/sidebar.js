var isopen = false;

function toggleNav() {
    const sidebar = document.getElementById("mySidebar");
    const main = document.getElementById("main");
    const isOpen = sidebar.style.width === "250px";
    
    sidebar.style.width = isOpen ? "0" : "250px";
    main.style.marginLeft = isOpen ? "0" : "250px";
    
    // Icon transformation
    document.querySelector(".navbar-toggler").classList.toggle("active");
}