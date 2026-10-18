/**
 * CraveExpress - profile_settings.js
 * Handles sidebar tab switching, photo upload simulation, address management, and toast notifications.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar Tab Switching
    const sideItems = document.querySelectorAll('.side-item:not(.logout)');
    const panels = document.querySelectorAll('.settings-panel');

    function activateTab(tabName) {
        sideItems.forEach(item => {
            if (item.getAttribute('data-tab') === tabName) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        panels.forEach(panel => {
            if (panel.id === `panel-${tabName}`) {
                panel.style.display = 'block';
            } else {
                panel.style.display = 'none';
            }
        });
    }

    sideItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const tab = item.getAttribute('data-tab');
            if (tab) {
                activateTab(tab);
                window.history.replaceState(null, null, `?tab=${tab}`);
            }
        });
    });

    // Check URL param for active tab (?tab=security etc.)
    const urlParams = new URLSearchParams(window.location.search);
    const activeTabParam = urlParams.get('tab') || 'profile';
    activateTab(activeTabParam);

    // 2. Avatar Upload & Preview
    const uploadBtn = document.getElementById('btn-upload-photo');
    const photoFileInput = document.getElementById('photo-file-input');
    const removeBtn = document.getElementById('btn-remove-photo');
    const avatarImg = document.getElementById('user-avatar-img');

    if (uploadBtn && photoFileInput) {
        uploadBtn.addEventListener('click', () => {
            photoFileInput.click();
        });

        photoFileInput.addEventListener('change', () => {
            if (photoFileInput.files && photoFileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (avatarImg) avatarImg.src = e.target.result;
                    showToast('Profile photo updated! Click "Save Changes" to apply.');
                };
                reader.readAsDataURL(photoFileInput.files[0]);
            }
        });
    }

    if (removeBtn && avatarImg) {
        removeBtn.addEventListener('click', () => {
            avatarImg.src = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150';
            showToast('Photo reset to default');
        });
    }

    // 3. Status Notification Feedback (?status=success or ?status=error)
    if (urlParams.get('status') === 'success') {
        showToast('Changes saved successfully! ✓', 'success');
    } else if (urlParams.get('status') === 'error') {
        const msg = urlParams.get('msg') || 'Error updating settings. Please try again.';
        showToast(msg.replace(/\+/g, ' '), 'error');
    }
});

function showToast(message, type = 'info') {
    let toast = document.getElementById('crave-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'crave-toast';
        document.body.appendChild(toast);
    }
    toast.innerText = message;
    toast.className = 'crave-toast show';
    if (type === 'success') toast.style.background = '#27ae60';
    else if (type === 'error') toast.style.background = '#e74c3c';
    else toast.style.background = '#1e272e';

    setTimeout(() => {
        toast.className = 'crave-toast';
    }, 3500);
}