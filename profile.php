<?php
session_start();
require_once 'db_connect.php';

// 1. Require Login: If user is not logged in, redirect to homepage.
if (!isset($_SESSION['user_id'])) {
    header('Location: Home.php');
    exit;
}

// 2. Fetch User Data: Get the current user's information from the database.
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, created_at, avatar_url, bio, phone, location FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// If for some reason the user isn't found, log them out and redirect.
if (!$user) {
    header('Location: logout.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="profile.css">
   
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Profile Header -->
    <section class="profile-header">
        <div class="container">
            <h1>Profile</h1>
            <p id="profileSubtitle">Manage your account, view your activity, and track your cooking journey</p>
        </div>
    </section>

    <!-- Profile Content -->
    <div class="container">
        <div class="profile-container">
            <!-- Profile Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <div class="avatar-large-container" id="avatarLargeContainer">
                        <div class="avatar-large" id="profileAvatarLarge" title="<?php echo htmlspecialchars($user['username']); ?>">
                            <?php if (!empty($user['avatar_url'])): ?>
                                <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="User Avatar" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                            <?php endif; ?>
                        </div>
                        <div class="avatar-upload-icon" title="Change Avatar" id="avatarUploadIcon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" id="avatarUploadInput" accept="image/*" style="display: none;" />
                        
                        <!-- Avatar Options Menu -->
                        <div class="avatar-options-menu" id="avatarOptionsMenu">
                            <button class="avatar-option" id="viewAvatarBtn">
                                <i class="fas fa-eye"></i> View Avatar
                            </button>
                            <button class="avatar-option" id="changeAvatarBtn">
                                <i class="fas fa-camera"></i> Change Avatar
                            </button>
                            <button class="avatar-option remove" id="removeAvatarBtn">
                                <i class="fas fa-trash"></i> Remove Avatar
                            </button>
                        </div>
                    </div>

                    <!-- Avatar View Modal -->
                    <div class="avatar-view-modal" id="avatarViewModal">
                        <div class="avatar-view-content">
                            <button class="close-modal" id="closeViewBtn">&times;</button>
                            <h3>Your Avatar</h3>
                            <img id="avatarViewImage" class="avatar-view-image" src="" alt="Avatar">
                            <div class="avatar-view-actions">
                                <button class="btn btn-outline" id="changeFromViewBtn">Change Avatar</button>
                                <button class="btn btn-primary" onclick="document.getElementById('avatarViewModal').style.display='none'">Close</button>
                            </div>
                        </div>
                    </div>

                    <h2 id="profileName"><?php echo htmlspecialchars($user['username']); ?></h2>
                   
                    
                    <button class="btn btn-outline" style="margin-top: 15px; width: 100%;" id="editProfileBtn">Edit Profile</button>
                </div>

                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-value" id="recipesCount">0</span>
                        <span class="stat-label">Recipes</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value" id="followersCount">0</span>
                        <span class="stat-label">Followers</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value" id="followingCount">0</span>
                        <span class="stat-label">Following</span>
                    </div>
                </div>

                <div class="profile-section">
                    <h3>About Me</h3>
                    <p id="profileBio">
                        <?php echo !empty($user['bio']) ? htmlspecialchars($user['bio']) : 'Click "Edit Profile" to add a bio!'; ?>
                    </p>
                </div>

                <div class="profile-section">
                    <h3>Cooking Preferences</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Diet</div>
                            <div class="info-value" id="dietPreference">Not specified</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Skill Level</div>
                            <div class="info-value" id="skillLevel">Not specified</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Favorite Cuisine</div>
                            <div class="info-value" id="favoriteCuisine">Not specified</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Main Content -->
            <div class="profile-main">
                <div class="profile-tabs">
                    <button class="profile-tab active" data-tab="overview">Overview</button>
                    <button class="profile-tab" data-tab="recipes">My Recipes</button>
                    <button class="profile-tab" data-tab="favorites">Favorites</button>
                    <button class="profile-tab" data-tab="achievements">Achievements</button>
                    <button class="profile-tab" data-tab="settings">Account Settings</button>
                </div>

                <!-- Overview Tab -->
                <div class="tab-content active" id="overview">
                    <div class="profile-section">
                        <h3>Recent Activity</h3>
                        <div class="activity-list" id="recentActivity">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="profile-section">
                        <h3>Personal Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Username</div>
                                <div class="info-value" id="personalName"><?php echo htmlspecialchars($user['username']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value" id="personalEmail"><?php echo htmlspecialchars($user['email']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone</div>
                                <div class="info-value" id="personalPhone">
                                    <?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Not specified'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Location</div>
                                <div class="info-value" id="personalLocation">
                                    <?php echo !empty($user['location']) ? htmlspecialchars($user['location']) : 'Not specified'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Member Since</div>
                                <div class="info-value" id="memberSince"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Last Login</div>
                                <div class="info-value" id="lastLogin">Just now</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Recipes Tab -->
                <div class="tab-content" id="recipes">
                    <div class="profile-section">
                        <h3>My Recipes</h3>
                        <div class="user-recipes" id="userRecipes">
                            <i class="fas fa-user-plus"></i>
                            <h4>Create an Account</h4>
                            <p>Sign up to start creating and saving your own recipes!</p>
                            <button class="btn btn-primary" id="signupRecipesBtn">Create Recipe</button>
                        </div>
                        <div class="user-recipes" id="userRecipes" style="display: none;">
                            <!-- User recipes will be shown here when logged in -->
                        </div>
                    </div>
                </div>

                <!-- Favorites Tab -->
                <div class="tab-content" id="favorites">
                    <div class="profile-section">
                        <h3>My Favorite Recipes</h3>
                        <div class="user-favorites" id="userFavorites">
                            <i class="fas fa-heart"></i>
                            <h4>Save Your Favorites</h4>
                            <p>Create an account to save and organize your favorite recipes!</p>
                            <button class="btn btn-primary" id="signupFavoritesBtn">Sign Up Now</button>
                        </div>
                        <div class="user-favorites" id="userFavorites" style="display: block;">
                            <!-- User favorites will be shown here when logged in -->
                        </div>
                    </div>
                </div>

                <!-- Achievements Tab -->
                <div class="tab-content" id="achievements">
                    <div class="profile-section">
                        <h3>My Cooking Achievements</h3>
                        <div class="user-achievements" id="userAchievements">
                            <i class="fas fa-trophy"></i>
                            <h4>Unlock Achievements</h4>
                            <p>Join CookFlix to earn achievements as you explore and create recipes!</p>
                            <button class="btn btn-primary" id="signupAchievementsBtn">Sign Up Now</button>
                        </div>
                        <div class="user-achievements" id="userAchievements" style="display: block;">
                            <!-- User achievements will be shown here when logged in -->
                        </div>
                    </div>
                </div>

                <!-- Account Settings Tab -->
                <div class="tab-content" id="settings">
                    <div class="profile-section">
                        <h3>Account Settings</h3>
                        <form id="changePasswordForm">
                            <h4>Change Password</h4>
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" id="currentPassword" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" id="newPassword" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" id="confirmPassword" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                            <div id="passwordChangeMessage" class="message" style="display: none; margin-top: 15px;"></div>
                        </form>
                        
                        <div class="danger-zone">
                            <h4>Danger Zone</h4>
                            <p>This action is permanent and cannot be undone. This will permanently delete your account, recipes, and all associated data.</p>
                            <button class="btn btn-danger" id="deleteAccountBtn">Delete My Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal" id="editProfileModal">
        <div class="modal-content">
            <button class="close-modal" id="closeEditModal">&times;</button>
            <h2>Edit Your Profile</h2>
            <form id="editProfileForm">
                <div class="form-group">
                    <label for="editUsername">Username</label>
                    <input type="text" id="editUsername" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="editBio">About Me</label>
                    <textarea id="editBio" name="bio" rows="4" placeholder="Tell us about your cooking style..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="editPhone">Phone</label>
                    <input type="tel" id="editPhone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="e.g., +1 555-123-4567">
                </div>
                <div class="form-group">
                    <label for="editLocation">Location</label>
                    <input type="text" id="editLocation" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>" placeholder="e.g., Nairobi, Kenya">
                </div>
                <!-- Add more fields for preferences as needed -->
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelEditBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <div id="editProfileMessage" class="message" style="display: none;"></div>
            </form>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal" id="deleteAccountModal">
        <div class="modal-content">
            <button class="close-modal" id="closeDeleteModal">&times;</button>
            <h2>Are you absolutely sure?</h2>
            <p>This action cannot be undone. This will permanently delete your account and all of your content.</p>
            <p>Please type <strong><?php echo htmlspecialchars($user['username']); ?></strong> to confirm.</p>
            <form id="deleteAccountForm">
                <div class="form-group" style="padding: 0;">
                    <input type="text" id="deleteConfirmInput" placeholder="Type your username" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>I understand, delete my account</button>
            </form>
        </div>
    </div>


    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

   <script src="global.js"></script>
   <script src="auth.js"></script>
   <script src="profile.js"></script>
  <script>
     // Page-specific scripts for profile.htm can remain here.
  </script>
   </body>
   </html>