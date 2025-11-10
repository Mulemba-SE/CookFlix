<?php session_start();
// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: Home.php'); // or login.php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Recipe - CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- AI Modern Theme --- */
        :root {
            --ai-bg: #1a1a2e;
            --ai-surface: rgba(26, 26, 46, 0.6); /* Semi-transparent surface */
            --ai-primary: #ff7e5f; /* CookFlix Primary Orange */
            --ai-glow: rgba(255, 126, 95, 0.3);
            --ai-text: #e0e0e0;
            --ai-text-secondary: #9a9a9e;
            --ai-border: rgba(255, 126, 95, 0.2);
        }

        body {
            background-color: rgba(26, 26, 46, 0.7); /* Dark overlay for readability over video */
            color: var(--ai-text);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        .body-background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1; /* Place video behind all content */
            filter: blur(3px); /* Optional: adds a slight blur to the video */
        }

        /* Styles for the new upload page */
        .upload-container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--ai-surface);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 12px;
            border: 1px solid var(--ai-border);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            margin-top: 8rem; /* Add space for the fixed header */
        }

        /* Stepper Styles */
        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
            position: relative;
        }
        .step {
            text-align: center;
            flex: 1;
            position: relative;
        }
        .step::before { /* Connecting line */
            content: '';
            position: absolute;
            top: 20px;
            left: 5%;
            width: 100%;
            height: 2px;
            background-color: var(--ai-border);
            z-index: -1;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: transparent;
            color: var(--ai-text-secondary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid var(--ai-border);
            transition: all 0.3s ease;
        }
        .step-title {
            margin-top: 0.5rem;
            font-weight: 500;
            color: #999;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .upload-header h1 {
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        .upload-header p {
            font-size: 1.1rem;
            color: var(--ai-text-secondary);
            margin-bottom: 2rem;
        }
        #recipe-upload-form fieldset {
            border: none;
            padding: 0;
            margin-bottom: 3rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 2.5rem;
        }
        #recipe-upload-form fieldset:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }
        #recipe-upload-form legend {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--ai-primary);
            margin-bottom: 1.5rem;
            padding: 0;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            color: var(--ai-text);
            margin-bottom: 0.5rem;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: none;
            border-bottom: 2px solid var(--ai-border);
            border-radius: 4px 4px 0 0; /* Slight rounding on top corners */
            font-size: 1.0rem;
            background-color: rgba(0,0,0,0.25);
            color: #fff; /* Changed to white */
            /* color: #fff;  Override to inherit from body */
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-group select {
            border: 2px solid var(--ai-border); /* Select boxes look better with full border */
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-bottom-color: var(--ai-primary);
            box-shadow: 0 0 0 3px var(--ai-glow), 0 0 15px var(--ai-glow) inset;
            outline: none;
            background-color: rgba(0,0,0,0.3);
        }
        .image-upload-box {
            border: 2px dashed var(--ai-border);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .image-upload-box:hover {
            background-color: rgba(0, 170, 255, 0.05);
            border-color: var(--ai-primary);
        }
        .image-upload-box i {
            font-size: 2.5rem;
            color: var(--ai-primary);
            margin-bottom: 1rem;
        }
        .image-upload-box p {
            color: var(--ai-text-secondary);
        }
        #image-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            margin-top: 1rem;
            object-fit: cover;
        }
        .dynamic-list-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .dynamic-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .dynamic-row input,
        .dynamic-row textarea {
            flex-grow: 1; /* Allow inputs to take available space */
        }
        .dynamic-row input[name*="[quantity]"] {
            flex-grow: 0;
            width: 120px; /* Give quantity a fixed width */
        }
        .dynamic-row textarea {
            flex: 4;
            border-radius: 0 8px 8px 0 !important;
        }
        .dynamic-row .step-number {
            font-weight: bold;
            color: var(--ai-text-secondary);
        }
        .remove-btn {
            background: rgba(255,255,255,0.1);
            color: var(--ai-text-secondary);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 1rem;
            line-height: 30px;
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
        }
        .remove-btn:hover {
            background: #ff4757;
            color: #fff;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
        /* Override base.css for buttons on this page */
        .btn-primary {
            background: var(--ai-primary);
            color: #fff;
            border: none;
        }
        .btn-primary:hover {
            box-shadow: 0 0 15px var(--ai-glow);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--ai-primary);
            color: var(--ai-primary);
        }
        .btn-outline:hover { background: var(--ai-glow); }
    </style>
</head>
<body>
    <!-- Background Video -->
    <video class="body-background-video" autoplay loop muted playsinline>
        <!-- You can use a different video if you like -->
        <source src="images/3195650-uhd_3840_2160_25fps.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

  

    <div class="upload-container">
        <div class="upload-header">
            <h1>Share Your Recipe</h1>
            <p>Fill out the details below to share your creation with the community. Good recipes get featured!</p>
        </div>

        <div class="stepper">
            <div class="step" id="step-1">
                <div class="step-number">1</div><div class="step-title">Basics</div>
            </div>
            <div class="step" id="step-2">
                <div class="step-number">2</div><div class="step-title">Details</div>
            </div>
            <div class="step" id="step-3">
                <div class="step-number">3</div><div class="step-title">Ingredients</div>
            </div>
            <div class="step" id="step-4">
                <div class="step-number">4</div><div class="step-title">Instructions</div>
            </div>
            <div class="step" id="step-5">
                <div class="step-number">5</div><div class="step-title">Categorize</div>
            </div>
        </div>

        <form id="recipe-upload-form" enctype="multipart/form-data">
            <div id="recipe-form-error" class="error-message" style="display:none; margin-bottom: 15px;"></div>

            <!-- Basic Info -->
            <fieldset>
                <legend>1. Basic Information</legend>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="recipe-title">Recipe Title</label>
                        <input type="text" id="recipe-title" name="title" required placeholder="e.g., Creamy Tomato Pasta">
                    </div>
                    <div class="form-group">
                        <label for="recipe-image">Recipe Image</label>
                        <div class="image-upload-box" id="image-upload-box">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload or drag and drop</p>
                        </div>
                        <input type="file" id="recipe-image" name="image" accept="image/*" hidden>
                        <img id="image-preview" src="#" alt="Image Preview" style="display:none;"/>
                    </div>
                    <div class="form-group full-width">
                        <label for="recipe-description">Description</label>
                        <textarea id="recipe-description" name="description" rows="5" required placeholder="A short, enticing description of your dish. What makes it special?"></textarea>
                    </div>
                </div>
            </fieldset>

            <!-- Details -->
            <fieldset>
                <legend>2. Recipe Details</legend>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="recipe-prep-time">Prep Time (mins)</label>
                        <input type="number" id="recipe-prep-time" name="prep_time" placeholder="e.g., 15">
                    </div>
                    <div class="form-group">
                        <label for="recipe-cook-time">Cook Time (mins)</label>
                        <input type="number" id="recipe-cook-time" name="cook_time" placeholder="e.g., 20">
                    </div>
                    <div class="form-group">
                        <label for="recipe-servings">Servings</label>
                        <input type="number" id="recipe-servings" name="servings" placeholder="e.g., 4">
                    </div>
                    <div class="form-group">
                        <label for="recipe-difficulty">Difficulty</label>
                        <select id="recipe-difficulty" name="difficulty">
                            <option value="Easy">Easy</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Ingredients -->
            <fieldset>
                <legend>3. Ingredients</legend>
                <div class="form-group full-width">
                    <label for="recipe-ingredients">Ingredients (one per line). Use # for subheadings (e.g., # For the Dough).</label>
                    <textarea id="recipe-ingredients" name="ingredients_text" rows="8" required placeholder="# For the Dough&#10;2 cups flour&#10;1 tsp salt&#10;&#10;# For the Filling&#10;1 cup apple slices"></textarea>
                </div>
            </fieldset>

            <!-- Instructions -->
            <fieldset>
                <legend>4. Instructions</legend>
                <div class="form-group full-width">
                    <label for="recipe-instructions">Instructions (one step per line). Use # for subheadings (e.g., # Making the Sauce).</label>
                    <textarea id="recipe-instructions" name="instructions_text" rows="10" required placeholder="# Making the Sauce&#10;1. Heat oil in a pan.&#10;2. Add onions and garlic.&#10;&#10;# Assembling the Dish&#10;3. Layer the sauce and pasta."></textarea>
                </div>
            </fieldset>

            <!-- Categorization -->
            <fieldset>
                <legend>5. Categorization</legend>
                <div class="form-group">
                    <label for="recipe-tags">Tags (comma-separated)</label>
                    <input type="text" id="recipe-tags" name="tags" placeholder="e.g., vegetarian, quick, dinner, gluten-free">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_public" checked> Make this recipe public for the community
                    </label>
                </div>
            </fieldset>

            <div class="form-actions">
                <a href="community.php" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit Recipe</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

    <script src="global.js"></script>
    <script src="auth.js"></script>
    <script src="recipe_upload.js"></script>
</body>
</html>