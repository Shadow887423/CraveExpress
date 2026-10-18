document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const passwordInput = document.getElementById('loginPassword');
    const togglePassword = document.getElementById('loginEyeIcon');

    // 1. Toggle Password Visibility
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            togglePassword.textContent = isPassword ? '🙈' : '👁';
        });
    }

    // 2. Handle Login Submission
    if (loginForm) {
        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(loginForm);
            const email = formData.get('email') || 'demo@craveexpress.com';
            const redirectTarget = window.location.pathname.endsWith('.php') ? 'index.php' : 'index.html';

            try {
                // Send data to the login process script
                const response = await fetch('Backend/login_process.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.status === 'success') {
                        localStorage.setItem('crave_user', JSON.stringify({
                            name: result.user || email.split('@')[0],
                            email: email,
                            phone: '+63 912 345 6789'
                        }));
                        alert('Success: ' + result.message);
                        window.location.href = redirectTarget;
                        return;
                    } else {
                        alert('Error: ' + result.message);
                        return;
                    }
                }
            } catch (error) {
                console.log('Backend not reachable (Static/GitHub Pages mode active):', error);
            }

            // Static / GitHub Pages fallback
            const userName = email.split('@')[0].replace(/[._]/g, ' ');
            const capitalizedName = userName.charAt(0).toUpperCase() + userName.slice(1);
            localStorage.setItem('crave_user', JSON.stringify({
                name: capitalizedName || 'Foodie Explorer',
                email: email,
                phone: '+63 912 345 6789'
            }));
            alert('Logged in successfully! Welcome to CraveExpress.');
            window.location.href = redirectTarget;
        });
    }
});