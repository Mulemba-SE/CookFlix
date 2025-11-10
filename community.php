<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix Community</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="community.css">
    
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>RecipeHub Community</h1>
            <p>Connect with food lovers, share your creations, and get inspired</p>
        </div>
    </section>

    <div class="container">
        <!-- Create Post -->
        <section class="create-post">
            <div class="create-post-header">
                <div class="user-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Your Avatar">
                </div>
                <div>
                    <h3>Share your culinary experience</h3>
                    <p class="post-time">What's cooking in your kitchen?</p>
                </div>
            </div>
            <form class="post-form">
                <textarea placeholder="Share your recipe, tip, or food experience..."></textarea>
                <div class="post-options">
                    <div class="add-media">
                        <button type="button" class="media-btn">
                            <i class="fas fa-image"></i> Photo
                        </button>
                        <button type="button" class="media-btn">
                            <i class="fas fa-video"></i> Video
                        </button>
                        <button type="button" class="media-btn" onclick="window.location.href='upload-recipe.php'">
                            <i class="fas fa-utensils"></i> Recipe
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </section>

        <!-- Community Content -->
        <div class="community-content">
            <!-- Main Feed -->
            <div class="community-feed">
                <!-- Post 1 -->
                <div class="post">
                    <div class="post-header">
                        <div class="user-avatar">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Maria Cooks">
                        </div>
                        <div class="user-info">
                            <h3>MariaCooks</h3>
                            <p class="post-time">2 hours ago</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Just tried this new creamy garlic pasta recipe and it turned out amazing! The sauce was so rich and flavorful. Added a bit of extra parmesan and some red pepper flakes for a little kick. 🍝</p>
                        <div class="post-image">
                            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Creamy Garlic Pasta">
                        </div>
                    </div>
                    <div class="post-stats">
                        <span><i class="fas fa-heart"></i> 42 likes</span>
                        <span><i class="fas fa-comment"></i> 15 comments</span>
                    </div>
                    <div class="post-actions">
                        <button class="post-action">
                            <i class="far fa-heart"></i> Like
                        </button>
                        <button class="post-action">
                            <i class="far fa-comment"></i> Comment
                        </button>
                        <button class="post-action">
                            <i class="far fa-share-square"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Post 2 -->
                <div class="post">
                    <div class="post-header">
                        <div class="user-avatar">
                            <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Chef John">
                        </div>
                        <div class="user-info">
                            <h3>ChefJohn</h3>
                            <p class="post-time">1 day ago</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Pro tip: Always let your meat rest for at least 5-10 minutes after cooking. This allows the juices to redistribute throughout the meat, making it more tender and flavorful. This applies to everything from steak to roasted chicken! 🍗</p>
                    </div>
                    <div class="post-stats">
                        <span><i class="fas fa-heart"></i> 87 likes</span>
                        <span><i class="fas fa-comment"></i> 23 comments</span>
                    </div>
                    <div class="post-actions">
                        <button class="post-action">
                            <i class="far fa-heart"></i> Like
                        </button>
                        <button class="post-action">
                            <i class="far fa-comment"></i> Comment
                        </button>
                        <button class="post-action">
                            <i class="far fa-share-square"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Post 3 -->
                <div class="post">
                    <div class="post-header">
                        <div class="user-avatar">
                            <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson">
                        </div>
                        <div class="user-info">
                            <h3>SarahJ</h3>
                            <p class="post-time">3 days ago</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>My first attempt at sourdough bread! After two weeks of nurturing my starter, I'm pretty happy with the results. The crust is perfectly crispy and the inside is soft and tangy. Any tips for getting more air pockets? 🍞</p>
                        <div class="post-image">
                            <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sourdough Bread">
                        </div>
                    </div>
                    <div class="post-stats">
                        <span><i class="fas fa-heart"></i> 124 likes</span>
                        <span><i class="fas fa-comment"></i> 37 comments</span>
                    </div>
                    <div class="post-actions">
                        <button class="post-action">
                            <i class="far fa-heart"></i> Like
                        </button>
                        <button class="post-action">
                            <i class="far fa-comment"></i> Comment
                        </button>
                        <button class="post-action">
                            <i class="far fa-share-square"></i> Share
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="community-sidebar">
                <!-- Trending Recipes -->
                <div class="sidebar-card">
                    <h2 class="card-title">Trending Recipes</h2>
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Creamy Garlic Pasta">
                        </div>
                        <div class="trending-content">
                            <h4>Creamy Garlic Pasta</h4>
                            <p>Quick & easy dinner</p>
                            <div class="trending-stats">
                                <span><i class="fas fa-star"></i> 4.8</span>
                                <span><i class="fas fa-heart"></i> 342</span>
                            </div>
                        </div>
                    </div>
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1484980972926-edee96e0960d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Herb Roasted Chicken">
                        </div>
                        <div class="trending-content">
                            <h4>Herb Roasted Chicken</h4>
                            <p>Perfect Sunday dinner</p>
                            <div class="trending-stats">
                                <span><i class="fas fa-star"></i> 4.9</span>
                                <span><i class="fas fa-heart"></i> 287</span>
                            </div>
                        </div>
                    </div>
                    <div class="trending-item">
                        <div class="trending-img">
                            <img src="https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Chocolate Brownies">
                        </div>
                        <div class="trending-content">
                            <h4>Chocolate Brownies</h4>
                            <p>Rich and fudgy</p>
                            <div class="trending-stats">
                                <span><i class="fas fa-star"></i> 4.7</span>
                                <span><i class="fas fa-heart"></i> 215</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Community Members -->
                <div class="sidebar-card">
                    <h2 class="card-title">Active Members</h2>
                    <ul class="members-list">
                        <li class="member-item">
                            <div class="member-avatar">
                                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Maria Cooks">
                            </div>
                            <div class="member-info">
                                <h4>MariaCooks</h4>
                                <p>Recipe Developer</p>
                            </div>
                            <button class="follow-btn">Follow</button>
                        </li>
                        <li class="member-item">
                            <div class="member-avatar">
                                <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Chef John">
                            </div>
                            <div class="member-info">
                                <h4>ChefJohn</h4>
                                <p>Professional Chef</p>
                            </div>
                            <button class="follow-btn">Follow</button>
                        </li>
                        <li class="member-item">
                            <div class="member-avatar">
                                <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson">
                            </div>
                            <div class="member-info">
                                <h4>SarahJ</h4>
                                <p>Home Baker</p>
                            </div>
                            <button class="follow-btn">Follow</button>
                        </li>
                        <li class="member-item">
                            <div class="member-avatar">
                                <img src="https://randomuser.me/api/portraits/men/42.jpg" alt="Mike Health">
                            </div>
                            <div class="member-info">
                                <h4>MikeHealth</h4>
                                <p>Nutrition Expert</p>
                            </div>
                            <button class="follow-btn">Follow</button>
                        </li>
                    </ul>
                </div>

                <!-- Upcoming Events -->
                <div class="sidebar-card">
                    <h2 class="card-title">Upcoming Events</h2>
                    <div class="event-card">
                        <div class="event-img">
                            <img src="https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Live Cooking Demo">
                        </div>
                        <div class="event-content">
                            <div class="event-date">June 25, 2023 • 7 PM EST</div>
                            <h3 class="event-title">Live Pasta Making Demo</h3>
                            <div class="event-details">
                                <span><i class="fas fa-users"></i> 124 attending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <section class="events-section">
            <h2 class="section-heading">Community Events</h2>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-img">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cooking Competition">
                    </div>
                    <div class="event-content">
                        <div class="event-date">July 10, 2023 • 2 PM EST</div>
                        <h3 class="event-title">Amateur Chef Competition</h3>
                        <div class="event-details">
                            <span><i class="fas fa-users"></i> 89 attending</span>
                            <span><i class="fas fa-trophy"></i> Prizes</span>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-img">
                        <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Baking Workshop">
                    </div>
                    <div class="event-content">
                        <div class="event-date">July 15, 2023 • 5 PM EST</div>
                        <h3 class="event-title">Sourdough Baking Workshop</h3>
                        <div class="event-details">
                            <span><i class="fas fa-users"></i> 67 attending</span>
                            <span><i class="fas fa-star"></i> Beginner Friendly</span>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-img">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Food Festival">
                    </div>
                    <div class="event-content">
                        <div class="event-date">August 5-6, 2023 • All Day</div>
                        <h3 class="event-title">RecipeHub Food Festival</h3>
                        <div class="event-details">
                            <span><i class="fas fa-users"></i> 342 attending</span>
                            <span><i class="fas fa-map-marker-alt"></i> NYC</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

    <script src="global.js"></script>
    <script src="auth.js"></script>
    <script>
        // Simple interactivity for demonstration
        document.addEventListener('DOMContentLoaded', function() {
            // Like button functionality
            const likeButtons = document.querySelectorAll('.post-action');
            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.replace('far', 'fas');
                        this.style.color = '#dc3545';
                    } else {
                        icon.classList.replace('fas', 'far');
                        this.style.color = '';
                    }
                });
            });
            
            // Follow button functionality
            const followButtons = document.querySelectorAll('.follow-btn');
            followButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.textContent === 'Follow') {
                        this.textContent = 'Following';
                        this.style.background = '#6c757d';
                    } else {
                        this.textContent = 'Follow';
                        this.style.background = '';
                    }
                });
            });
            
            // Post form submission
            const postForm = document.querySelector('.post-form');
            postForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const textarea = this.querySelector('textarea');
                if (textarea.value.trim() !== '') {
                    alert('Your post has been shared with the community!');
                    textarea.value = '';
                }
            });
        });
    </script>
</body>
</html>
