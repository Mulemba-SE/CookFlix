<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="stirfry.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Recipe Hero Section -->
    <section class="recipe-hero">
        <div class="container">
            <div class="recipe-hero-content">
                <h1 class="recipe-title">Vegetable Stir Fry</h1>
                <div class="recipe-meta">
                    <span><i class="fas fa-user"></i> By: SortedK</span>
                    <span><i class="fas fa-clock"></i> 20 min</span>
                    <span><i class="fas fa-utensils"></i> 4 servings</span>
                    <span><i class="fas fa-star"></i> 4.8 (24 reviews)</span>
                </div>
                <p>This recipe delivers a vibrant, crisp-tender vegetable stir-fry coated in a savory, slightly sweet, and glossy sauce. 
                    It's healthier than takeout and comes together faster than you can get delivery!</p>
                <div class="recipe-tags">
                    <span class="tag">Vegetarian</span>
                    <span class="tag">Asian</span>
                    <span class="tag">Quick</span>
                    <span class="tag">Sauce</span>
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
                    <h2 class="section-heading">Ingredients for Stir Fry Sauce</h2>
                    <ul class="ingredient-list">
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing1">
                            <label for="ing1">¼ cup low-sodium soy sauce (or tamari for gluten-free)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing2">
                            <label for="ing2">2 tablespoons water or vegetable broth</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing3">
                            <label for="ing3">1 tablespoon maple syrup, honey, or brown sugar</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing4">
                            <label for="ing4">1 tablespoon rice vinegar (or substitute lime juice)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing5">
                            <label for="ing5">1 teaspoon toasted sesame oil</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing6">
                            <label for="ing6">1 teaspoon cornstarch or arrowroot powder</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">  
                            <label for="ing7">1-2 cloves garlic, minced</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing8">
                            <label for="ing8">1 teaspoon fresh ginger, grated</label>
                        </li>
                        <h2 class="section-heading">Ingredients for Stir Fry</h2>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing9">
                            <label for="ing9">2 tablespoons neutral oil (avocado, grapeseed, or canola), divided</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing10">
                            <label for="ing10">1 small onion, sliced (yellow or red)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing11">
                            <label for="ing11">2 cups hardy vegetables, chopped (e.g., broccoli florets, carrots (sliced), bell peppers, cauliflower, green beans)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing12">
                            <label for="ing12">2 cups quick-cooking vegetables, chopped (e.g., snap peas, snow peas, zucchini, mushrooms, cabbage)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing13">
                            <label for="ing13">Optional Protein: 1 block of firm or extra-firm tofu (pressed and cubed), or 1 cup chickpeas</label>
                        </li>
                    </ul>
                </div>

                <div class="instructions-section">
                    <h2 class="section-heading">Instructions</h2>
                    <ol class="instruction-list">
                        <li class="instruction-item">
                             Chop all your vegetables into uniform, bite-sized pieces so they cook evenly. Mince the garlic and grate the ginger.
                             Keep hardy vegetables (like broccoli, carrots) separate from quick-cooking ones (like mushrooms, snow peas).
                        </li>
                        <li class="instruction-item">
                            In a small bowl or measuring cup, whisk together all the sauce ingredients: soy sauce, water, maple syrup, rice vinegar, sesame oil, cornstarch, garlic, and ginger. 
                            Whisk until the cornstarch is fully dissolved. Set aside.
                        </li>
                        <li class="instruction-item">
                             If using tofu, heat 1 tablespoon of oil in a large wok or skillet over medium-high heat. 
                             Add the tofu and cook, stirring occasionally, until golden and crisp on all sides, about 5-7 minutes. 
                             Remove the tofu from the skillet and set aside.
                        </li>
                        <li class="instruction-item">
                            Heat the remaining 1 tablespoon of oil in the same wok/skillet over high heat. 
                            Once the oil is shimmering hot, add the onions and hardy vegetables (broccoli, carrots, etc.). 
                            Stir-fry for 3-4 minutes until they start to soften and brighten in color.
                        </li>
                        <li class="instruction-item">
                            Add the quick-cooking vegetables (bell peppers, snap peas, mushrooms, etc.). 
                            Continue to stir-fry for another 2-3 minutes until all vegetables are crisp-tender (they should still have a bit of crunch).
                        </li>
                        <li class="instruction-item">
                            Return the cooked tofu (if using) to the wok. Give the prepared sauce a quick stir (the cornstarch may have settled) and pour it over the vegetables.
                            Immediately start tossing and stirring. The sauce will begin to bubble and thicken within 30-60 seconds. 
                            Keep stirring until the sauce glossy and evenly coats every piece.
                        </li>
                        <li>
                            Remove from heat. Serve your stir-fry hot over cooked rice or quinoa. Garnish with sesame seeds and sliced green onions.
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
                            <strong>20 mins</strong>
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
                            <img src="images/Capture.PNG" alt="SortedK">
                        </div>
                        <div class="author-details">
                            <h3>SortedK</h3>
                            <p>Food enthusiast & recipe developer</p>
                            <div class="author-stats">
                                <span><i class="fas fa-receipt"></i> 42 recipes</span>
                                <span><i class="fas fa-users"></i> 5.2k followers</span>
                            </div>
                        </div>
                    </div>
                    <p style="margin-top: 15px;">SortedK is a self-taught cook who loves creating simple, delicious recipes that anyone can make at home. She believes good food should be accessible to everyone.</p>
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
        // header-scroll.js
    document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('hidden');
            } else {
                header.classList.remove('hidden');
            }
            });
     }
    });
    </script>
</body>
</html>