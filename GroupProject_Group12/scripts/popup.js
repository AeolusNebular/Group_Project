function createNotificationPopup(message, position = { top: '70px', right: '32px' }) {
    // Create the popup container
    const popup = document.createElement('div');
    popup.textContent = message;
    popup.style.position = 'fixed';
    popup.style.backgroundColor = '#333';
    popup.style.color = '#fff';
    popup.style.padding = '10px 20px';
    popup.style.borderRadius = '5px';
    popup.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
    popup.style.zIndex = '1000';
    

    // Set the position
    Object.keys(position).forEach(key => {
        popup.style[key] = position[key];
    });

    // Append to the body
    document.body.appendChild(popup);

    // Automatically remove the popup after 3 seconds
    setTimeout(() => {
        popup.style.opacity = '0';
        setTimeout(() => {
            popup.remove();
        }, 300);
    }, 3000);
}