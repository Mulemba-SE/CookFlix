<?php
session_start();
require_once 'db_connect.php';

// 1. Get Recipe ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // If no ID is provided, redirect to the main recipes page
    header('Location: recipe.php');
    exit;
}
$recipe_id = intval($_GET['id']);

// 2. Fetch Recipe Data from Database
$recipe = null;
$ingredients = [];
$steps = [];
$tags = [];

try {
    // Fetch main recipe details and author info
    $stmt = $conn->prepare("
        SELECT r.recipe_id, r.title, r.description, r.prep_time, r.cook_time, r.servings, r.difficulty, r.image_url, r.ingredients_json, r.steps_json, u.username AS author_name
        FROM Recipes r
        JOIN Users u ON r.author_id = u.user_id
        WHERE r.recipe_id = ?
    ");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        // Recipe not found
        http_response_code(404);
        echo "<h1>404 - Recipe Not Found</h1><p>Sorry, the recipe you are looking for does not exist.</p>";
        exit;
    }
    $recipe = $result->fetch_assoc();
    $stmt->close();
    
    // Decode the JSON data for ingredients and steps directly from the Recipes table
    $ingredients = json_decode($recipe['ingredients_json'] ?? '[]', true);
    $steps = json_decode($recipe['steps_json'] ?? '[]', true);

    // Fetch tags
    $stmt = $conn->prepare("
        SELECT t.name
        FROM Recipe_Tags rt
        JOIN Tags t ON rt.tag_id = t.tag_id
        WHERE rt.recipe_id = ?
    ");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }
    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Error</h1><p>There was an error fetching the recipe data.</p>";
    // In a real application, you would log this error instead of displaying it.
    // error_log($e->getMessage());
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Re-using pasta.css for a consistent recipe page layout -->
    <link rel="stylesheet" href="pasta.css">
    <style>
        /* Style for the hero image */
        .recipe-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo htmlspecialchars($recipe['image_url']); ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Recipe Hero Section -->
    <section class="recipe-hero">
        <div class="container">
            <div class="recipe-hero-content">
                <h1 class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h1>
                <div class="recipe-meta">
                    <span><i class="fas fa-user"></i>&nbsp;By: <?php echo htmlspecialchars($recipe['author_name']); ?></span>
                    <span><i class="fas fa-clock"></i>&nbsp;<?php echo intval($recipe['prep_time']) + intval($recipe['cook_time']); ?> min</span>
                    <span><i class="fas fa-utensils"></i>&nbsp;<?php echo htmlspecialchars($recipe['servings']); ?> servings</span>
                    <span><i class="fas fa-star"></i>&nbsp;(No reviews yet)</span>
                </div>
                <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                <div class="recipe-tags">
                    <?php foreach ($tags as $tag): ?>
                        <span class="tag"><?php echo htmlspecialchars($tag['name']); ?></span>
                    <?php endforeach; ?>
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
                        <?php foreach ($ingredients as $index => $item): ?>
                            <?php if (isset($item['type']) && $item['type'] === 'subheading'): ?>
                                </ul><h2 class="section-heading" style="margin-top: 2rem;"><?php echo htmlspecialchars($item['text']); ?></h2><ul class="ingredient-list">
                            <?php else: // It's a regular ingredient item ?>
                                <li class="ingredient-item">
                                    <input type="checkbox" id="ing<?php echo $index; ?>">
                                    <label for="ing<?php echo $index; ?>"><?php echo htmlspecialchars($item['name']); ?></label>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="instructions-section">
                    <h2 class="section-heading">Instructions</h2>
                    <?php 
                        $is_first_ol = true;
                        foreach ($steps as $item): 
                            if (isset($item['type']) && $item['type'] === 'subheading'):
                                if (!$is_first_ol) echo '</ol>'; // Close previous list if it exists
                                $is_first_ol = false;
                    ?>
                                <h2 class="section-heading" style="margin-top: 2rem;"><?php echo htmlspecialchars($item['text']); ?></h2>
                                <ol class="instruction-list">
                    <?php 
                            else: // It's a regular step item
                                if ($is_first_ol) {
                                    echo '<ol class="instruction-list">';
                                    $is_first_ol = false;
                                }
                    ?>
                                <li class="instruction-item"><?php echo htmlspecialchars($item['instruction']); ?></li>
                    <?php 
                            endif; 
                        endforeach; 
                        if (!$is_first_ol) echo '</ol>'; // Close the last list
                    ?>
                </div>

                <!-- Reviews Section (Static for now) -->
                <div class="reviews-section">
                    <h2 class="section-heading">Reviews</h2>
                    <p>Be the first to review this recipe!</p>
                    <!-- Review Form -->
                    <div class="review-form">
                        <h3>Leave a Review</h3>
                        <form id="reviewForm">
                            <div class="form-group">
                                <label for="rating">Your Rating</label>
                                <div class="rating-input">
                                    <i class="far fa-star" data-value="1"></i><i class="far fa-star" data-value="2"></i><i class="far fa-star" data-value="3"></i><i class="far fa-star" data-value="4"></i><i class="far fa-star" data-value="5"></i>
                                </div>
                                <input type="hidden" id="rating" name="rating" value="0">
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Review</label>
                                <textarea id="comment" name="comment" required></textarea>
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
                            <strong><?php echo htmlspecialchars($recipe['prep_time']); ?> mins</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-hourglass-half"></i>
                            <span>Cook Time</span>
                            <strong><?php echo htmlspecialchars($recipe['cook_time']); ?> mins</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-utensils"></i>
                            <span>Servings</span>
                            <strong><?php echo htmlspecialchars($recipe['servings']); ?> people</strong>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Difficulty</span>
                            <strong><?php echo htmlspecialchars($recipe['difficulty']); ?></strong>
                        </div>
                    </div>
                </div>

                <div class="author-card">
                    <h3 class="card-title">About the Author</h3>
                    <div class="author-info">
                        <div class="author-avatar">
                            <!-- Placeholder avatar -->
                            <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Author Avatar">
                        </div>
                        <div class="author-details">
                            <h3><?php echo htmlspecialchars($recipe['author_name']); ?></h3>
                            <p>Community Contributor</p>
                        </div>
                    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Interactive rating stars
            const stars = document.querySelectorAll('.rating-input i');
            const ratingInput = document.getElementById('rating');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = value;
                    
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= value) {
                            s.classList.add('fas', 'active');
                            s.classList.remove('far');
                        } else {
                            s.classList.add('far');
                            s.classList.remove('fas', 'active');
                        }
                    });
                });
            });

            // Review form submission
            const reviewForm = document.getElementById('reviewForm');
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your review!');
                reviewForm.reset();
                // Reset stars
                stars.forEach(s => {
                    s.classList.add('far');
                    s.classList.remove('fas', 'active');
                });
                ratingInput.value = '0';
            });
        });
    </script>
</body>
</html>