-- Make sure you are using the correct database
USE cookflix_db;

-- ========== FULL RECIPE DATA (Cleaned and Consolidated) ==========

-- 1. Create the authors (users) for the recipes if they don't exist.
-- Note: Passwords are 'password123' hashed.
INSERT INTO `users` (username, email, password_hash, bio, location)
VALUES
    ('MariaCooks', 'maria@cookflix.com', '$2y$10$E.qA8L4qJ0i3jK5L6n7o8u/AbCdEfGhIjKlMnOpQrStUvWxYzAbCd', 'Food enthusiast & recipe developer', 'Nairobi, Kenya'),
    ('HealthyEats', 'healthy@cookflix.com', '$2y$10$F.rB9M5sK1j4hL6n8p9u/BcDeFgHiJkLmNoPqRsTuVwXyZaBcDe', 'Lover of fresh and nutritious meals.', 'Mombasa, Kenya'),
    ('ChefJohn', 'john@cookflix.com', '$2y$10$G.sC7N6tL2k5iM7o9q0v/CdEfGhIjKlMnOpQrStUvWxYzAbCdEf', 'Professional chef sharing my secrets.', 'Kisumu, Kenya'),
    ('DessertQueen', 'dessert@cookflix.com', '$2y$10$H.tD8O7uM3l6jN8p0r1w/DeFgHiJkLmNoPqRsTuVwXyZaBcDeFg', 'All things sweet and delicious!', 'Nakuru, Kenya'),
    ('SortedK', 'sorted@cookflix.com', '$2y$10$I.uE9P8vN4m7kO9q1s2x/EfGhIjKlMnOpQrStUvWxYzAbCdEfGh', 'Quick and easy meals for busy people.', 'Eldoret, Kenya'),
    ('ChefMwendwa', 'mwendwa@cookflix.com', '$2y$10$J.vF0Q9wO5n8lP0r2t3y/FgHiJkLmNoPqRsTuVwXyZaBcDeFgHi', 'Bringing Kenyan flavors to the world.', 'Nairobi, Kenya'),
    ('Evans Mulemba', 'evans@cookflix.com', '$2y$10$K.wG1R0xP6o9mQ1s3u4z/GhIjKlMnOpQrStUvWxYzAbCdEfGhI', 'Exploring traditional and modern cuisine.', 'Nairobi, Kenya'),
    ('JKitchens', 'jkitchens@cookflix.com', '$2y$10$L.xH2S1yQ7p0nR2t4v5A/HiJkLmNoPqRsTuVwXyZaBcDeFgHiJ', 'Home cooking with love.', 'Nyeri, Kenya'),
    ('Mary Brooks', 'mary@cookflix.com', '$2y$10$M.yI3T2zR8q1oS3u5w6B/JkLmNoPqRsTuVwXyZaBcDeFgHiJk', 'Family recipes passed down through generations.', 'Thika, Kenya')
ON DUPLICATE KEY UPDATE username=username; -- Do nothing if user already exists

-- 2. Insert the recipes
INSERT INTO `recipes` (title, description, author_id, prep_time, cook_time, servings, difficulty, image_url, page_url, is_featured)
VALUES
(
    'Creamy Garlic Pasta', 'Creamy, garlicky pasta with parmesan cheese and fresh herbs. Ready in 20 minutes!',
    (SELECT user_id FROM users WHERE username = 'MariaCooks'), 5, 15, 4, 'Easy', 'images/download (3).jpeg', 'pasta.htm', 1
),
(
    'Avocado Quinoa Salad', 'A refreshing and nutritious salad with quinoa, avocado, and a lime dressing.',
    (SELECT user_id FROM users WHERE username = 'HealthyEats'), 10, 15, 4, 'Easy', 'images/images (2).jpeg', 'quinoa.htm', 0
),
(
    'Herb Roasted Chicken', 'Juicy roasted chicken with fresh herbs and lemon. Perfect for Sunday dinner!',
    (SELECT user_id FROM users WHERE username = 'ChefJohn'), 15, 75, 4, 'Medium', 'images/images.jpeg', 'chicken.htm', 1
),
(
    'Chocolate Brownies', 'Fudgy, rich chocolate brownies with a crackly top. The perfect dessert!',
    (SELECT user_id FROM users WHERE username = 'DessertQueen'), 15, 35, 16, 'Easy', 'images/download.jpeg', 'brownies.htm', 0
),
(
    'Vegetable Stir Fry', 'Colorful vegetables stir-fried in a savory sauce. Quick, healthy, and delicious!',
    (SELECT user_id FROM users WHERE username = 'SortedK'), 10, 10, 4, 'Easy', 'images/download (1).jpeg', 'stirfry.htm', 0
),
(
    'Beef Tacos', 'Seasoned ground beef in crispy taco shells with all your favorite toppings.',
    (SELECT user_id FROM users WHERE username = 'SortedK'), 15, 20, 3, 'Easy', 'images/download (2).jpeg', 'taco.htm', 0
),
(
    'Beef Pilau with Kachubari', 'Beef Pilau with a tenderlizing aroma, served with pilau. Ready in 30 minutes.',
    (SELECT user_id FROM users WHERE username = 'ChefMwendwa'), 10, 40, 5, 'Medium', 'images/PSX_20250918_134029.jpg', 'pilau.htm', 0
),
(
    'Mothokoi Avocado', 'Traditional hearty dish, with a flavorful and fiber-rich companion. Served with creamy Avocado slices.',
    (SELECT user_id FROM users WHERE username = 'Evans Mulemba'), 20, 120, 6, 'Medium', 'images/PSX_20250918_135352.jpg', 'muthokoi.htm', 0
),
(
    'Mukimo with Stewed Peas', 'It\'s a hearty, flavorful mash made from a unique combination of arrow roots, potatoes, green vegetables and peas.',
    (SELECT user_id FROM users WHERE username = 'Evans Mulemba'), 20, 45, 5, 'Medium', 'images/PSX_20250918_135720.jpg', 'mukimo.htm', 1
);

-- 3. Insert all unique tags
INSERT INTO `tags` (name) VALUES
    ('Pasta'), ('Italian'), ('Quick'), ('Salad'), ('Healthy'), ('Vegan'), ('Chicken'), ('Dinner'),
    ('Comfort Food'), ('Dessert'), ('Chocolate'), ('Sweet'), ('Vegetarian'), ('Asian'), ('Mexican'),
    ('Beef'), ('Family Friendly'), ('Traditional'), ('Kenyan'), ('Nutritious'), ('Home-cooking'),
    ('Kikuyu'), ('Stewed peas'), ('Creamy'), ('Sauce'), ('Pilau'), ('Muthokoi'), ('Mukimo')
ON DUPLICATE KEY UPDATE name=name;

-- 4. Link recipes to their tags
INSERT INTO `recipe_tags` (recipe_id, tag_id)
VALUES
    -- Creamy Garlic Pasta
    ((SELECT recipe_id FROM recipes WHERE title = 'Creamy Garlic Pasta'), (SELECT tag_id FROM tags WHERE name = 'Pasta')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Creamy Garlic Pasta'), (SELECT tag_id FROM tags WHERE name = 'Italian')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Creamy Garlic Pasta'), (SELECT tag_id FROM tags WHERE name = 'Quick')),
    -- Avocado Quinoa Salad
    ((SELECT recipe_id FROM recipes WHERE title = 'Avocado Quinoa Salad'), (SELECT tag_id FROM tags WHERE name = 'Salad')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Avocado Quinoa Salad'), (SELECT tag_id FROM tags WHERE name = 'Healthy')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Avocado Quinoa Salad'), (SELECT tag_id FROM tags WHERE name = 'Vegan')),
    -- Herb Roasted Chicken
    ((SELECT recipe_id FROM recipes WHERE title = 'Herb Roasted Chicken'), (SELECT tag_id FROM tags WHERE name = 'Chicken')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Herb Roasted Chicken'), (SELECT tag_id FROM tags WHERE name = 'Dinner')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Herb Roasted Chicken'), (SELECT tag_id FROM tags WHERE name = 'Comfort Food')),
    -- Chocolate Brownies
    ((SELECT recipe_id FROM recipes WHERE title = 'Chocolate Brownies'), (SELECT tag_id FROM tags WHERE name = 'Dessert')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Chocolate Brownies'), (SELECT tag_id FROM tags WHERE name = 'Chocolate')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Chocolate Brownies'), (SELECT tag_id FROM tags WHERE name = 'Sweet')),
    -- Vegetable Stir Fry
    ((SELECT recipe_id FROM recipes WHERE title = 'Vegetable Stir Fry'), (SELECT tag_id FROM tags WHERE name = 'Vegetarian')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Vegetable Stir Fry'), (SELECT tag_id FROM tags WHERE name = 'Asian')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Vegetable Stir Fry'), (SELECT tag_id FROM tags WHERE name = 'Quick')),
    -- Beef Tacos
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Tacos'), (SELECT tag_id FROM tags WHERE name = 'Mexican')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Tacos'), (SELECT tag_id FROM tags WHERE name = 'Beef')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Tacos'), (SELECT tag_id FROM tags WHERE name = 'Family Friendly')),
    -- Beef Pilau with Kachubari
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Pilau with Kachubari'), (SELECT tag_id FROM tags WHERE name = 'Beef')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Pilau with Kachubari'), (SELECT tag_id FROM tags WHERE name = 'Kenyan')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Pilau with Kachubari'), (SELECT tag_id FROM tags WHERE name = 'Pilau')),
    -- Mothokoi Avocado
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT tag_id FROM tags WHERE name = 'Muthokoi')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT tag_id FROM tags WHERE name = 'Kenyan')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT tag_id FROM tags WHERE name = 'Traditional')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT tag_id FROM tags WHERE name = 'Kenyan')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT tag_id FROM tags WHERE name = 'Nutritious')),
    -- Mukimo with Stewed Peas
    ((SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas'), (SELECT tag_id FROM tags WHERE name = 'Home-cooking')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas'), (SELECT tag_id FROM tags WHERE name = 'Kikuyu')),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas'), (SELECT tag_id FROM tags WHERE name = 'Stewed peas'));
    ((SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas'), (SELECT tag_id FROM tags WHERE name = 'Mukimo'));

-- 5. Add sample comments to represent the ratings on the cards
INSERT INTO `comments` (recipe_id, user_id, rating, content)
VALUES
    ((SELECT recipe_id FROM recipes WHERE title = 'Creamy Garlic Pasta'), (SELECT user_id FROM users WHERE username = 'HealthyEats'), 5, 'So creamy and delicious! A new weeknight favorite.'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Avocado Quinoa Salad'), (SELECT user_id FROM users WHERE username = 'MariaCooks'), 4, 'Very refreshing. I added some feta cheese.'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Herb Roasted Chicken'), (SELECT user_id FROM users WHERE username = 'DessertQueen'), 5, 'The chicken was incredibly juicy. Perfect recipe!'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Chocolate Brownies'), (SELECT user_id FROM users WHERE username = 'ChefJohn'), 5, 'Perfectly fudgy. Best brownie recipe I have tried.'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Vegetable Stir Fry'), (SELECT user_id FROM users WHERE username = 'HealthyEats'), 4, 'Great way to use up leftover veggies. The sauce is fantastic.'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Tacos'), (SELECT user_id FROM users WHERE username = 'MariaCooks'), 5, 'Taco night was a huge hit thanks to this recipe!'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Beef Pilau with Kachubari'), (SELECT user_id FROM users WHERE username = 'Evans Mulemba'), 4, 'Authentic flavor, just like my grandmother used to make.'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mothokoi Avocado'), (SELECT user_id FROM users WHERE username = 'ChefMwendwa'), 5, 'So hearty and comforting. The avocado is a must!'),
    ((SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas'), (SELECT user_id FROM users WHERE username = 'SortedK'), 5, 'A true taste of Kenya. Absolutely wonderful.');

-- 6. Insert all unique ingredients from all recipe pages
INSERT INTO `ingredients` (name) VALUES
    ('Fettuccine or Linguine'), ('Olive Oil'), ('Garlic'), ('Butter'), ('Heavy Cream'), ('Parmesan Cheese'), ('Salt'), ('Black Pepper'), ('Fresh Parsley'), ('Red Pepper Flakes'),
    ('Quinoa'), ('Water'), ('Vegetable Broth'), ('Avocado'), ('Cherry Tomatoes'), ('Cucumber'), ('Red Onion'), ('Cilantro'), ('Black Beans'), ('Corn Kernels'), ('Lime Juice'), ('Cumin'),
    ('Whole Chicken'), ('Fresh Rosemary'), ('Fresh Thyme'), ('Fresh Sage'), ('Lemon'), ('Onion'),
    ('Unsalted Butter'), ('Granulated Sugar'), ('Light Brown Sugar'), ('Eggs'), ('Egg Yolk'), ('Unsweetened Cocoa Powder'), ('Vanilla Extract'), ('All-purpose Flour'), ('Semi-sweet Chocolate'),
    ('Soy Sauce'), ('Maple Syrup'), ('Rice Vinegar'), ('Toasted Sesame Oil'), ('Cornstarch'), ('Fresh Ginger'), ('Neutral Oil'), ('Broccoli'), ('Carrots'), ('Bell Peppers'), ('Snap Peas'), ('Zucchini'), ('Mushrooms'), ('Cabbage'), ('Tofu'),
    ('Chili Powder'), ('Paprika'), ('Garlic Powder'), ('Onion Powder'), ('Dried Oregano'), ('Cayenne Pepper'), ('Ground Beef'), ('Tomato Sauce'),
    ('Basmati Rice'), ('Beef'), ('Tomatoes'), ('Pilau Masala'), ('Turmeric Powder'), ('Bay Leaves'), ('Beef Stock'), ('Ghee'),
    ('Muthokoi (dehulled maize)'), ('Dried Beans'), ('Cooking Oil'),
    ('Potatoes'), ('Pumpkin Leaves (terere)'), ('Spinach'), ('Maize (corn)'), ('Kidney Beans'), ('Tomato Paste')
ON DUPLICATE KEY UPDATE name=name;

-- 7. Add ingredients and steps for each recipe

-- == Creamy Garlic Pasta ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Creamy Garlic Pasta');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Fettuccine or Linguine'), '8 oz (225g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Olive Oil'), '2 tablespoons'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Garlic'), '4 cloves, minced'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Butter'), '2 tablespoons'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Heavy Cream'), '1 cup'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Parmesan Cheese'), '1/2 cup, grated'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Salt'), 'to taste'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Black Pepper'), 'to taste'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Fresh Parsley'), '1/4 cup, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Red Pepper Flakes'), '1 teaspoon (optional)');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'Cook the pasta according to package instructions in a large pot of salted boiling water until al dente. Reserve 1/2 cup of pasta water before draining.'),
    (@recipe_id, 2, 'While the pasta is cooking, heat olive oil in a large skillet over medium heat. Add minced garlic and sauté for 1-2 minutes until fragrant but not browned.'),
    (@recipe_id, 3, 'Add butter to the skillet and let it melt. Pour in the heavy cream and bring to a gentle simmer. Cook for 2-3 minutes, stirring occasionally.'),
    (@recipe_id, 4, 'Reduce heat to low and gradually whisk in the parmesan cheese until the sauce is smooth and creamy. Season with salt and pepper to taste.'),
    (@recipe_id, 5, 'Add the drained pasta to the skillet, tossing to coat evenly in the sauce. If the sauce is too thick, add a splash of the reserved pasta water to reach your desired consistency.'),
    (@recipe_id, 6, 'Stir in the chopped parsley and red pepper flakes (if using). Serve immediately with extra parmesan cheese on top.');

-- == Avocado Quinoa Salad ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Avocado Quinoa Salad');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Quinoa'), '1 cup, uncooked'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Water'), '2 cups'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Avocado'), '2, ripe but firm'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Cherry Tomatoes'), '1 cup, halved'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Cucumber'), '1 cup, diced'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Red Onion'), '1/2 cup, finely diced'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Cilantro'), '1/3 cup, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Lime Juice'), '1/4 cup'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Olive Oil'), '3 tbsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Cumin'), '1/2 tsp');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'Cook the Quinoa: Rinse 1 cup of quinoa thoroughly. In a saucepan, combine rinsed quinoa with 2 cups of water. Bring to a boil, then reduce heat, cover, and simmer for 15 minutes. Let sit covered for 5 minutes, then fluff and cool.'),
    (@recipe_id, 2, 'Prepare the Dressing: In a small bowl, whisk together lime juice, olive oil, minced garlic, cumin, salt, and pepper.'),
    (@recipe_id, 3, 'Chop Ingredients: Dice avocados, halve cherry tomatoes, dice cucumber, and finely chop red onion and cilantro.'),
    (@recipe_id, 4, 'Combine Everything: In a large bowl, mix the cooled quinoa, avocado, tomatoes, cucumber, red onion, and cilantro. Pour the dressing over the salad and gently toss to combine.'),
    (@recipe_id, 5, 'Serve immediately for the best texture. Garnish with extra cilantro or lime wedges.');

-- == Herb Roasted Chicken ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Herb Roasted Chicken');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Whole Chicken'), '1 (4-5 lb)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Unsalted Butter'), '4 tbsp, softened'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Fresh Rosemary'), '2 tbsp, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Garlic'), '4-6 cloves, minced'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Salt'), '1 tsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Black Pepper'), '1 tsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Lemon'), '1, halved'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Onion'), '1 small, quartered');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'Prep the Chicken: Preheat oven to 375°F (190°C). Pat the chicken completely dry with paper towels. Season the cavity with salt and pepper.'),
    (@recipe_id, 2, 'Herb Butter: In a bowl, mix softened butter, chopped herbs, minced garlic, salt, and pepper. Rub ⅔ of the herb butter under the skin over the breast and thighs. Spread the rest over the outside.'),
    (@recipe_id, 3, 'Aromatics: Stuff the cavity with lemon, onion, and a halved garlic head. Truss the legs with kitchen twine.'),
    (@recipe_id, 4, 'Roasting: Place chicken on a rack in a roasting pan. Roast for 1 to 1.5 hours, basting occasionally. Chicken is done when a thermometer in the thigh reads 165°F (74°C).'),
    (@recipe_id, 5, 'Resting: Tent with foil and let rest for 15-20 minutes before carving.');

-- == Chocolate Brownies ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Chocolate Brownies');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Unsalted Butter'), '1/2 cup (115g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Granulated Sugar'), '1 cup (200g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Eggs'), '2 large'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Unsweetened Cocoa Powder'), '3/4 cup (75g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'All-purpose Flour'), '1/2 cup (65g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Semi-sweet Chocolate'), '4 oz (115g), chopped');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'Preheat oven to 350°F (175°C). Line and grease an 8x8 inch baking pan. Melt butter and chopped chocolate together until smooth.'),
    (@recipe_id, 2, 'To the cooled chocolate-butter mixture, add sugars and whisk vigorously for 1 minute. Add eggs and vanilla, and whisk for another 1-2 minutes until thick and shiny.'),
    (@recipe_id, 3, 'Sift cocoa powder, flour, and salt into the bowl. Gently fold until just combined. Do not overmix.'),
    (@recipe_id, 4, 'Fold in the remaining chopped chocolate. Spread the thick batter into your prepared pan.'),
    (@recipe_id, 5, 'Bake for 30-35 minutes. A toothpick inserted should come out with moist crumbs. Cool completely before cutting.');

-- == Beef Tacos ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Beef Tacos');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Chili Powder'), '1 tbsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Ground Cumin'), '1.5 tsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Olive Oil'), '1 tbsp'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Onion'), '1 medium, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Ground Beef'), '1 lb (450g)'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Tomato Sauce'), '1/2 cup');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'In a small bowl, whisk together all the taco seasoning ingredients.'),
    (@recipe_id, 2, 'Heat oil in a large skillet. Add onion and cook until soft. Add garlic and cook for 30 seconds.'),
    (@recipe_id, 3, 'Increase heat, add ground beef, and cook until browned. Drain excess fat.'),
    (@recipe_id, 4, 'Sprinkle seasoning over beef and stir for 1 minute. Pour in tomato sauce and broth/water.'),
    (@recipe_id, 5, 'Reduce heat and simmer for 5-10 minutes until thick. Serve in warm taco shells with your favorite toppings.');

-- == Mukimo with Stewed Peas ==
SET @recipe_id = (SELECT recipe_id FROM recipes WHERE title = 'Mukimo with Stewed Peas');
INSERT INTO `recipe_ingredients` (recipe_id, ingredient_id, quantity) VALUES
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Potatoes'), '4 large, cubed'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Peas'), '1 cup'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Pumpkin Leaves (terere)'), '2 cups, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Maize (corn)'), '1 cup, pre-boiled'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Red Onion'), '1 large, chopped'),
    (@recipe_id, (SELECT ingredient_id FROM ingredients WHERE name = 'Kidney Beans'), '2 cups, pre-boiled');
INSERT INTO `recipe_steps` (recipe_id, step_number, instruction) VALUES
    (@recipe_id, 1, 'Make the Mukimo: In a large pot, boil potatoes and maize until tender. Add pumpkin leaves and peas in the last 5 minutes.'),
    (@recipe_id, 2, 'Drain the water, reserving 1 cup. Add half the onion, butter, and salt. Mash vigorously until you have a textured mash, adding reserved water if too dry.'),
    (@recipe_id, 3, 'Make the Stew: In a separate pan, sauté the other half of the onion, garlic, and ginger. Add chopped tomato and tomato paste, cooking until a thick paste forms.'),
    (@recipe_id, 4, 'Stir in spices, then add beans/peas and vegetable stock. Simmer for 10-15 minutes until thickened.'),
    (@recipe_id, 5, 'Serve the warm Mukimo alongside the hot stewed peas.');