
const notifications = [
    { message: "Notifications.", isRead: false },
];

// toggle notifications dropdown
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
}

// load into dropdown
function loadNotifications(startIndex = 0, count = 4) {
    const notificationList = document.getElementById('notificationList');
    notificationList.innerHTML = ''; // Clear existing notifications
    const endIndex = Math.min(startIndex + count, notifications.length);
    
    for (let i = startIndex; i < endIndex; i++) {
        const notification = notifications[i];
        const notificationDiv = document.createElement('div');
        notificationDiv.classList.add('notification');
        if (!notification.isRead) {
            notificationDiv.classList.add('unread');
        }
        notificationDiv.textContent = notification.message;
        notificationList.appendChild(notificationDiv);
    }
}

// load more notifs on clock
function loadMoreNotifications() {
    const currentNotifications = document.getElementsByClassName('notification').length;
    loadNotifications(currentNotifications, 4);
}

// load on page load
window.onload = function() {
    loadNotifications();
};
