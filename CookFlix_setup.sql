-- Step 1: Create Database (you already have this)
CREATE DATABASE IF NOT EXISTS CookFlix;
USE CookFlix;

-- Step 2: Create Tables (enhanced version)

-- USERS table (enhanced with additional fields for meal planning)
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    profile_picture_url VARCHAR(255),
    bio TEXT,
    dietary_preferences JSON, -- Store as JSON for flexibility (vegetarian, gluten-free, etc.)
    `role` ENUM('user', 'admin') DEFAULT 'user',
    default_servings INT DEFAULT 2,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- CATEGORIES table (keep as is - good for recipe organization)
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- RECIPES table (enhanced for meal planning)
CREATE TABLE Recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    prep_time INT, -- in minutes
    cook_time INT, -- in minutes
    total_time INT AS (prep_time + cook_time), -- computed column
    servings INT,
    difficulty ENUM('Easy', 'Medium', 'Hard'),
    image_url VARCHAR(255),
    user_id INT NOT NULL,
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack', 'dessert'), -- Added for meal planning
    tags JSON, -- Store additional tags as JSON for flexibility
    is_public BOOLEAN DEFAULT TRUE, -- Control recipe visibility
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_meal_type (meal_type),
    INDEX idx_difficulty (difficulty),
    INDEX idx_public (is_public)
);

-- INGREDIENTS table (keep as is - good design)
CREATE TABLE Ingredients (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    category VARCHAR(50), -- e.g., 'vegetable', 'protein', 'dairy'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category)
);

-- RECIPE_INGREDIENTS table (enhanced for shopping list generation)
CREATE TABLE Recipe_Ingredients (
    recipe_ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantity DECIMAL(8,2),
    measurement_unit VARCHAR(20),
    notes VARCHAR(100),
    preparation_notes VARCHAR(100), -- e.g., 'chopped', 'diced', 'sliced'
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES Ingredients(ingredient_id) ON DELETE CASCADE,
    UNIQUE KEY unique_recipe_ingredient (recipe_id, ingredient_id),
    INDEX idx_ingredient (ingredient_id)
);

-- RECIPE_STEPS table (keep as is - good design)
CREATE TABLE Recipe_Steps (
    step_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    step_number INT NOT NULL,
    instruction TEXT NOT NULL,
    image_url VARCHAR(255),
    timer_minutes INT, -- Optional: timer for this step
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    UNIQUE KEY unique_recipe_step (recipe_id, step_number)
);

-- RECIPE_CATEGORIES table (keep as is - good for organization)
CREATE TABLE Recipe_Categories (
    recipe_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (recipe_id, category_id),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE CASCADE
);

-- ========== NEW TABLES FOR MEAL PLANNING ==========

-- MEAL_PLANS table - Core meal planning functionality
CREATE TABLE Meal_Plans (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_date DATE NOT NULL, -- The date this meal is planned for
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack', 'dessert') NOT NULL,
    recipe_id INT NOT NULL, -- The recipe planned for this meal
    custom_servings INT, -- Override recipe's default servings
    notes TEXT, -- Custom notes for this meal
    is_completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_meal_slot (user_id, plan_date, meal_type),
    INDEX idx_plan_date (plan_date),
    INDEX idx_user_plan (user_id, plan_date)
);

-- SHOPPING_LISTS table - Generated from meal plans
CREATE TABLE Shopping_Lists (
    list_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    list_name VARCHAR(100) DEFAULT 'My Shopping List',
    for_dates VARCHAR(100), -- e.g., '2024-01-01 to 2024-01-07'
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_completed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, generated_at)
);

-- SHOPPING_ITEMS table - Individual items in shopping list
CREATE TABLE Shopping_Items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    list_id INT NOT NULL,
    ingredient_id INT, -- Can be NULL for custom items
    item_name VARCHAR(255) NOT NULL, -- Either ingredient name or custom item
    quantity DECIMAL(8,2),
    measurement_unit VARCHAR(20),
    category VARCHAR(50), -- For organizing shopping list
    is_purchased BOOLEAN DEFAULT FALSE,
    source_recipe_id INT, -- Which recipe this came from (optional)
    notes VARCHAR(100),
    FOREIGN KEY (list_id) REFERENCES Shopping_Lists(list_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES Ingredients(ingredient_id) ON DELETE SET NULL,
    FOREIGN KEY (source_recipe_id) REFERENCES Recipes(recipe_id) ON DELETE SET NULL,
    INDEX idx_category (category),
    INDEX idx_purchased (is_purchased)
);

-- MEAL_PLAN_TEMPLATES table - For saving common meal patterns
CREATE TABLE Meal_Plan_Templates (
    template_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    template_name VARCHAR(100) NOT NULL,
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- TEMPLATE_MEALS table - Meals in a template
CREATE TABLE Template_Meals (
    template_meal_id INT AUTO_INCREMENT PRIMARY KEY,
    template_id INT NOT NULL,
    day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
    meal_type ENUM('breakfast', 'lunch', 'dinner', 'snack', 'dessert'),
    recipe_id INT NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (template_id) REFERENCES Meal_Plan_Templates(template_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    UNIQUE KEY unique_template_meal (template_id, day_of_week, meal_type)
);

-- ========== EXISTING SOCIAL TABLES (keep as is) ==========

-- COMMENTS table
CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    INDEX idx_recipe_rating (recipe_id, rating)
);

-- FAVORITES table
CREATE TABLE Favorites (
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE,
    INDEX idx_user_favorites (user_id, created_at)
);

-- FOLLOWERS table
CREATE TABLE Followers (
    follower_id INT NOT NULL,
    following_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (follower_id, following_id),
    FOREIGN KEY (follower_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (following_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    CHECK (follower_id != following_id),
    INDEX idx_follower (follower_id),
    INDEX idx_following (following_id)
);

-- ========== NEW TABLES FOR COMMUNITY FEED ==========

-- COMMUNITY_POSTS table - For user-generated content in the community feed
CREATE TABLE Community_Posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT,
    image_url VARCHAR(255),
    video_url VARCHAR(255),
    recipe_id INT, -- Optional: link to a shared recipe
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE SET NULL,
    INDEX idx_user_posts (user_id, created_at)
);

-- POST_LIKES table - To track likes on community posts
CREATE TABLE Post_Likes (
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (post_id, user_id),
    FOREIGN KEY (post_id) REFERENCES Community_Posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- POST_COMMENTS table - For comments on community posts
CREATE TABLE Post_Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    parent_comment_id INT, -- For threaded replies
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Community_Posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_comment_id) REFERENCES Post_Comments(comment_id) ON DELETE CASCADE
);

-- CONTENT_REPORTS table - For user-submitted reports on posts or comments
CREATE TABLE Content_Reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    reporter_user_id INT NOT NULL,
    content_type ENUM('post', 'comment') NOT NULL,
    content_id INT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'reviewed', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    admin_notes TEXT,
    FOREIGN KEY (reporter_user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_status_type (status, content_type),
    UNIQUE KEY unique_report (reporter_user_id, content_type, content_id)
);

-- EVENTS table - For community events like workshops or demos
CREATE TABLE Events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    start_time DATETIME NOT NULL,
    end_time DATETIME,
    location VARCHAR(255), -- Can be a physical address or "Online"
    image_url VARCHAR(255),
    created_by_user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by_user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_start_time (start_time)
);

-- EVENT_ATTENDEES table - To track who is attending which event
CREATE TABLE Event_Attendees (
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES Events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- ========== SAMPLE DATA FOR TESTING ==========

-- Insert some sample categories
INSERT INTO Categories (name, description) VALUES
('Vegetarian', 'Plant-based recipes without meat'),
('Quick & Easy', 'Recipes that can be made in 30 minutes or less'),
('Family Favorites', 'Recipes loved by the whole family'),
('Healthy', 'Nutritious and balanced meals'),
('Comfort Food', 'Hearty and satisfying dishes');

-- Insert some common ingredients
INSERT INTO Ingredients (name, category) VALUES
('Chicken Breast', 'protein'),
('Rice', 'grains'),
('Tomato', 'vegetable'),
('Onion', 'vegetable'),
('Garlic', 'vegetable'),
('Olive Oil', 'fats'),
('Salt', 'seasoning'),
('Black Pepper', 'seasoning'),
('Pasta', 'grains'),
('Cheese', 'dairy');

-- Create a sample user
INSERT INTO Users (username, email, password_hash, dietary_preferences) VALUES
('testuser', 'test@example.com', '$2b$12$hashedpassword', '["vegetarian", "gluten-free"]');
