// Toggle notifications dropdown
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
}

// Fetch notifications from backend and load them into the dropdown
function loadNotifications() {
    const notificationList = document.getElementById('notificationList');
    notificationList.innerHTML = ''; // Clear existing notifications

    fetch('path/to/your/notifications-fetch-script.php') // URL to your backend script that returns notifications
        .then(response => response.json()) // Assuming the response is in JSON format
        .then(notifications => {
            // Show the 5 most recent notifications
            const recentNotifications = notifications.slice(0, 5);

            recentNotifications.forEach(notification => {
                const notificationDiv = document.createElement('div');
                notificationDiv.classList.add('notification');

                // Mark unread notifications with a special class
                if (!notification.isRead) {
                    notificationDiv.classList.add('unread');
                }

                notificationDiv.textContent = notification.message;
                notificationList.appendChild(notificationDiv);
            });

            // Update the 'Load Notifications' link to direct to the notifications page
            const loadNotificationsLink = document.getElementById('loadNotificationsLink');
            loadNotificationsLink.href = '/Group_Project/GroupProject_Group12/pages/notifications.php';
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
}

// Load initial notifications when the page loads
window.onload = function() {
    loadNotifications();
};
