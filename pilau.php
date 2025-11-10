<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookFlix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="pilau.css">
    <link rel="stylesheet" href="base.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Recipe Hero Section -->
    <section class="recipe-hero">
        <div class="container">
            <div class="recipe-hero-content">
                <h1 class="recipe-title">Beef Pilau with Kachumbari</h1>
                <div class="recipe-meta">
                    <span><i class="fas fa-user"></i> By: JKitchens</span>
                    <span><i class="fas fa-clock"></i> 40 minutes</span>
                    <span><i class="fas fa-utensils"></i> 3 servings</span>
                    <span><i class="fas fa-star"></i> 4.8 (24 reviews)</span>
                </div>
                <p>A fragrant, savory, and slightly spicy rice dish with tender chunks of beef. It is traditionally served with Kachumbari, a fresh, tangy tomato and onion salad that cuts through the richness of the pilau, creating a perfect balance of flavors.</p>
                <div class="recipe-tags">
                    <span class="tag">Pilau</span>
                    <span class="tag">Traditional</span>
                    <span class="tag">Home-Cooking</span>
                    <span class="tag">Sweet</span>
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
                    <h2 class="section-heading">Ingredients For Beef Pilau</h2>
                    <ul class="ingredient-list">
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing1">
                            <label for="ing1">2 cups Basmati rice, rinsed and soaked in water for 20 minutes</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing2">
                            <label for="ing2">2 cups Basmati rice, rinsed and soaked in water for 20 minutes</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing3">
                            <label for="ing3">3 large red onions, thinly sliced (divided use)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing4">
                            <label for="ing4">3 large tomatoes, finely chopped</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing5">
                            <label for="ing5">4 cloves garlic, minced</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing6">
                            <label for="ing6">1-inch piece ginger, grated</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">2-3 tbsp pilau masala (see recipe below for homemade blend)</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">1 tsp turmeric powder</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">2-3 bay leaves</label>
                        </li>
                        <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">4 cups beef stock or water (heated)</label>
                        </li>
                         <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">3 tbsp vegetable oil or ghee</label>
                        </li>
                         <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">Salt to taste</label>
                        </li>
                         <li class="ingredient-item">
                            <input type="checkbox" id="ing7">
                            <label for="ing7">Fresh cilantro (dhania), for garnish</label>
                        </li>

                    </ul>
                </div>

                <div class="instructions-section">
                    <h2 class="section-heading">Instructions for Beef Pilau</h2>
                    <ol class="instruction-list">
                        <li class="instruction-item">
                           In a large, heavy-bottomed pot (like a Dutch oven), heat the oil over medium-high heat. Pat the beef cubes dry and season with salt. Brown the meat on all sides. Remove and set aside.
                        </li>
                        <li class="instruction-item">
                             In the same pot, add about two-thirds of the sliced onions. Reduce the heat to medium and cook, stirring frequently, for 10-15 minutes until the onions are soft, deeply browned, and caramelized. 
                             This step is crucial for the pilau's color and flavor.
                        </li>
                        <li class="instruction-item">
                             Add the remaining raw sliced onions, garlic, and ginger to the caramelized onions. Sauté for 2-3 minutes until fragrant. Add the pilau masala and turmeric. 
                             Stir constantly for 30 seconds to toast the spices until incredibly fragrant.
                        <li class="instruction-item">
                            Add the chopped tomatoes and bay leaves. Cook for 5-7 minutes, mashing the tomatoes with your spoon, until they break down and form a thick paste.
                        </li>
                        <li class="instruction-item">
                            Return the browned beef to the pot. Pour in the hot beef stock (or water). Bring to a boil, then reduce the heat to low, cover, and let it simmer for 30-40 minutes, or until the beef is almost tender.
                        </li>
                        <li class="instruction-item">
                            Drain the soaked rice. Add it to the pot with the beef and broth. Stir gently to combine. Season with salt. Bring it back to a gentle boil, then immediately reduce the heat to the lowest possible setting. 
                            Cover the pot tightly with a lid (you can place a piece of foil under the lid for a better seal) and let it cook for 20-25 minutes without peeking.
                        </li>
                        <li class="instruction-item">
                            After 20 minutes, turn off the heat and let the pilau rest, still covered, for another 10 minutes. This allows the rice to finish steaming and prevents it from becoming mushy. 
                            Finally, remove the lid and fluff the rice gently with a fork.
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
                            <strong>10 mins</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-hourglass-half"></i>
                            <span>Cook Time</span>
                            <strong>30 minutes</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-utensils"></i>
                            <span>Servings</span>
                            <strong>5 people</strong>
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