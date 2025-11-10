document.addEventListener('DOMContentLoaded', () => {
    // --- Element Selections ---
    const authModal = document.getElementById('auth-modal');
    const closeModalBtn = document.getElementById('close-auth-modal');

    // Buttons in the header to open the modal
    const loginNavBtn = document.getElementById('login-btn');
    const signupNavBtn = document.getElementById('signup-btn');
    const joinCommunityBtn = document.getElementById('joinCommunityBtn'); // From Home.php

    // Forms and form toggles inside the modal
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const showLoginFormBtn = document.getElementById('show-login-form');
    const showSignupFormBtn = document.getElementById('show-signup-form');

    // Links to switch between forms
    const switchToSignupLink = document.getElementById('switch-to-signup');
    const switchToLoginLink = document.getElementById('switch-to-login');

    // Password visibility toggles
    const passwordToggles = document.querySelectorAll('.toggle-password');

    // --- Validation and Form Submission ---
    const signupUsername = document.getElementById('signup-username');
    const signupEmail = document.getElementById('signup-email');
    const signupPassword = document.getElementById('signup-password');
    const signupConfirmPassword = document.getElementById('signup-confirm-password');

    const loginEmail = document.getElementById('login-email');
    const loginPassword = document.getElementById('login-password');

    // User Dropdown
    const userDropdown = document.querySelector('.user-dropdown');


    // --- Functions ---

    /**
     * Displays the authentication modal.
     * @param {string} view - 'login' or 'signup' to show the respective form.
     */
    const openModal = (view = 'login') => {
        if (authModal) {
            authModal.style.display = 'flex';
            if (view === 'signup') {
                showForm(signupForm, showSignupFormBtn);
            } else {
                showForm(loginForm, showLoginFormBtn);
            }
        }
    };

    /**
     * Hides the authentication modal.
     */
    const closeModal = () => {
        if (authModal) {
            authModal.style.display = 'none';
        }
    };

    /**
     * Switches the visible form in the modal.
     * @param {HTMLElement} formToShow - The form element to display.
     * @param {HTMLElement} activeBtn - The toggle button to mark as active.
     */
    const showForm = (formToShow, activeBtn) => {
        // Hide both forms first
        loginForm.classList.remove('active');
        signupForm.classList.remove('active');

        // Deactivate both toggle buttons
        showLoginFormBtn.classList.remove('active');
        showSignupFormBtn.classList.remove('active');

        // Show the correct form and activate its button
        formToShow.classList.add('active');
        activeBtn.classList.add('active');
    };

    /**
     * Displays an error message for a form field.
     * @param {HTMLElement} input - The input element with an error.
     * @param {string} message - The error message to display.
     */
    const showError = (input, message) => {
        const formGroup = input.parentElement.closest('.form-group');
        formGroup.classList.add('error');
        formGroup.classList.remove('success');
        const errorDiv = formGroup.querySelector('.error-message');
        errorDiv.textContent = message;
    };

    /**
     * Marks a form field as valid.
     * @param {HTMLElement} input - The input element to mark as successful.
     */
    const showSuccess = (input) => {
        const formGroup = input.parentElement.closest('.form-group');
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
        const errorDiv = formGroup.querySelector('.error-message');
        errorDiv.textContent = '';
    };

    /**
     * Validates an email address format.
     * @param {string} email - The email string to validate.
     * @returns {boolean} - True if the email is valid, false otherwise.
     */
    const isValidEmail = (email) => {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    };

    /**
     * Validates the entire signup form.
     * @returns {boolean} - True if all fields are valid, false otherwise.
     */
    const validateSignupForm = () => {
        let isValid = true;
        const usernameValue = signupUsername.value.trim();
        const emailValue = signupEmail.value.trim();
        const passwordValue = signupPassword.value.trim();
        const confirmPasswordValue = signupConfirmPassword.value.trim();

        if (usernameValue === '') {
            showError(signupUsername, 'Username is required');
            isValid = false;
        } else {
            showSuccess(signupUsername);
        }

        if (emailValue === '') {
            showError(signupEmail, 'Email is required');
            isValid = false;
        } else if (!isValidEmail(emailValue)) {
            showError(signupEmail, 'Email is not valid');
            isValid = false;
        } else {
            showSuccess(signupEmail);
        }

        if (passwordValue === '') {
            showError(signupPassword, 'Password is required');
            isValid = false;
        } else if (passwordValue.length < 6) {
            showError(signupPassword, 'Password must be at least 6 characters');
            isValid = false;
        } else {
            showSuccess(signupPassword);
        }

        if (confirmPasswordValue === '') {
            showError(signupConfirmPassword, 'Please confirm your password');
            isValid = false;
        } else if (passwordValue !== confirmPasswordValue) {
            showError(signupConfirmPassword, 'Passwords do not match');
            isValid = false;
        } else {
            showSuccess(signupConfirmPassword);
        }

        return isValid;
    };

    /**
     * Validates the entire login form.
     * @returns {boolean} - True if all fields are valid, false otherwise.
     */
    const validateLoginForm = () => {
        let isValid = true;
        const emailValue = loginEmail.value.trim();
        const passwordValue = loginPassword.value.trim();

        if (emailValue === '') {
            showError(loginEmail, 'Email is required');
            isValid = false;
        } else if (!isValidEmail(emailValue)) {
            showError(loginEmail, 'Email is not valid');
            isValid = false;
        } else {
            showSuccess(loginEmail);
        }

        if (passwordValue === '') {
            showError(loginPassword, 'Password is required');
            isValid = false;
        } else {
            showSuccess(loginPassword);
        }

        return isValid;
    };

    /**
     * Resets all error/success states on a form.
     * @param {HTMLElement} form - The form element to reset.
     */
    const resetFormState = (form) => {
        form.querySelectorAll('.form-group').forEach(formGroup => {
            formGroup.classList.remove('error', 'success');
            formGroup.querySelector('.error-message').textContent = '';
        });
    };

    // --- Event Listeners ---

    // Open Modal
    loginNavBtn?.addEventListener('click', () => openModal('login'));
    signupNavBtn?.addEventListener('click', () => openModal('signup'));
    joinCommunityBtn?.addEventListener('click', () => openModal('signup'));

    // Close Modal
    closeModalBtn?.addEventListener('click', closeModal);
    authModal?.addEventListener('click', (e) => {
        // Reset form states when closing the modal
        resetFormState(loginForm);
        resetFormState(signupForm);
        if (e.target === authModal) { // Clicked on the background overlay
            closeModal();
        }
    });

    // Switch Forms
    showLoginFormBtn?.addEventListener('click', () => showForm(loginForm, showLoginFormBtn));
    showSignupFormBtn?.addEventListener('click', () => { resetFormState(loginForm); showForm(signupForm, showSignupFormBtn); });
    switchToSignupLink?.addEventListener('click', (e) => { e.preventDefault(); resetFormState(loginForm); showForm(signupForm, showSignupFormBtn); });
    switchToLoginLink?.addEventListener('click', (e) => { e.preventDefault(); resetFormState(signupForm); showForm(loginForm, showLoginFormBtn); });

    // Password Visibility
    passwordToggles.forEach(button => {
        button.addEventListener('click', () => {
            const passwordInput = button.previousElementSibling;
            const icon = button.querySelector('i');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        });
    });

    // Signup Form Submission
    signupForm?.addEventListener('submit', async (e) => {
        e.preventDefault(); // Prevent default page reload

        if (validateSignupForm()) {
            const submitButton = signupForm.querySelector('button[type="submit"]');
            submitButton.textContent = 'Creating Account...';
            submitButton.disabled = true;

            const formData = {
                username: signupUsername.value.trim(),
                email: signupEmail.value.trim(),
                password: signupPassword.value.trim(),
                confirm_password: signupConfirmPassword.value.trim()
            };

            try {
                const res = await fetch('signup.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData),
                    credentials: 'include' // Allow cookies to be sent and received
                });

                if (res.ok) { // Status 201 Created
                    // On successful signup, reload the page to reflect the new logged-in state.
                    window.location.reload();
                } else {
                    const data = await res.json();
                    alert(`Error: ${data.error}`); // Show server-side error
                }
            } catch (error) {
                alert('An error occurred. Please check your connection and try again.');
                console.error('Signup fetch error:', error);
            } finally {
                submitButton.textContent = 'Create Account';
                submitButton.disabled = false;
            }
        }
    });

    // Login Form Submission
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (validateLoginForm()) {
            const submitButton = loginForm.querySelector('button[type="submit"]');
            submitButton.textContent = 'Logging In...';
            submitButton.disabled = true;

            const formData = {
                email: loginEmail.value.trim(),
                password: loginPassword.value.trim()
            };

            try {
                const res = await fetch('login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData),
                    credentials: 'include' // <-- This is the crucial change
                });

                if (res.ok) { // Status 200 OK
                    // On successful login, reload the page to update the header and session state
                    window.location.reload();
                } else {
                    const data = await res.json();
                    alert(`Login Failed: ${data.error}`); // Show server-side error
                }
            } catch (error) {
                alert('An error occurred. Please check your connection and try again.');
                console.error('Login fetch error:', error);
            } finally {
                submitButton.textContent = 'Login';
                submitButton.disabled = false;
            }
        }
    });

    // User Dropdown Toggle
    userDropdown?.addEventListener('click', (e) => {
        // This prevents the modal from opening if a logged-in user clicks their name
        e.stopPropagation(); 
        userDropdown.classList.toggle('active');
    });

    // Close dropdown if clicking outside
    document.addEventListener('click', (e) => {
        if (userDropdown && !userDropdown.contains(e.target)) {
            userDropdown.classList.remove('active');
        }
    });

});