USE CookFlix;

-- View all recipes with their authors
SELECT r.recipe_id, r.title, u.username as author, r.difficulty
FROM Recipes r
JOIN Users u ON r.user_id = u.user_id;

-- View ingredients for a specific recipe
SELECT r.title, i.name, ri.quantity, ri.measurement_unit
FROM Recipes r
JOIN Recipe_Ingredients ri ON r.recipe_id = ri.recipe_id
JOIN Ingredients i ON ri.ingredient_id = i.ingredient_id
WHERE r.recipe_id = 1;

-- View recipes by category
SELECT c.name as category, r.title, r.description
FROM Recipes r
JOIN Recipe_Categories rc ON r.recipe_id = rc.recipe_id
JOIN Categories c ON rc.category_id = c.category_id
WHERE c.name = 'Dessert';