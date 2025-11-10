<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Planner - CookFlix</title>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="meal.css">
</head>
<body>
    <!-- Header -->
    <?php include '_header.php'; ?>
    <?php include 'auth_modal.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Meal Planner</h1>
            <p>Plan your meals for the week and generate a shopping list</p>
        </div>
    </section>

    <div class="container">
        <!-- Meal Planner Controls -->
        <div class="planner-controls">
            <div class="week-navigation">
                <button><i class="fas fa-chevron-left"></i></button>
                <span>June 11 - June 17, 2023</span>
                <button><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="planner-actions">
                <button class="btn btn-outline" style="background: white; color: var(--dark); border-color: #ddd;">
                    <i class="fas fa-print"></i> Print
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-list"></i> Generate Shopping List
                </button>
            </div>
        </div>

        <!-- Meal Planner Grid -->
        <div class="meal-planner">
            <!-- Time Headers -->
            <div class="time-header">Breakfast</div>
            <div class="time-header">Lunch</div>
            <div class="time-header">Dinner</div>
            
            <!-- Empty space for alignment -->
            <div></div>
            
            <!-- Monday Column -->
            <div class="day-column">
                <div class="day-header">Monday</div>
                <div class="meal-slot empty" data-day="monday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
              <div class="meal-slot empty" data-day="monday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>  
               
                <div class="meal-slot" data-day="monday" data-meal="dinner">
                    <div class="meal-content">
                        <h3 class="meal-title">Creamy Garlic Pasta</h3>
                        <div class="meal-meta">
                            <span>20 min</span>
                            <span>★ 4.8</span>
                        </div>
                        <p class="meal-description">Creamy, garlicky pasta with parmesan cheese and fresh herbs.</p>
                        <div class="meal-tags">
                            <span class="meal-tag">Vegetarian</span>
                            <span class="meal-tag">Italian</span>
                        </div>
                    </div>
                    <div class="meal-actions">
                        <button class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Replace</button>
                        <button class="btn" style="padding: 5px; background: none; color: #dc3545;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tuesday Column -->
            <div class="day-column">
                <div class="day-header">Tuesday</div>
                <div class="meal-slot empty" data-day="tuesday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="tuesday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>

                <div class="meal-slot empty" data-day="tuesday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Dinner</span>
                </div>
             
                     
            </div>

            <!-- Wednesday Column -->
            <div class="day-column">
                <div class="day-header">Wednesday</div>
                <div class="meal-slot empty" data-day="wednesday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="wednesday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>
                <div class="meal-slot empty" data-day="wednesday" data-meal="dinner">
                    <i class="fas fa-plus"></i>
                    <span>Add Dinner</span>
                </div>
            </div>

            <!-- Thursday Column -->
            <div class="day-column">
                <div class="day-header">Thursday</div>
                <div class="meal-slot empty" data-day="thursday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="thursday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>
                <div class="meal-slot empty" data-day="thursday" data-meal="dinner">
                    <i class="fas fa-plus"></i>
                    <span>Add Dinner</span>
                </div>
            </div>

            <!-- Friday Column -->
            <div class="day-column">
                <div class="day-header">Friday</div>
                <div class="meal-slot empty" data-day="friday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="friday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>
                <div class="meal-slot" data-day="friday" data-meal="dinner">
                    <div class="meal-content">
                        <h3 class="meal-title">Beef Tacos</h3>
                        <div class="meal-meta">
                            <span>30 min</span>
                            <span>★ 4.7</span>
                        </div>
                        <p class="meal-description">Seasoned ground beef in crispy taco shells with all your favorite toppings.</p>
                        <div class="meal-tags">
                            <span class="meal-tag">Mexican</span>
                            <span class="meal-tag">Family Friendly</span>
                        </div>
                    </div>
                    <div class="meal-actions">
                        <button class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Replace</button>
                        <button class="btn" style="padding: 5px; background: none; color: #dc3545;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Saturday Column -->
            <div class="day-column">
                <div class="day-header">Saturday</div>
                <div class="meal-slot empty" data-day="saturday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="saturday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>
                <div class="meal-slot empty" data-day="saturday" data-meal="dinner">
                    <i class="fas fa-plus"></i>
                    <span>Add Dinner</span>
                </div>
            </div>

            <!-- Sunday Column -->
            <div class="day-column">
                <div class="day-header">Sunday</div>
                <div class="meal-slot empty" data-day="sunday" data-meal="breakfast">
                    <i class="fas fa-plus"></i>
                    <span>Add Breakfast</span>
                </div>
                <div class="meal-slot empty" data-day="sunday" data-meal="lunch">
                    <i class="fas fa-plus"></i>
                    <span>Add Lunch</span>
                </div>
                <div class="meal-slot" data-day="sunday" data-meal="dinner">
                    <div class="meal-content">
                        <h3 class="meal-title">Vegetable Stir Fry</h3>
                        <div class="meal-meta">
                            <span>25 min</span>
                            <span>★ 4.5</span>
                        </div>
                        <p class="meal-description">Colorful vegetables stir-fried in a savory sauce.</p>
                        <div class="meal-tags">
                            <span class="meal-tag">Vegetarian</span>
                            <span class="meal-tag">Asian</span>
                        </div>
                    </div>
                    <div class="meal-actions">
                        <button class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Replace</button>
                        <button class="btn" style="padding: 5px; background: none; color: #dc3545;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe Suggestions -->
        <section class="suggestions-section">
            <h2 class="section-heading">Recipe Suggestions</h2>
            <div class="suggestions-grid">
                <!-- Suggestion 1 -->
                <div class="suggestion-card" draggable="true">
                    <div class="suggestion-img">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Mediterranean Salad">
                    </div>
                    <div class="suggestion-content">
                        <h3 class="suggestion-title">Mediterranean Salad</h3>
                        <div class="suggestion-meta">
                            <span>20 min</span>
                            <span>★ 4.6</span>
                        </div>
                        <div class="suggestion-tags">
                            <span class="meal-tag">Vegetarian</span>
                            <span class="meal-tag">Healthy</span>
                        </div>
                    </div>
                </div>

                <!-- Suggestion 2 -->
                <div class="suggestion-card" draggable="true">
                    <div class="suggestion-img">
                        <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Grilled Salmon">
                    </div>
                    <div class="suggestion-content">
                        <h3 class="suggestion-title">Grilled Salmon</h3>
                        <div class="suggestion-meta">
                            <span>25 min</span>
                            <span>★ 4.8</span>
                        </div>
                        <div class="suggestion-tags">
                            <span class="meal-tag">High Protein</span>
                            <span class="meal-tag">Omega-3</span>
                        </div>
                    </div>
                </div>

                <!-- Suggestion 3 -->
                <div class="suggestion-card" draggable="true">
                    <div class="suggestion-img">
                        <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Margherita Pizza">
                    </div>
                    <div class="suggestion-content">
                        <h3 class="suggestion-title">Margherita Pizza</h3>
                        <div class="suggestion-meta">
                            <span>35 min</span>
                            <span>★ 4.7</span>
                        </div>
                        <div class="suggestion-tags">
                            <span class="meal-tag">Vegetarian</span>
                            <span class="meal-tag">Italian</span>
                        </div>
                    </div>
                </div>

                <!-- Suggestion 4 -->
                <div class="suggestion-card" draggable="true">
                    <div class="suggestion-img">
                        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Beef Stir Fry">
                    </div>
                    <div class="suggestion-content">
                        <h3 class="suggestion-title">Beef Stir Fry</h3>
                        <div class="suggestion-meta">
                            <span>30 min</span>
                            <span>★ 4.5</span>
                        </div>
                        <div class="suggestion-tags">
                            <span class="meal-tag">High Protein</span>
                            <span class="meal-tag">Asian</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Shopping List -->
        <section class="shopping-list">
            <div class="list-header">
                <h2 class="section-heading">Shopping List</h2>
                <div class="list-actions">
                    <button class="btn btn-outline" style="background: white; color: var(--dark); border-color: #ddd;">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>
            </div>
            <ul class="list-items">
                <li class="list-item">
                    <input type="checkbox" id="item1">
                    <label for="item1">Avocados</label>
                    <span class="item-quantity">2 pieces</span>
                </li>
                <li class="list-item">
                    <input type="checkbox" id="item2">
                    <label for="item2">Cherry Tomatoes</label>
                    <span class="item-quantity">1 pack</span>
                </li>
                <li class="list-item">
                    <input type="checkbox" id="item3">
                    <label for="item3">Whole Grain Bread</label>
                    <span class="item-quantity">1 loaf</span>
                </li>
                <li class="list-item checked">
                    <input type="checkbox" id="item4" checked>
                    <label for="item4">Pasta</label>
                    <span class="item-quantity">500g</span>
                </li>
                <li class="list-item checked">
                    <input type="checkbox" id="item5" checked>
                    <label for="item5">Heavy Cream</label>
                    <span class="item-quantity">1 cup</span>
                </li>
                <li class="list-item">
                    <input type="checkbox" id="item6">
                    <label for="item6">Parmesan Cheese</label>
                    <span class="item-quantity">200g</span>
                </li>
                <li class="list-item">
                    <input type="checkbox" id="item7">
                    <label for="item7">Fresh Herbs</label>
                    <span class="item-quantity">1 bunch</span>
                </li>
                <li class="list-item">
                    <input type="checkbox" id="item8">
                    <label for="item8">Chicken Breast</label>
                    <span class="item-quantity">500g</span>
                </li>
            </ul>
        </section>
    </div>

    <!-- Footer -->
    <footer id="pageFooter"><?php include '_footer.html'; ?></footer>

    <script src="global.js"></script>
    <script src="auth.js"></script>
    <script>
         // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // This line should now work correctly
            const mealSlots = document.querySelectorAll('.meal-slot');
            console.log(`Found ${mealSlots.length} meal slots`);
            
            // Add meal functionality
            const emptySlots = document.querySelectorAll('.meal-slot.empty');
            emptySlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    const day = this.getAttribute('data-day');
                    const meal = this.getAttribute('data-meal');
                    alert(`Add a recipe to ${meal} on ${day}`);
                });
            });
            
            // Delete meal functionality
            const deleteButtons = document.querySelectorAll('.meal-actions button:last-child');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const mealSlot = this.closest('.meal-slot');
                    mealSlot.innerHTML = `
                        <i class="fas fa-plus"></i>
                        <span>Add ${mealSlot.getAttribute('data-meal')}</span>
                    `;
                    mealSlot.classList.add('empty');
                });
            });
            
            // Shopping list item check functionality
            const listItems = document.querySelectorAll('.list-item input[type="checkbox"]');
            listItems.forEach(item => {
                item.addEventListener('change', function() {
                    const listItem = this.closest('.list-item');
                    if (this.checked) {
                        listItem.classList.add('checked');
                    } else {
                        listItem.classList.remove('checked');
                    }
                });
            });
        });
    </script>
    </body>
    </html>
       