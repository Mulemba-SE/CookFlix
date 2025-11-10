<!-- Recipe Upload Modal -->
<div id="recipe-upload-modal" class="modal">
    <div class="modal-content large">
        <button class="close-modal" id="close-recipe-modal">&times;</button>
        <h2>Share Your Recipe</h2>
        <p>Fill out the details below to share your creation with the community.</p>

        <form id="recipe-upload-form" enctype="multipart/form-data">
            <div id="recipe-form-error" class="error-message" style="display:none; margin-bottom: 15px;"></div>

            <!-- Basic Info -->
            <fieldset>
                <legend>Basic Information</legend>
                <div class="form-group">
                    <label for="recipe-title">Recipe Title</label>
                    <input type="text" id="recipe-title" name="title" required placeholder="e.g., Creamy Tomato Pasta">
                </div>
                <div class="form-group">
                    <label for="recipe-description">Description</label>
                    <textarea id="recipe-description" name="description" rows="3" required placeholder="A short, enticing description of your dish."></textarea>
                </div>
                <div class="form-group">
                    <label for="recipe-image">Recipe Image</label>
                    <input type="file" id="recipe-image" name="image" accept="image/*">
                </div>
            </fieldset>

            <!-- Details -->
            <fieldset>
                <legend>Details</legend>
                <div class="form-row">
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
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Ingredients -->
            <fieldset>
                <legend>Ingredients</legend>
                <div id="ingredients-container">
                    <!-- Ingredient inputs will be added here by JS -->
                    <div class="ingredient-row">
                        <input type="text" name="ingredients[0][name]" placeholder="Ingredient Name" required>
                        <input type="text" name="ingredients[0][quantity]" placeholder="Quantity (e.g., 1 cup)">
                    </div>
                </div>
                <button type="button" id="add-ingredient-btn" class="btn btn-outline small">
                    <i class="fas fa-plus"></i> Add Ingredient
                </button>
            </fieldset>

            <!-- Instructions -->
            <fieldset>
                <legend>Instructions</legend>
                <div id="steps-container">
                    <!-- Step inputs will be added here by JS -->
                    <div class="step-row">
                        <span class="step-number">1.</span>
                        <textarea name="steps[0][instruction]" rows="2" placeholder="Describe this step..." required></textarea>
                    </div>
                </div>
                <button type="button" id="add-step-btn" class="btn btn-outline small">
                    <i class="fas fa-plus"></i> Add Step
                </button>
            </fieldset>

            <!-- Tags & Visibility -->
            <fieldset>
                <legend>Categorization</legend>
                <div class="form-group">
                    <label for="recipe-tags">Tags (comma-separated)</label>
                    <input type="text" id="recipe-tags" name="tags" placeholder="e.g., vegetarian, quick, dinner">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_public" checked> Make this recipe public
                    </label>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="button" id="cancel-recipe-upload" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Recipe</button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-content.large { max-width: 800px; }
    fieldset { border: 1px solid #eee; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
    legend { font-weight: bold; color: var(--primary-color); padding: 0 10px; }
    .form-row { display: flex; gap: 15px; }
    .form-row .form-group { flex: 1; }
    .ingredient-row, .step-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .step-number { font-weight: bold; }
    .btn.small { padding: 5px 10px; font-size: 0.9em; }
</style>