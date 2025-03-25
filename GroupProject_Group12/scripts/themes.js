function CheckTheme(custtheme) {
    // Remove existing theme classes
    document.body.classList.remove("purple-theme", "green-theme", "blue-theme");

    // Apply the selected theme
    switch (custtheme) {
        case "purple":
            document.body.classList.add("purple-theme");
            break;
        case "green":
            document.body.classList.add("green-theme");
            break;
        case "blue":
            document.body.classList.add("blue-theme");
            break;
    }

    // Store the selected theme in local storage
    localStorage.setItem('selectedTheme', custtheme);
}

// Apply the stored theme on page load
document.addEventListener("DOMContentLoaded", function () {
    const storedTheme = localStorage.getItem('selectedTheme');
    if (storedTheme) {
        CheckTheme(storedTheme);
        document.getElementById('theme').value = storedTheme;
    }
});

function switchdark() {

    var element = document.body;
    element.classList.toggle("dark-mode");
    
}