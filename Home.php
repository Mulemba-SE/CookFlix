<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix - Discover & Share Delicious Recipes</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="Home.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <h1>HELLO! IF YOU CAN SEE THIS, THE FILE IS CORRECT.</h1>

    <?php include 'auth_modal.php'; ?>

    <!-- Hero Section -->
    <section class="hero"> 
        <!-- Background Video -->
       <video class="hero-video" autoplay loop muted playsinline>
            <!-- Temporarily using the working video from recipe.php for testing -->
           <source src="images/6136953-uhd_3840_2160_25fps.mp4" type="video/mp4">

            Your browser does not support the video tag.
        </video>
        <div class="container hero-content-container">
            <h1>Discover & Share Delicious Recipes</h1>
            <p>Join our community of food lovers, share your creations, and never run out of meal ideas again!</p>
            <div class="search-bar">
                <input type="text" placeholder="Search for recipes, ingredients, or categories...">
                <button><i class="fas fa-search"></i></button>
            </div>
        </div> 
    </section>

    <!-- Featured Recipes -->
    <section class="container">
        <h2 class="section-title">Featured Recipes</h2>
        <div class="recipes-grid" id="featured-recipes-grid">
            <!-- Recipe cards will be dynamically inserted here -->
        </div>
    </section>

    <!-- Community Section -->
    <section class="community">
        <div class="container">
            <h2>Join Our Cooking Community</h2>
            <p>Share your recipes, get feedback, collaborate with other food enthusiasts, and never feel stuck for meal ideas again!</p>
            <button class="btn btn-outline" id="joinCommunityBtn">Join CookFlix Today</button>
            <div class="features">
                <div class="feature">
                    <i class="fas fa-users"></i>
                    <h3>Connect</h3>
                    <p>Connect with food lovers around the world</p>
                </div>
                <div class="feature">
                    <i class="fas fa-share-alt"></i>
                    <h3>Share</h3>
                    <p>Share your culinary creations and family recipes</p>
                </div>
                <div class="feature">
                    <i class="fas fa-comments"></i>
                    <h3>Discuss</h3>
                    <p>Get tips and advice from our community</p>
                </div>
                <div class="feature">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Plan</h3>
                    <p>Plan your meals and reduce food waste</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="pageFooter"></footer>
    
    <script src="global.js"></script>
    <script src="auth.js"></script>
   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featuredGrid = document.getElementById('featured-recipes-grid');

            async function loadFeaturedRecipes() {
                try {
                    const res = await fetch('api/recipes.php?featured=true');
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    const response = await res.json();

                    if (response.success && response.data.length > 0) {
                        featuredGrid.innerHTML = ''; // Clear any existing content
                        response.data.forEach(recipe => {
                            const recipeCard = `
                                <div class="recipe-card">
                                    <div class="recipe-img">
                                        <img src="${recipe.image_url}" alt="${recipe.title}">
                                    </div>
                                    <div class="recipe-content">
                                        <h3 class="recipe-title">${recipe.title}</h3>
                                        <div class="recipe-meta">
                                            <span>By: ${recipe.author}</span>
                                            <div class="recipe-stats">
                                                <span><i class="fas fa-star"></i> ${parseFloat(recipe.rating).toFixed(1)}</span>
                                                <span><i class="fas fa-comment"></i> ${recipe.review_count}</span>
                                            </div>
                                        </div>
                                        <p class="recipe-description">${recipe.description}</p>
                                        <div class="recipe-actions">
                                            <a href="${recipe.page_url}"> <button class="btn btn-primary">View Recipe</button></a>
                                            <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            featuredGrid.innerHTML += recipeCard;
                        });
                    } else {
                        featuredGrid.innerHTML = '<p>No featured recipes found.</p>';
                    }
                } catch (error) {
                    console.error('Failed to load featured recipes:', error);
                    featuredGrid.innerHTML = '<p style="color: red;">Could not load recipes. Please try again later.</p>';
                }
            }

            loadFeaturedRecipes();
        });
    </script>
 
</body>
</html>
