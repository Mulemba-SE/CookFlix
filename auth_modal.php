<!-- Authentication Modal -->
<div id="auth-modal" class="modal">
    <div class="modal-content">
        <button class="close-modal" id="close-auth-modal">&times;</button>
        <div class="auth-container">
            <div class="auth-welcome">
                <h2>Welcome to CookFlix!</h2>
                <p>Join our community to discover, share, and save your favorite recipes.</p>
                <ul class="features-list">
                    <li><i class="fas fa-save"></i> Save your favorite recipes</li>
                    <li><i class="fas fa-users"></i> Join a vibrant cooking community</li>
                    <li><i class="fas fa-plus-circle"></i> Share your own creations</li>
                </ul>
            </div>
            <div class="auth-forms">
                <div class="form-container">
                    <div class="form-toggle">
                        <button id="show-login-form" class="active">Login</button>
                        <button id="show-signup-form">Sign Up</button>
                    </div>

                    <!-- Login Form -->
                    <form id="login-form" class="auth-form active" action="login.php" method="POST" novalidate>
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <div class="password-input">
                                <input type="password" id="login-password" name="password" required>
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember-me" name="remember-me">
                                <label for="remember-me">Remember Me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div class="divider"><span>or</span></div>
                        <button type="button" class="btn-google">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo">
                            Continue with Google
                        </button>
                        <div class="form-footer">
                            <p>Don't have an account? <a href="#" id="switch-to-signup">Sign Up</a></p>
                        </div>
                    </form>

                    <!-- Sign Up Form -->
                    <form id="signup-form" class="auth-form" action="signup.php" method="POST" novalidate>
                        <div class="form-group">
                            <label for="signup-username">Username</label>
                            <input type="text" id="signup-username" name="username" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="signup-email">Email</label>
                            <input type="email" id="signup-email" name="email" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Password</label>
                            <div class="password-input">
                                <input type="password" id="signup-password" name="password" required>
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="signup-confirm-password">Confirm Password</label>
                            <div class="password-input">
                                <input type="password" id="signup-confirm-password" name="confirm_password" required>
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Account</button>
                        <div class="divider"><span>or</span></div>
                        <button type="button" class="btn-google">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo">
                            Sign Up with Google
                        </button>
                        <div class="form-footer">
                            <p>Already have an account? <a href="#" id="switch-to-login">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Message Modal (optional, can be used for post-registration success messages) -->
<div id="message-modal" class="modal">
    <!-- Content for this can be populated dynamically with JavaScript -->
</div>