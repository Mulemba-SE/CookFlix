document.addEventListener('DOMContentLoaded', () => {
    const recipeForm = document.getElementById('recipe-upload-form');

    // --- Form Elements ---
    const imageUploadBox = document.getElementById('image-upload-box');
    const recipeImageInput = document.getElementById('recipe-image');
    const imagePreview = document.getElementById('image-preview');

    imageUploadBox?.addEventListener('click', () => {
        recipeImageInput.click();
    });

    recipeImageInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // --- Stepper Logic ---
    const updateStepper = () => {
        const fieldsets = Array.from(recipeForm.querySelectorAll('fieldset'));
        let currentStep = 0;

        fieldsets.forEach((fieldset, index) => {
            const fieldsetTop = fieldset.getBoundingClientRect().top;
            if (fieldsetTop < window.innerHeight / 2) {
                currentStep = index + 1;
            }
        });

        for (let i = 1; i <= 5; i++) {
            const step = document.getElementById(`step-${i}`);
            const stepNumber = step.querySelector('.step-number');
            const stepTitle = step.querySelector('.step-title');
            if (i <= currentStep) {
                stepNumber.style.backgroundColor = 'var(--primary)';
                stepNumber.style.borderColor = 'var(--primary)';
                stepNumber.style.color = '#fff';
                stepTitle.style.color = 'var(--dark)';
            }
        }
    };

    window.addEventListener('scroll', updateStepper);
    updateStepper(); // Initial call

    recipeForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitButton = recipeForm.querySelector('button[type="submit"]');
        const errorDiv = document.getElementById('recipe-form-error');

        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';
        errorDiv.style.display = 'none'; // Hide previous errors

        const formData = new FormData(recipeForm);

        // --- Process Textareas into JSON for the backend ---

        // Process Ingredients: Split by line, then format for PHP backend.
        const ingredientsText = document.getElementById('recipe-ingredients').value;
        const ingredients = ingredientsText.split('\n')
            .map(line => {
                const trimmedLine = line.trim();
                if (trimmedLine.startsWith('#')) {
                    // This is a subheading. Create a special object for it.
                    return { type: 'subheading', text: trimmedLine.substring(1).trim() };
                } else if (trimmedLine) {
                    // This is a regular ingredient.
                    return { type: 'item', name: trimmedLine, quantity: '' };
                }
                return null;
            }).filter(item => item !== null);
        formData.set('ingredients', JSON.stringify(ingredients));
        formData.delete('ingredients_text'); // Remove original textarea value

        // Process Instructions: Split by line, then format for PHP backend.
        const instructionsText = document.getElementById('recipe-instructions').value;
        let stepCounter = 0;
        const steps = instructionsText.split('\n').map(line => {
            const trimmedLine = line.trim();
            if (trimmedLine.startsWith('#')) {
                return { type: 'subheading', text: trimmedLine.substring(1).trim() };
            } else if (trimmedLine) {
                stepCounter++;
                return { type: 'item', step_number: stepCounter, instruction: trimmedLine };
            }
            return null;
        }).filter(item => item !== null);
        formData.set('steps', JSON.stringify(steps));
        formData.delete('instructions_text'); // Remove original textarea value

        // Convert tags to a JSON array string
        const tags = formData.get('tags').split(',').map(tag => tag.trim()).filter(tag => tag);
        formData.set('tags', JSON.stringify(tags));

        // The PHP backend handles 'is_public' checkbox directly, no explicit conversion needed here.
        // No placeholders needed for meal_type or categories for the PHP handler.

        try {
            const response = await fetch('api/upload_recipe_handler.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.error || 'Failed to submit recipe.');
            }

            alert('Recipe submitted successfully! You will be redirected.');
            window.location.href = result.redirect_url; // Redirect to the newly created recipe page
        } catch (error) {
            errorDiv.textContent = error.message;
            errorDiv.style.display = 'block';
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Recipe';
        }
    });
});