<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="recipe1.css">
</head>
<body>
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>
    <!-- Page Header -->
    <section class="page-header">
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
        <section class="recipes-grid">
            <!-- Recipe Card 1 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250918_133648.jpg" alt="Creamy Garlic Pasta">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Creamy Garlic Pasta</h3>
                    <div class="recipe-meta">
                        <span>By: MariaCooks</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.8</span>
                            <span><i class="fas fa-comment"></i> 24</span>
                        </div>
                    </div>
                    <p class="recipe-description">Creamy, garlicky pasta with parmesan cheese and fresh herbs. Ready in 20 minutes!</p>
                    <div class="recipe-tags">
                        <span class="tag">Pasta</span>
                        <span class="tag">Italian</span>
                        <span class="tag">Quick</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 2 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250918_134650.jpg" alt="Avocado Quinoa Salad">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Avocado Quinoa Salad</h3>
                    <div class="recipe-meta">
                        <span>By: HealthyEats</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.6</span>
                            <span><i class="fas fa-comment"></i> 18</span>
                        </div>
                    </div>
                    <p class="recipe-description">A refreshing and nutritious salad with quinoa, avocado, and a lime dressing.</p>
                    <div class="recipe-tags">
                        <span class="tag">Salad</span>
                        <span class="tag">Healthy</span>
                        <span class="tag">Vegan</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 3 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250913_132642.jpg" alt="Herb Roasted Chicken">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Herb Roasted Chicken</h3>
                    <div class="recipe-meta">
                        <span>By: ChefJohn</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.9</span>
                            <span><i class="fas fa-comment"></i> 32</span>
                        </div>
                    </div>
                    <p class="recipe-description">Juicy roasted chicken with fresh herbs and lemon. Perfect for Sunday dinner!</p>
                    <div class="recipe-tags">
                        <span class="tag">Chicken</span>
                        <span class="tag">Dinner</span>
                        <span class="tag">Comfort Food</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 4 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/images (9).jpeg" alt="Cheeseburger Pizza">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Cheeseburger Pizza</h3>
                    <div class="recipe-meta">
                        <span>By: DessertQueen</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.7</span>
                            <span><i class="fas fa-comment"></i> 41</span>
                        </div>
                    </div>
                    <p class="recipe-description">Fudgy, rich chocolate brownies with a crackly top. The perfect dessert!</p>
                    <div class="recipe-tags">
                        <span class="tag">Dessert</span>
                        <span class="tag">Chocolate</span>
                        <span class="tag">Sweet</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 5 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/images (1).jpeg" alt="Classic Burger">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Classic Burger</h3>
                    <div class="recipe-meta">
                        <span>By: VeggieMaster</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.5</span>
                            <span><i class="fas fa-comment"></i> 29</span>
                        </div>
                    </div>
                    <p class="recipe-description">Colorful vegetables stir-fried in a savory sauce. Quick, healthy, and delicious!</p>
                    <div class="recipe-tags">
                        <span class="tag">Vegetarian</span>
                        <span class="tag">Asian</span>
                        <span class="tag">Quick</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 6 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="https://images.unsplash.com/photo-1516100882582-96c3a05fe590?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Beef Tacos">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Beef Tacos</h3>
                    <div class="recipe-meta">
                        <span>By: TacoTuesday</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.8</span>
                            <span><i class="fas fa-comment"></i> 37</span>
                        </div>
                    </div>
                    <p class="recipe-description">Seasoned ground beef in crispy taco shells with all your favorite toppings.</p>
                    <div class="recipe-tags">
                        <span class="tag">Mexican</span>
                        <span class="tag">Beef</span>
                        <span class="tag">Family Friendly</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
                <!-- Recipe Card 7 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250918_134029.jpg" alt="Pilau Kachubari">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Pilau Kachubari</h3>
                    <div class="recipe-meta">
                        <span>By: ChefMwendwa</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 3.8</span>
                            <span><i class="fas fa-comment"></i> 24</span>
                        </div>
                    </div>
                    <p class="recipe-description">Beef Pilau with a tenderlizing aroma, served with pilau. Ready in 30 minutes. </p>
                    <div class="recipe-tags">
                        <span class="tag">Beef</span>
                        <span class="tag">American</span>
                        <span class="tag">Quick</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
                 <!-- Recipe Card 8 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250918_135352.jpg" alt="Muthokoi Avocado">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Mothokoi Avocado</h3>
                    <div class="recipe-meta">
                        <span>By: Evans Mulemba</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.5</span>
                            <span><i class="fas fa-comment"></i> 24</span>
                        </div>
                    </div>
                    <p class="recipe-description">Traditional hearty dish, with a flavorful and fiber-rich companion. Served with creamy Avocado slices.</p>
                    <div class="recipe-tags">
                        <span class="tag">Traditional</span>
                        <span class="tag">Kenyan</span>
                        <span class="tag">Nutritious</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
                  <!-- Recipe Card 8 -->
            <div class="recipe-card">
                <div class="recipe-img">
                    <img src="images/PSX_20250918_135720.jpg" alt="Mukimo">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">Mukimo</h3>
                    <div class="recipe-meta">
                        <span>By: Evans Mulemba</span>
                        <div class="recipe-stats">
                            <span><i class="fas fa-star"></i> 4.5</span>
                            <span><i class="fas fa-comment"></i> 24</span>
                        </div>
                    </div>
                    <p class="recipe-description">It's a hearty, flavorful mash made from a unique combination of arrow roots, potatoes, green vegetables and peas.</p>
                    <div class="recipe-tags">
                        <span class="tag">Home-cooking</span>
                        <span class="tag">Kikuyu</span>
                        <span class="tag">Stewed peas</span>
                    </div>
                    <div class="recipe-actions">
                        <button class="btn btn-primary">View Recipe</button>
                        <button class="btn btn-outline"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pagination -->
        <div class="pagination"> <a href="recipe.php"><button>1</button></a> <a href="recipe1.php"><button class="active">2</button></a> <button>3</button> <button>Next <i class="fas fa-chevron-right"></i></button> </div>
    </div>
    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>
    <script src="global.js"></script>
    <script src="auth.js"></script>
    <script>
        // Simple interactivity for demonstration
        document.addEventListener('DOMContentLoaded', function() {
            // Like button functionality
            const likeButtons = document.querySelectorAll('.btn-outline');
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

            // Tag filter functionality
            const tagFilters = document.querySelectorAll('.tag-filter');
            tagFilters.forEach(tag => {
                tag.addEventListener('click', function() {
                    tagFilters.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Pagination functionality
            const paginationButtons = document.querySelectorAll('.pagination button');
            paginationButtons.forEach(button => {
                button.addEventListener('click', function() {
                    paginationButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Search functionality
            const searchButton = document.querySelector('.search-box button');
            searchButton.addEventListener('click', function() {
                const searchInput = document.querySelector('.search-box input');
                if (searchInput.value.trim() !== '') {
                    alert(`Searching for: ${searchInput.value}`);
                    searchInput.value = '';
                }
            });
        });
    </script>
</body>
</html>