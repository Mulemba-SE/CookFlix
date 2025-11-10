<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix-Recipe</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="recipe.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <!-- Background Video -->
        <video class="header-video" autoplay loop muted playsinline>
            <source src="images/3195650-uhd_3840_2160_25fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="container"> 
            <h1>Discover All Recipes</h1>
            <p>Browse our collection of delicious recipes from around the world</p>
        </div>
    </section>

    <div class="container">
        <!-- Filters Section -->
        <section class="filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="category">Category</label>
                    <select id="category">
                        <option value="all">All Categories</option>
                        <option value="pasta">Pasta</option>
                        <option value="salad">Salad</option>
                        <option value="meat">Meat</option>
                        <option value="vegetarian">Vegetarian</option>
                        <option value="dessert">Dessert</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="time">Max Cooking Time</label>
                    <select id="time">
                        <option value="all">Any Time</option>
                        <option value="15">15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">60+ minutes</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="difficulty">Difficulty</label>
                    <select id="difficulty">
                        <option value="all">Any Difficulty</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Search recipes...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="filter-row">
                <div class="tag-filters">
                    <div class="tag-filter active">All</div>
                    <div class="tag-filter">Quick</div>
                    <div class="tag-filter">Healthy</div>
                    <div class="tag-filter">Vegetarian</div>
                    <div class="tag-filter">Gluten-Free</div>
                    <div class="tag-filter">Dairy-Free</div>
                </div>
            </div>
        </section>

        <!-- Recipes Grid -->
        <section class="recipes-grid" id="all-recipes-grid">
            <!-- Recipe cards will be dynamically inserted here -->
        </section>

        <!-- Pagination -->
        <div class="pagination">
          <a href="recipe.php"><button class="active">1</button></a>
            <a href="recipe1.php"><button>2</button></a>
            <button>3</button>
            <button>Next <i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"></footer>
    <script src="global.js"></script>
    <script src="auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allRecipesGrid = document.getElementById('all-recipes-grid');

            async function loadAllRecipes() {
                try {
                    // Fetch all recipes (no 'featured' parameter)
                    const res = await fetch('api/recipes.php');
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    const response = await res.json();

                    if (response.success && response.data.length > 0) {
                        allRecipesGrid.innerHTML = ''; // Clear static content
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
                                            <a href="${recipe.page_url}"><button class="btn btn-primary">View Recipe</button></a>
                                            <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            allRecipesGrid.innerHTML += recipeCard;
                        });
                    } else {
                        allRecipesGrid.innerHTML = '<p>No recipes found.</p>';
                    }
                } catch (error) {
                    console.error('Failed to load recipes:', error);
                    allRecipesGrid.innerHTML = '<p style="color: red;">Could not load recipes. Please try again later.</p>';
                }
            }

            loadAllRecipes();
        });
    </script>
</body>
</html>