<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="pasta.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>
    <!-- Recipe Hero Section -->
    <section class="recipe-hero">
        <div class="container">
            <div class="recipe-hero-content">
                <h1 class="recipe-title">Creamy Garlic Pasta</h1>
                <div class="recipe-meta">
                    <span><i class="fas fa-user"></i> By: MariaCooks</span>
                    <span><i class="fas fa-clock"></i> 20 min</span>
                    <span><i class="fas fa-utensils"></i> 4 servings</span>
                    <span><i class="fas fa-star"></i> 4.8 (24 reviews)</span>
                </div>
                <p>A creamy, garlicky pasta with parmesan cheese and fresh herbs. Ready in just 20 minutes, this dish is perfect for a quick weeknight dinner that feels indulgent!</p>
                <div class="recipe-tags">
                    <span class="tag">Pasta</span>
                    <span class="tag">Italian</span>
                    <span class="tag">Quick</span>
                    <span class="tag">Vegetarian</span>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Recipe Content -->
        <div class="recipe-content">
            <!-- Main Content -->
            <div class="recipe-main">
                <div class="ingredients-section">
                    <h2 class="section-heading">Ingredients</h2>
                    <ul class="ingredient-list">
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing1">
                            <label for="ing1">8 oz (225g) fettuccine or linguine pasta</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing2">
                            <label for="ing2">2 tablespoons olive oil</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing3">
                            <label for="ing3">4 cloves garlic, minced</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing4">
                            <label for="ing4">2 tablespoons butter</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing5">
                            <label for="ing5">1 cup heavy cream</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing6">
                            <label for="ing6">1/2 cup grated parmesan cheese</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">Salt and pepper to taste</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing8">
                            <label for="ing8">1/4 cup fresh parsley, chopped</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing9">
                            <label for="ing9">1 teaspoon red pepper flakes (optional)</label>
                        </li>
                    </ul>
                </div>

                <div class="instructions-section">
                    <h2 class="section-heading">Instructions</h2>
                    <ol class="instruction-list">
                        <li class="instruction-item">
                            Cook the pasta according to package instructions in a large pot of salted boiling water until al dente. Reserve 1/2 cup of pasta water before draining.
                        </li>
                        <li class="instruction-item">
                            While the pasta is cooking, heat olive oil in a large skillet over medium heat. Add minced garlic and sauté for 1-2 minutes until fragrant but not browned.
                        </li>
                        <li class="instruction-item">
                            Add butter to the skillet and let it melt. Pour in the heavy cream and bring to a gentle simmer. Cook for 2-3 minutes, stirring occasionally.
                        </li>
                        <li class="instruction-item">
                            Reduce heat to low and gradually whisk in the parmesan cheese until the sauce is smooth and creamy. Season with salt and pepper to taste.
                        </li>
                        <li class="instruction-item">
                            Add the drained pasta to the skillet, tossing to coat evenly in the sauce. If the sauce is too thick, add a splash of the reserved pasta water to reach your desired consistency.
                        </li>
                        <li class="instruction-item">
                            Stir in the chopped parsley and red pepper flakes (if using). Serve immediately with extra parmesan cheese on top.
                        </li>
                    </ol>
                </div>

                <!-- Reviews Section -->
                <div class="reviews-section">
                    <h2 class="section-heading">Reviews</h2>
                    
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer">
                                <div class="reviewer-avatar">
                                    <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson">
                                </div>
                                <div>
                                    <h4>Sarah Johnson</h4>
                                    <div class="review-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="review-date">3 days ago</div>
                        </div>
                        <p>This recipe was absolutely delicious! I added some grilled chicken to make it a complete meal. The sauce was creamy and full of flavor. Will definitely make again!</p>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer">
                                <div class="reviewer-avatar">
                                    <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Michael Chen">
                                </div>
                                <div>
                                    <h4>Michael Chen</h4>
                                    <div class="review-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="review-date">1 week ago</div>
                        </div>
                        <p>Quick and easy weeknight dinner. I used half-and-half instead of heavy cream to make it a bit lighter, and it still turned out great. The garlic flavor is perfect.</p>
                    </div>
                    
                    <!-- Review Form -->
                    <div class="review-form">
                        <h3>Leave a Review</h3>
                        <form id="reviewForm">
                            <div class="form-group">
                                <label for="rating">Your Rating</label>
                                <div class="rating-input">
                                    <i class="far fa-star" data-value="1"></i>
                                    <i class="far fa-star" data-value="2"></i>
                                    <i class="far fa-star" data-value="3"></i>
                                    <i class="far fa-star" data-value="4"></i>
                                    <i class="far fa-star" data-value="5"></i>
                                </div>
                                <input type="hidden" id="rating" name="rating" value="0">
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Review</label>
                                <textarea id="comment" name="comment" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="recipe-sidebar">
                <div class="info-card">
                    <h3 class="card-title">Recipe Info</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>Prep Time</span>
                            <strong>5 mins</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-hourglass-half"></i>
                            <span>Cook Time</span>
                            <strong>15 mins</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-utensils"></i>
                            <span>Servings</span>
                            <strong>4 people</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-fire"></i>
                            <span>Calories</span>
                            <strong>520/serving</strong>
                        </div>
                    </div>
                </div>

                <div class="nutrition-card">
                    <h3 class="card-title">Nutrition (per serving)</h3>
                    <ul class="nutrition-list">
                        <li class="nutrition-item">
                            <span>Calories</span>
                            <span>520</span>
                        </li>
                        <li class="nutrition-item">
                            <span>Fat</span>
                            <span>32g</span>
                        </li>
                        <li class="nutrition-item">
                            <span>Carbs</span>
                            <span>45g</span>
                        </li>
                        <li class="nutrition-item">
                            <span>Protein</span>
                            <span>14g</span>
                        </li>
                        <li class="nutrition-item">
                            <span>Sodium</span>
                            <span>380mg</span>
                        </li>
                    </ul>
                </div>

                <div class="author-card">
                    <h3 class="card-title">About the Author</h3>
                    <div class="author-info">
                        <div class="author-avatar">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Maria Cooks">
                        </div>
                        <div class="author-details">
                            <h3>MariaCooks</h3>
                            <p>Food enthusiast & recipe developer</p>
                            <div class="author-stats">
                                <span><i class="fas fa-receipt"></i> 42 recipes</span>
                                <span><i class="fas fa-users"></i> 5.2k followers</span>
                            </div>
                        </div>
                    </div>
                    <p style="margin-top: 15px;">Maria is a self-taught cook who loves creating simple, delicious recipes that anyone can make at home. She believes good food should be accessible to everyone.</p>
                    <button class="btn btn-primary" style="width: 100%; margin-top: 15px;">Follow Author</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

    <script src="global.js"></script>
     <script src="auth.js"></script>
    <script>
        // Interactive rating stars
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-input i');
            const ratingInput = document.getElementById('rating');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = value;
                    
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= value) {
                            s.classList.add('fas', 'active');
                            s.classList.remove('far');
                        } else {
                            s.classList.add('far');
                            s.classList.remove('fas', 'active');
                        }
                    });
                });
                
                star.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= value) {
                            s.classList.add('fas', 'active');
                            s.classList.remove('far');
                        } else {
                            s.classList.add('far');
                            s.classList.remove('fas', 'active');
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    const currentRating = parseInt(ratingInput.value);
                    
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= currentRating) {
                            s.classList.add('fas', 'active');
                            s.classList.remove('far');
                        } else {
                            s.classList.add('far');
                            s.classList.remove('fas', 'active');
                        }
                    });
                });
            });
            
            // Form submission
            const reviewForm = document.getElementById('reviewForm');
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your review! It will be published once approved.');
                reviewForm.reset();
                
                // Reset stars
                stars.forEach(s => {
                    s.classList.add('far');
                    s.classList.remove('fas', 'active');
                });
                ratingInput.value = '0';
            });
            
            // Ingredient checklist
            const ingredientCheckboxes = document.querySelectorAll('.ingredient-item input');
            ingredientCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.parentElement.style.textDecoration = 'line-through';
                        this.parentElement.style.opacity = '0.7';
                    } else {
                        this.parentElement.style.textDecoration = 'none';
                        this.parentElement.style.opacity = '1';
                    }
                });
            });
        });
    </script>
</body>
</html>