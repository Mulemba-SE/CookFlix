<?php
// It's good practice to start the session on any page that needs session data.
// We will also add this to Home.php and other main pages.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="container header-content">
        <div class="logo">
            <a href="Home.php" style="color: white; text-decoration: none;"><i class="fas fa-utensils"></i> CookFlix</a>
        </div>
        <nav>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="recipe.php">Recipes</a></li>
                <li><a href="community.php">Community</a></li>
                <li><a href="meal.php">Meal Planner</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
        <div class="auth-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Show User Info and Dropdown if logged in -->
                <div class="user-dropdown">
                    <div class="user-avatar-container">
                        <div class="user-avatar">
                            <?php if (isset($_SESSION['avatar_url']) && !empty($_SESSION['avatar_url'])): ?>
                                <img src="<?php echo htmlspecialchars($_SESSION['avatar_url']); ?>" alt="User Avatar" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            <?php endif; ?>
                        </div>
                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="dropdown-menu">
                        <a href="profile.php" class="dropdown-item"><i class="fas fa-user-circle"></i> My Profile</a>
                        <a href="#" class="dropdown-item"><i class="fas fa-bookmark"></i> Saved Recipes</a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Show Login/Sign Up buttons if not logged in -->
                <div class="auth-buttons">
                    <button class="btn btn-primary" id="login-btn">Login</button>
                    <button class="btn btn-outline" id="signup-btn">Sign Up</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>