// Function to ensure the container exists
function ensurePopupContainer() {
    let container = document.getElementById('notification-popup-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-popup-container';
        container.style.position = 'fixed';
        container.style.top = '80px';
        container.style.right = '16px';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.gap = '16px';
        container.style.zIndex = '10';
        document.body.appendChild(container);
    }
    return container;
}

// Function to create the notification popup
function createNotificationPopup(notifID, header, body) {
    const container = ensurePopupContainer();
    
    // 🏗️ Create popup container
    const popup = document.createElement('div');
    popup.className = 'card slide-in';
    popup.style.width = '400px';
    popup.style.transition = 'opacity 0.3s ease';
    popup.style.overflow = 'hidden';
    
    // 📛 Header
    const cardHeader = document.createElement('div');
    cardHeader.className = 'card-header';
    cardHeader.textContent = header;

    // ❌ Close button
    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'btn-close';
    closeBtn.setAttribute('aria-label', 'Close');
    closeBtn.style.position = 'absolute';
    closeBtn.style.right = '12px';
    closeBtn.onclick = () => {
        markNotificationAsRead(notifID);
        popup.remove();
    };
    cardHeader.appendChild(closeBtn);
    
    popup.appendChild(cardHeader);
    
    // 💬 Body message
    const cardBody = document.createElement('div');
    cardBody.className = 'card-body p-3';
    cardBody.textContent = body;
    popup.appendChild(cardBody);
    
    // 📉 Progress bar
    const progressBar = document.createElement('div');
    progressBar.style.height = '4px';
    progressBar.style.backgroundColor = 'var(--text-shadow)';
    progressBar.style.width = '100%';
    progressBar.style.transition = 'none'; // Animated manually below
    popup.appendChild(progressBar);
    
    // 🔼 Add to container (top-first)
    container.prepend(popup);
    
    // 🔊 Play sound on popup popup
    playSound('https://notificationsounds.com/storage/sounds/file-4f_here-I-am.ogg');
    
    // ⏳ Timer Logic
    const totalDuration = 10000; // 10 seconds
    let startTime = Date.now();
    let elapsed = 0;
    let animationFrame;
    let timeoutHandle;
    
    function updateProgress() {
        elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / totalDuration, 1);
        progressBar.style.width = `${100 - progress * 100}%`;
        
        if (progress < 1) {
            animationFrame = requestAnimationFrame(updateProgress);
        } else {
            // ⏱️ Fade and remove
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 300);
        }
    }
    
    // ⏱️ Pause timer on hover
    function pauseProgress() {
        cancelAnimationFrame(animationFrame);
        clearTimeout(timeoutHandle);
        elapsed = Date.now() - startTime;
    }
    
    // ⏱️ Resume timer on mouse off
    function resumeProgress() {
        startTime = Date.now() - elapsed;
        updateProgress();
    }
    
    popup.addEventListener('mouseenter', pauseProgress);
    popup.addEventListener('mouseleave', resumeProgress);
    
    // Start everything
    updateProgress();
}