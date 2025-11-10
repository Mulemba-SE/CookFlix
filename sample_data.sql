USE CookFlix;

-- Insert categories
INSERT INTO Categories (name, description) VALUES
('Dessert', 'Sweet treats and baked goods'),
('Vegetarian', 'Plant-based recipes without meat'),
('Italian', 'Traditional Italian cuisine'),
('Quick & Easy', 'Recipes that can be made in 30 minutes or less'),
('Healthy', 'Nutritious and balanced meals'),
('Gluten-Free', 'Recipes without gluten ingredients');

-- Insert users
INSERT INTO Users (username, email, password_hash, bio) VALUES
('chef_john', 'john@email.com', '$2b$10$exampleHash1', 'Professional chef passionate about sharing recipes'),
('baking_lover', 'sarah@email.com', '$2b$10$exampleHash2', 'Home baker specializing in desserts'),
('health_fanatic', 'mike@email.com', '$2b$10$exampleHash3', 'Focused on nutritious and delicious meals');

-- Insert recipes
INSERT INTO Recipes (title, description, prep_time, cook_time, servings, difficulty, user_id) VALUES
('Classic Chocolate Brownies', 'Rich, fudgy chocolate brownies with a crackly top', 15, 30, 12, 'Easy', 1),
('Vegetable Stir Fry', 'Quick and healthy vegetable stir fry with tofu', 20, 15, 4, 'Easy', 3),
('Homemade Pizza', 'Traditional Italian pizza with fresh ingredients', 30, 20, 4, 'Medium', 2);

-- Insert ingredients
INSERT INTO Ingredients (name) VALUES
('All-purpose flour'), ('Granulated sugar'), ('Cocoa powder'), ('Butter'), ('Eggs'),
('Vanilla extract'), ('Salt'), ('Chocolate chips'), ('Bell peppers'), ('Broccoli'),
('Carrots'), ('Tofu'), ('Soy sauce'), ('Pizza dough'), ('Tomato sauce'), ('Mozzarella cheese');

-- Link ingredients to recipes
INSERT INTO Recipe_Ingredients (recipe_id, ingredient_id, quantity, measurement_unit) VALUES
-- Brownies ingredients
(1, 1, 1, 'cup'), (1, 2, 1.5, 'cups'), (1, 3, 0.75, 'cup'), (1, 4, 0.5, 'cup'),
(1, 5, 2, NULL), (1, 6, 1, 'tsp'), (1, 7, 0.5, 'tsp'), (1, 8, 1, 'cup'),
-- Stir Fry ingredients
(2, 9, 2, NULL), (2, 10, 1, 'cup'), (2, 11, 2, NULL), (2, 12, 1, 'block'),
(2, 13, 3, 'tbsp'), (2, 7, 0.5, 'tsp');

-- Add recipe steps
INSERT INTO Recipe_Steps (recipe_id, step_number, instruction) VALUES
(1, 1, 'Preheat oven to 350°F (175°C) and line an 8x8 inch baking pan with parchment paper.'),
(1, 2, 'Melt butter and mix with sugar until well combined.'),
(1, 3, 'Add eggs and vanilla extract, mix thoroughly.'),
(1, 4, 'Sift in flour, cocoa powder, and salt. Mix until just combined.'),
(1, 5, 'Fold in chocolate chips and pour into prepared pan.'),
(1, 6, 'Bake for 25-30 minutes until a toothpick comes out with moist crumbs.');

-- Categorize recipes
INSERT INTO Recipe_Categories (recipe_id, category_id) VALUES
(1, 1), (1, 4),  -- Brownies: Dessert, Quick & Easy
(2, 2), (2, 4), (2, 5);  -- Stir Fry: Vegetarian, Quick & Easy, Healthy