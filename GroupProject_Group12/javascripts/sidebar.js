let isopen = false;

function toggleNav() {
    if (isopen) {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        document.getElementById("testing").style.marginLeft = "48px";
    } else {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        document.getElementById("testing").style.marginLeft = "300px";
    }
    isopen = !isopen; // Toggle state
}