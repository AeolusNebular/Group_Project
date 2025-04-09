function createNotificationPopup(title, body, position = { top: '80px', right: '16px' }) {
    // 🏗️ Create popup container
    const popup = document.createElement('div');
    popup.className = 'card shadow-sm slide-in';
    popup.style.position = 'fixed';
    popup.style.width = '300px';
    popup.style.zIndex = '1000';
    popup.style.transition = 'opacity 0.3s ease';
    popup.style.overflow = 'hidden';
    
    // ⬇️ Position
    Object.keys(position).forEach(key => {
        popup.style[key] = position[key];
    });
    
    // 📛 Header with title and ❌ close button
    const cardHeader = document.createElement('div');
    cardHeader.className = 'card-header';
    cardHeader.textContent = title;
    
    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'btn-close';
    closeBtn.setAttribute('aria-label', 'Close');
    closeBtn.style.position = 'absolute';
    closeBtn.style.right = '12px';
    closeBtn.onclick = () => popup.remove();
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
    progressBar.style.backgroundColor = '#0d6efd';
    progressBar.style.width = '100%';
    progressBar.style.transition = 'width 3s linear';
    popup.appendChild(progressBar);
    
    // 🌍 Add to DOM
    document.body.appendChild(popup);
    
    // 🕒 Animate bar
    setTimeout(() => {
        progressBar.style.width = '0%';
    }, 10);
    
    // ⏳ Fade and remove after 3s
    setTimeout(() => {
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 300);
    }, 3000);
}