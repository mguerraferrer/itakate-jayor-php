document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault(); // Prevent page reload

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const alertMessage = document.getElementById('alert-message');
    const loginBtn = document.getElementById('login-btn');

    // Disable button while processing
    loginBtn.disabled = true;
    loginBtn.innerHTML = 'Cargando... <i class="fal fa-spinner fa-spin"></i>';

    try {
        // Send POST request with Axios
        const response = await axios.post('../../app/ajax/admin/auth.php', {
            email: email,
            password: password
        });

        alertMessage.classList.remove('alert-success', 'alert-danger');
        alertMessage.classList.add('d-none');

        // Redirect if login is successful
        if (response.data.success) {
            window.location.href = response.data.redirect;
        }
    } catch (error) {        
        // Extract error message from response
        const message = error.response?.data?.message || 'Error en el servidor. Inténtalo de nuevo.';
        alertMessage.classList.remove('d-none', 'alert-success');
        alertMessage.classList.add('alert-danger');
        alertMessage.textContent = message;
    } finally {
        // Re-enable button
        loginBtn.disabled = false;
        loginBtn.innerHTML = 'Iniciar sesión <i class="fal fa-long-arrow-right"></i>';
    }
});