document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('registrationForm');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('eyeIcon');

    // 1. Toggle Password Visibility
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            togglePassword.textContent = isPassword ? '🙈' : '👁';
        });
    }

    // 2. Handle Sign Up Submission
    if (signupForm) {
        signupForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(signupForm);
            const fullName = formData.get('fullName') || 'New User';
            const email = formData.get('email') || 'user@example.com';
            const phone = formData.get('phone') || '+63 912 345 6789';
            const redirectTarget = window.location.pathname.endsWith('.php') ? 'index.php' : 'index.html';

            try {
                const response = await fetch('Backend/signup.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.status === 'success') {
                        localStorage.setItem('crave_user', JSON.stringify({
                            name: fullName,
                            email: email,
                            phone: phone
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
            localStorage.setItem('crave_user', JSON.stringify({
                name: fullName,
                email: email,
                phone: phone
            }));
            alert('Account created successfully! Welcome to CraveExpress.');
            window.location.href = redirectTarget;
        });
    }
});