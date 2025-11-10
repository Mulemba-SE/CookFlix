<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="about.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>About CookFlix</h1>
            <p>Discover our story, mission, and the team behind the platform that's connecting food lovers around the world</p>
        </div>
    </section>

    <div class="container">
        <!-- Our Story Section -->
        <section class="about-section">
            <h2 class="section-heading">Our Story</h2>
            <div class="story-content">
                <div class="story-text">
                    <p>CookFlix was born from a simple idea: cooking should be joyful, accessible, and social. Founded in 2018 by a group of food enthusiasts, we noticed that people often struggled with meal planning, finding reliable recipes, and avoiding food waste.</p>
                    <p>What started as a small community recipe-sharing platform has grown into a comprehensive cooking ecosystem serving millions of users worldwide. We believe that sharing food experiences brings people together and that everyone has something valuable to contribute to the culinary world.</p>
                    <p>Today, CookFlix is more than just a recipe website---it's a thriving community where home cooks and professional chefs alike can share their passion for food, discover new flavors, and make cooking an enjoyable part of their daily lives.</p>
                </div>
                <div class="story-image">
                    <img src="images/pexels-olly-3768169.jpg" alt="Pots and pans on a lit stove in a kitchen">
                </div>
            </div>
        </section>

        <!-- Mission & Values Section -->
        <section class="about-section">
            <h2 class="section-heading">Our Mission & Values</h2>
            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Make Cooking Accessible</h3>
                    <p>We believe everyone should have access to great recipes and cooking guidance, regardless of their skill level or kitchen equipment.</p>
                </div>
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Build Community</h3>
                    <p>Food brings people together. We're creating spaces for cooks to share experiences, tips, and culinary inspiration.</p>
                </div>
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Reduce Food Waste</h3>
                    <p>Our meal planning tools help users make the most of their ingredients, reducing food waste and saving money.</p>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500K+</div>
                        <div class="stat-label">Recipes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2M+</div>
                        <div class="stat-label">Users</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">120+</div>
                        <div class="stat-label">Countries</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="about-section">
            <h2 class="section-heading">Meet Our Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image">
                        <img src="images/pexels-olly-3768169.jpg" alt="Prof.EvansMulemba">
                    </div>
                    <div class="member-info">
                        <h3>Prof.Evans Mulemba</h3>
                        <div class="member-role">Founder & CEO</div>
                        <p class="member-desc">Former restaurant owner with a passion for bringing people together through food.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="images/Capture.PNG" alt="MwendwaBrian">
                    </div>
                    <div class="member-info">
                        <h3>MwendwaBrian</h3>
                        <div class="member-role">Head of Product</div>
                        <p class="member-desc">Tech enthusiast with a love for creating seamless user experiences in the kitchen.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="images/Photoroom-20250617_110418348.png" alt="Emily Kamau">
                    </div>
                    <div class="member-info">
                        <h3>Emily Kamau</h3>
                        <div class="member-role">Executive Chef</div>
                        <p class="member-desc">Award-winning chef dedicated to creating accessible recipes for home cooks.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="David Kim">
                    </div>
                    <div class="member-info">
                        <h3>David Kim</h3>
                        <div class="member-role">Community Manager</div>
                        <p class="member-desc">Passionate about building engaged communities and connecting food lovers worldwide.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-discord"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="about-section">
            <h2 class="section-heading">What Our Users Say</h2>
            <div class="testimonials-grid">
                <div class="testimonial">
                    <p class="testimonial-text">CookFlix has completely transformed how I cook. The meal planner feature saves me so much time, and I've discovered recipes that have become family favorites!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Jessica Miller">
                        </div>
                        <div class="author-info">
                            <h4>Jessica Johnson</h4>
                            <div class="author-role">Home Cook</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <p class="testimonial-text">As a professional chef, I appreciate the quality of recipes on RecipeHub. The community features allow me to share my expertise and connect with food enthusiasts.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Marcus Johnson">
                        </div>
                        <div class="author-info">
                            <h4>Mark Son</h4>
                            <div class="author-role">Professional Chef</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <p class="testimonial-text">The social features make RecipeHub more than just a recipe site. I've made friends, joined cooking challenges, and even attended virtual events through the platform.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sophia Williams">
                        </div>
                        <div class="author-info">
                            <h4>Sophia Williams</h4>
                            <div class="author-role">Food Blogger</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-content">
                <h2>Join Our Culinary Community</h2>
                <p>Become part of a global community of food lovers. Share recipes, plan meals, and connect with fellow cooking enthusiasts.</p>
                <div class="cta-buttons">
                    <button class="btn btn-primary" id="joinCommunityBtn">Create Account</button>
                    <button class="btn btn-outline">Learn More</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

   <script src="global.js"></script>
   <script src="auth.js"></script>
    </body>
    </html>