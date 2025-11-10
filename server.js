console.log('🆕 COOKFLIX MEAL PLANNER SERVER.JS LOADED');

const express = require('express');
const cors = require('cors');
const mysql = require('mysql2/promise');
const bcrypt = require('bcryptjs');
const multer = require('multer');
const path = require('path');
const fs = require('fs');
const jwt = require('jsonwebtoken');

// Load environment variables from .env file
require('dotenv').config();

const app = express();
const port = process.env.PORT || 5000;
const JWT_SECRET = process.env.JWT_SECRET || 'cookflix-secret-key-change-in-production';

// ========== MIDDLEWARE SETUP ==========
app.use(express.json());
app.use(cors({
    origin: true,
    credentials: true
}));

// MySQL connection pool - UPDATED FOR YOUR SCHEMA
const pool = mysql.createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    connectionLimit: 10,
    waitForConnections: true,
    queueLimit: 0
});

// JWT Authentication Middleware
const authenticateToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];

    if (!token) {
        return res.status(401).json({
            success: false,
            error: 'Access token required'
        });
    }

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) {
            return res.status(403).json({
                success: false,
                error: 'Invalid or expired token'
            });
        }
        req.user = user;
        next();
    });
};

// Admin check middleware
const isAdmin = (req, res, next) => {
    // This middleware must run AFTER authenticateToken, which adds `req.user`
    if (req.user && req.user.role === 'admin') {
        next(); // User is an admin, proceed to the next middleware/handler
    } else {
        // User is not an admin or not logged in properly
        res.status(403).json({
            success: false,
            error: 'Forbidden: Access is restricted to administrators.'
        });
    }
};


// Configure multer for file uploads
const avatarStorage = multer.diskStorage({
    destination: (req, file, cb) => {
        const uploadDir = 'uploads/avatars/';
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir, { recursive: true });
        }
        cb(null, uploadDir);
    },
    filename: (req, file, cb) => {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, 'avatar-' + uniqueSuffix + path.extname(file.originalname));
    }
});

const eventStorage = multer.diskStorage({
    destination: (req, file, cb) => {
        const uploadDir = 'uploads/events/';
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir, { recursive: true });
        }
        cb(null, uploadDir);
    },
    filename: (req, file, cb) => {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, 'event-' + uniqueSuffix + path.extname(file.originalname));
    }
});

const recipeStorage = multer.diskStorage({
    destination: (req, file, cb) => {
        const uploadDir = 'uploads/recipes/';
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir, { recursive: true });
        }
        cb(null, uploadDir);
    },
    filename: (req, file, cb) => {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, 'recipe-' + uniqueSuffix + path.extname(file.originalname));
    }
});

const fileFilter = (req, file, cb) => {
    if (file.mimetype.startsWith('image/')) {
        cb(null, true);
    } else {
        cb(new Error('Only image files are allowed!'), false);
    }
};

const uploadAvatar = multer({
    storage: avatarStorage,
    fileFilter: fileFilter,
    limits: { fileSize: 5 * 1024 * 1024 }
});

const uploadRecipe = multer({
    storage: recipeStorage,
    fileFilter: fileFilter,
    limits: { fileSize: 5 * 1024 * 1024 }
});

const uploadEvent = multer({
    storage: eventStorage,
    fileFilter: fileFilter,
    limits: { fileSize: 5 * 1024 * 1024 }
});

// Serve static files
app.use('/uploads', express.static('uploads'));

// Request logging middleware
app.use((req, res, next) => {
    const start = Date.now();
    res.on('finish', () => {
        const duration = Date.now() - start;
        const status = res.statusCode;
        const statusColor =
            status >= 500 ? '\x1b[31m' // red
            : status >= 400 ? '\x1b[33m' // yellow
            : status >= 300 ? '\x1b[36m' // cyan
            : status >= 200 ? '\x1b[32m' // green
            : '\x1b[0m'; // reset
        const resetColor = '\x1b[0m';
        console.log(`📨 ${req.method} ${req.originalUrl} ${statusColor}${status}${resetColor} - ${duration}ms`);
    });
    next();
});

// ========== AUTH ENDPOINTS - UPDATED FOR YOUR SCHEMA ==========

// Signup endpoint - UPDATED
app.post('/api/signup', async (req, res) => {
    let connection;
    try {
        const { username, email, password, dietary_preferences } = req.body;

        // Validate required fields
        if (!username || !email || !password) {
            return res.status(400).json({
                success: false,
                error: 'Username, email, and password are required.'
            });
        }

        if (password.length < 6) {
            return res.status(400).json({
                success: false,
                error: 'Password must be at least 6 characters.'
            });
        }

        connection = await pool.getConnection();

        // Check for existing user - UPDATED TABLE NAME
        const [existingUsers] = await connection.execute(
            'SELECT user_id FROM Users WHERE email = ? OR username = ?',
            [email, username]
        );

        if (existingUsers.length > 0) {
            return res.status(400).json({
                success: false,
                error: 'User already exists with this email or username.'
            });
        }

        // Hash password and create user - UPDATED TABLE NAME AND COLUMNS
        const saltRounds = 12;
        const password_hash = await bcrypt.hash(password, saltRounds);

        const [result] = await connection.execute(
            'INSERT INTO Users (username, email, password_hash, dietary_preferences) VALUES (?, ?, ?, ?)',
            [username, email, password_hash, dietary_preferences ? JSON.stringify(dietary_preferences) : null]
        );

        // Generate JWT token
        const token = jwt.sign(
            {
                userId: result.insertId,
                username: username,
                email: email,
                role: 'user' // New users are always 'user' role
            },
            JWT_SECRET,
            { expiresIn: '7d' }
        );

        res.status(201).json({
            success: true,
            message: 'User created successfully!',
            token: token,
            user: {
                user_id: result.insertId,
                username: username,
                email: email,
                role: 'user',
                profile_picture_url: null,
                dietary_preferences: dietary_preferences || [],
                default_servings: 2
            }
        });

    } catch (error) {
        console.error('❌ Signup error:', error);
        res.status(500).json({
            success: false,
            error: 'Internal server error during registration.'
        });
    } finally {
        if (connection) connection.release();
    }
});

// Login endpoint - UPDATED
app.post('/api/login', async (req, res) => {
    let connection;
    try {
        const { email, password } = req.body;

        if (!email || !password) {
            return res.status(400).json({
                success: false,
                error: 'Email and password are required.'
            });
        }

        connection = await pool.getConnection();
        // UPDATED TABLE NAME AND COLUMNS
        const [users] = await connection.execute(
            'SELECT * FROM Users WHERE email = ?',
            [email]
        );

        if (users.length === 0) {
            return res.status(401).json({
                success: false,
                error: 'Invalid email or password.'
            });
        }

        const user = users[0];
        const isPasswordValid = await bcrypt.compare(password, user.password_hash);

        if (!isPasswordValid) {
            return res.status(401).json({
                success: false,
                error: 'Invalid email or password.'
            });
        }

        // Generate JWT token
        const token = jwt.sign(
            {
                userId: user.user_id, // UPDATED COLUMN NAME
                username: user.username,
                email: user.email,
                role: user.role // Add role to the token payload
            },
            JWT_SECRET,
            { expiresIn: '7d' }
        );

        res.json({
            success: true,
            message: 'Login successful!',
            token: token,
            user: {
                user_id: user.user_id,
                username: user.username,
                email: user.email,
                profile_picture_url: user.profile_picture_url,
                role: user.role,
                bio: user.bio,
                dietary_preferences: user.dietary_preferences ? JSON.parse(user.dietary_preferences) : [],
                default_servings: user.default_servings || 2
            }
        });

    } catch (error) {
        console.error('❌ Login error:', error);
        res.status(500).json({
            success: false,
            error: 'Internal server error during login.'
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== RECIPE ENDPOINTS - COMPLETELY UPDATED FOR YOUR SCHEMA ==========

// Get all recipes for a user
app.get('/api/recipes', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        connection = await pool.getConnection();

        // UPDATED QUERY FOR YOUR SCHEMA
        const [recipes] = await connection.execute(
            `SELECT r.*, 
                    GROUP_CONCAT(DISTINCT c.name) as categories,
                    GROUP_CONCAT(DISTINCT ri.ingredient_id) as ingredient_ids,
                    u.username as author_name
             FROM Recipes r
             LEFT JOIN Recipe_Categories rc ON r.recipe_id = rc.recipe_id
             LEFT JOIN Categories c ON rc.category_id = c.category_id
             LEFT JOIN Recipe_Ingredients ri ON r.recipe_id = ri.recipe_id
             LEFT JOIN Users u ON r.user_id = u.user_id
             WHERE r.user_id = ? OR r.is_public = TRUE
             GROUP BY r.recipe_id
             ORDER BY r.created_at DESC`,
            [userId]
        );

        // --- N+1 Query Optimization ---
        // If no recipes, return early
        if (recipes.length === 0) {
            return res.json({ success: true, recipes: [] });
        }

        const recipeIds = recipes.map(r => r.recipe_id);
        const placeholders = recipeIds.map(() => '?').join(',');

        // Fetch all ingredients for all recipes in one query
        const [allIngredients] = await connection.execute(
            `SELECT ri.*, i.name as ingredient_name 
             FROM Recipe_Ingredients ri
             JOIN Ingredients i ON ri.ingredient_id = i.ingredient_id
             WHERE ri.recipe_id IN (${placeholders})`,
            recipeIds
        );

        // Fetch all steps for all recipes in one query
        const [allSteps] = await connection.execute(
            `SELECT * FROM Recipe_Steps WHERE recipe_id IN (${placeholders}) ORDER BY recipe_id, step_number`,
            recipeIds
        );

        // Group ingredients and steps by recipe_id for easy lookup
        const ingredientsByRecipe = allIngredients.reduce((acc, ing) => {
            (acc[ing.recipe_id] = acc[ing.recipe_id] || []).push(ing);
            return acc;
        }, {});

        const stepsByRecipe = allSteps.reduce((acc, step) => {
            (acc[step.recipe_id] = acc[step.recipe_id] || []).push(step);
            return acc;
        }, {});

        // Combine the data
        const recipesWithDetails = recipes.map(recipe => ({
            ...recipe,
            categories: recipe.categories ? recipe.categories.split(',') : [],
            ingredients: ingredientsByRecipe[recipe.recipe_id] || [],
            steps: stepsByRecipe[recipe.recipe_id] || []
        }));

        res.json({
            success: true,
            recipes: recipesWithDetails
        });

    } catch (error) {
        console.error('❌ Error fetching recipes:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to fetch recipes'
        });
    } finally {
        if (connection) connection.release();
    }
});

// Create a new recipe - COMPLETELY UPDATED
app.post('/api/recipes', authenticateToken, uploadRecipe.single('image'), async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const {
            title,
            description,
            prep_time,
            cook_time,
            servings,
            difficulty,
            meal_type,
            tags,
            is_public,
            ingredients,
            steps,
            categories
        } = req.body;

        if (!title) {
            return res.status(400).json({
                success: false,
                error: 'Recipe title is required'
            });
        }

        connection = await pool.getConnection();

        // Start transaction for multiple inserts
        await connection.execute('START TRANSACTION');

        try {
            // Handle image upload
            let image_url = null;
            if (req.file) {
                image_url = `/uploads/recipes/${req.file.filename}`;
            }

            // Insert recipe - UPDATED FOR YOUR SCHEMA
            const [result] = await connection.execute(
                `INSERT INTO Recipes (title, description, prep_time, cook_time, servings, 
                                  difficulty, image_url, user_id, meal_type, tags, is_public) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
                [title, description, prep_time, cook_time, servings, difficulty,
                 image_url, userId, meal_type, tags ? JSON.stringify(tags) : null, is_public || true]
            );

            const recipeId = result.insertId;

            // Insert ingredients if provided
            if (ingredients && Array.isArray(JSON.parse(ingredients))) {
                const ingredientsArray = JSON.parse(ingredients);
                for (const ingredient of ingredientsArray) {
                    // Check if ingredient exists, if not create it
                    let ingredientId = ingredient.ingredient_id;
                    
                    if (!ingredientId && ingredient.name) {
                        // Try to find existing ingredient
                        const [existingIngredients] = await connection.execute(
                            'SELECT ingredient_id FROM Ingredients WHERE name = ?',
                            [ingredient.name]
                        );

                        if (existingIngredients.length > 0) {
                            ingredientId = existingIngredients[0].ingredient_id;
                        } else {
                            // Create new ingredient
                            const [ingResult] = await connection.execute(
                                'INSERT INTO Ingredients (name, category) VALUES (?, ?)',
                                [ingredient.name, ingredient.category]
                            );
                            ingredientId = ingResult.insertId;
                        }
                    }

                    // Insert recipe ingredient relationship
                    await connection.execute(
                        `INSERT INTO Recipe_Ingredients (recipe_id, ingredient_id, quantity, 
                                                      measurement_unit, notes, preparation_notes) 
                         VALUES (?, ?, ?, ?, ?, ?)`,
                        [recipeId, ingredientId, ingredient.quantity, ingredient.measurement_unit,
                         ingredient.notes, ingredient.preparation_notes]
                    );
                }
            }

            // Insert steps if provided
            if (steps && Array.isArray(JSON.parse(steps))) {
                const stepsArray = JSON.parse(steps);
                for (const step of stepsArray) {
                    await connection.execute(
                        'INSERT INTO Recipe_Steps (recipe_id, step_number, instruction, image_url, timer_minutes) VALUES (?, ?, ?, ?, ?)',
                        [recipeId, step.step_number, step.instruction, step.image_url, step.timer_minutes]
                    );
                }
            }

            // Insert categories if provided
            if (categories && Array.isArray(JSON.parse(categories))) {
                const categoriesArray = JSON.parse(categories);
                for (const categoryId of categoriesArray) {
                    await connection.execute(
                        'INSERT INTO Recipe_Categories (recipe_id, category_id) VALUES (?, ?)',
                        [recipeId, categoryId]
                    );
                }
            }

            // Commit transaction
            await connection.execute('COMMIT');

            res.status(201).json({
                success: true,
                message: 'Recipe created successfully!',
                recipe_id: recipeId
            });

        } catch (error) {
            // Rollback transaction on error
            await connection.execute('ROLLBACK');
            throw error;
        }

    } catch (error) {
        console.error('❌ Error creating recipe:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to create recipe'
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== USER ACTIVITY ENDPOINT - NEW ==========
app.get('/api/users/:userId/activity', authenticateToken, async (req, res) => {
    let connection;
    try {
        const requestedUserId = parseInt(req.params.userId, 10);
        const currentUserId = req.user.userId;

        // For now, only allow users to see their own activity.
        if (requestedUserId !== currentUserId) {
            return res.status(403).json({ success: false, error: 'You can only view your own activity.' });
        }

        const page = parseInt(req.query.page, 10) || 1;
        const limit = parseInt(req.query.limit, 10) || 15;
        const offset = (page - 1) * limit;

        connection = await pool.getConnection();

        const [activities] = await connection.execute(
            `
            (SELECT
                'post' as type,
                p.post_id as id,
                p.content,
                p.created_at,
                p.post_id as context_id,
                'You posted in the community' as context_title
            FROM Community_Posts p
            WHERE p.user_id = ?)

            UNION ALL

            (SELECT
                'comment' as type,
                c.comment_id as id,
                c.content,
                c.created_at,
                p.post_id as context_id,
                CONCAT('You commented on a post by ', u.username) as context_title
            FROM Post_Comments c
            JOIN Community_Posts p ON c.post_id = p.post_id
            JOIN Users u ON p.user_id = u.user_id
            WHERE c.user_id = ?)

            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
            `,
            [requestedUserId, requestedUserId, limit, offset]
        );

        res.json({ success: true, activities });

    } catch (error) {
        console.error('❌ Error fetching user activity:', error);
        res.status(500).json({ success: false, error: 'Failed to fetch user activity.' });
    } finally {
        if (connection) connection.release();
    }
});

// ========== MEAL PLANNING ENDPOINTS - UPDATED FOR YOUR SCHEMA ==========

// Get meal plan for a date range
app.get('/api/meal-plans', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { start_date, end_date } = req.query;

        if (!start_date || !end_date) {
            return res.status(400).json({
                success: false,
                error: 'Start date and end date are required'
            });
        }

        connection = await pool.getConnection();

        // UPDATED QUERY FOR YOUR SCHEMA
        const [mealPlans] = await connection.execute(
            `SELECT mp.*, r.title, r.image_url, r.prep_time, r.cook_time, r.servings, 
                    r.difficulty, r.meal_type
             FROM Meal_Plans mp
             JOIN Recipes r ON mp.recipe_id = r.recipe_id
             WHERE mp.user_id = ? AND mp.plan_date BETWEEN ? AND ?
             ORDER BY mp.plan_date, mp.meal_type`,
            [userId, start_date, end_date]
        );

        res.json({
            success: true,
            meal_plans: mealPlans
        });

    } catch (error) {
        console.error('❌ Error fetching meal plans:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to fetch meal plans'
        });
    } finally {
        if (connection) connection.release();
    }
});

// Add recipe to meal plan - UPDATED
app.post('/api/meal-plans', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { recipe_id, plan_date, meal_type, custom_servings, notes } = req.body;

        if (!recipe_id || !plan_date || !meal_type) {
            return res.status(400).json({
                success: false,
                error: 'Recipe ID, plan date, and meal type are required'
            });
        }

        connection = await pool.getConnection();

        // Check if recipe exists and belongs to user or is public
        const [recipes] = await connection.execute(
            'SELECT recipe_id FROM Recipes WHERE recipe_id = ? AND (user_id = ? OR is_public = TRUE)',
            [recipe_id, userId]
        );

        if (recipes.length === 0) {
            return res.status(404).json({
                success: false,
                error: 'Recipe not found or not accessible'
            });
        }

        // Insert meal plan - UPDATED FOR YOUR SCHEMA
        const [result] = await connection.execute(
            `INSERT INTO Meal_Plans (user_id, recipe_id, plan_date, meal_type, custom_servings, notes) 
             VALUES (?, ?, ?, ?, ?, ?)`,
            [userId, recipe_id, plan_date, meal_type, custom_servings, notes]
        );

        res.status(201).json({
            success: true,
            message: 'Recipe added to meal plan successfully!',
            plan_id: result.insertId
        });

    } catch (error) {
        console.error('❌ Error adding meal to plan:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to add meal to plan'
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== SHOPPING LIST ENDPOINTS - UPDATED FOR YOUR SCHEMA ==========

// Generate shopping list from meal plans
app.get('/api/shopping-list', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { start_date, end_date } = req.query;

        if (!start_date || !end_date) {
            return res.status(400).json({
                success: false,
                error: 'Start date and end date are required'
            });
        }

        connection = await pool.getConnection();

        // Create a new shopping list
        const [listResult] = await connection.execute(
            'INSERT INTO Shopping_Lists (user_id, list_name, for_dates) VALUES (?, ?, ?)',
            [userId, 'Generated Shopping List', `${start_date} to ${end_date}`]
        );

        const listId = listResult.insertId;

        // Get ingredients from planned meals
        const [ingredients] = await connection.execute(
            `SELECT ri.ingredient_id, i.name as item_name, 
                    SUM(ri.quantity * COALESCE(mp.custom_servings, r.servings) / r.servings) as total_quantity,
                    ri.measurement_unit, i.category
             FROM Meal_Plans mp
             JOIN Recipes r ON mp.recipe_id = r.recipe_id
             JOIN Recipe_Ingredients ri ON r.recipe_id = ri.recipe_id
             JOIN Ingredients i ON ri.ingredient_id = i.ingredient_id
             WHERE mp.user_id = ? AND mp.plan_date BETWEEN ? AND ?
             GROUP BY ri.ingredient_id, ri.measurement_unit, i.category`,
            [userId, start_date, end_date]
        );

        // Insert ingredients into shopping list
        for (const ingredient of ingredients) {
            await connection.execute(
                `INSERT INTO Shopping_Items (list_id, ingredient_id, item_name, quantity, 
                                          measurement_unit, category, source_recipe_id) 
                 VALUES (?, ?, ?, ?, ?, ?, NULL)`,
                [listId, ingredient.ingredient_id, ingredient.item_name, 
                 ingredient.total_quantity, ingredient.measurement_unit, ingredient.category]
            );
        }

        // Get custom shopping list items
        const [customItems] = await connection.execute(
            `SELECT item_id, item_name, quantity, measurement_unit, category, is_purchased
             FROM Shopping_Items 
             WHERE list_id = ? AND ingredient_id IS NULL
             ORDER BY category, item_name`,
            [listId]
        );

        res.json({
            success: true,
            list_id: listId,
            generated_ingredients: ingredients,
            custom_items: customItems
        });

    } catch (error) {
        console.error('❌ Error generating shopping list:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to generate shopping list'
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== PROFILE & AVATAR ENDPOINTS - UPDATED ==========

// Update user profile
app.put('/api/profile', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { bio, dietary_preferences, default_servings } = req.body;

        connection = await pool.getConnection();

        const [result] = await connection.execute(
            'UPDATE Users SET bio = ?, dietary_preferences = ?, default_servings = ? WHERE user_id = ?',
            [bio, dietary_preferences ? JSON.stringify(dietary_preferences) : null, default_servings, userId]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({
                success: false,
                error: 'User not found'
            });
        }

        res.json({
            success: true,
            message: 'Profile updated successfully!'
        });

    } catch (error) {
        console.error('❌ Error updating profile:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to update profile'
        });
    } finally {
        if (connection) connection.release();
    }
});

// Upload avatar - UPDATED
app.post('/api/profile/avatar', authenticateToken, uploadAvatar.single('avatar'), async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;

        if (!req.file) {
            return res.status(400).json({
                success: false,
                error: 'No file uploaded'
            });
        }

        connection = await pool.getConnection();

        const avatarUrl = `/uploads/avatars/${req.file.filename}`;

        const [result] = await connection.execute(
            'UPDATE Users SET profile_picture_url = ? WHERE user_id = ?',
            [avatarUrl, userId]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({
                success: false,
                error: 'User not found'
            });
        }

        res.json({
            success: true,
            profile_picture_url: avatarUrl,
            message: 'Avatar uploaded successfully!'
        });

    } catch (error) {
        console.error('❌ Error uploading avatar:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to upload avatar'
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== COMMENTS/REVIEWS ENDPOINTS - NEW ==========

// Post a new review
app.post('/api/reviews', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { recipe_id, rating, content } = req.body;

        // --- Validation ---
        if (!recipe_id || !rating || !content) {
            return res.status(400).json({ success: false, error: 'Recipe ID, rating, and content are required.' });
        }
        if (parseInt(rating) < 1 || parseInt(rating) > 5) {
            return res.status(400).json({ success: false, error: 'Rating must be between 1 and 5.' });
        }
        if (content.trim().length === 0) {
            return res.status(400).json({ success: false, error: 'Review content cannot be empty.' });
        }

        connection = await pool.getConnection();

        // Check if the recipe exists
        const [recipes] = await connection.execute('SELECT recipe_id FROM Recipes WHERE recipe_id = ?', [recipe_id]);
        if (recipes.length === 0) {
            return res.status(404).json({ success: false, error: 'Recipe not found.' });
        }

        // Insert the new comment
        const [result] = await connection.execute(
            'INSERT INTO Comments (user_id, recipe_id, rating, content) VALUES (?, ?, ?, ?)',
            [userId, recipe_id, rating, content]
        );

        const newCommentId = result.insertId;

        // Fetch the newly created comment along with user details to return to the frontend
        const [newCommentData] = await connection.execute(
            `SELECT c.comment_id, c.content, c.rating, c.created_at, u.username, u.profile_picture_url
             FROM Comments c
             JOIN Users u ON c.user_id = u.user_id
             WHERE c.comment_id = ?`,
            [newCommentId]
        );

        if (newCommentData.length === 0) {
            throw new Error('Failed to retrieve the new comment.');
        }

        res.status(201).json({
            success: true,
            message: 'Review posted successfully!',
            review: newCommentData[0]
        });

    } catch (error) {
        console.error('❌ Error posting review:', error);
        // Check for duplicate entry error (user reviewing the same recipe twice)
        if (error.code === 'ER_DUP_ENTRY') {
            return res.status(409).json({
                success: false,
                error: 'You have already reviewed this recipe.'
            });
        }
        res.status(500).json({
            success: false,
            error: 'Failed to post review.'
        });
    } finally {
        if (connection) connection.release();
    }
});

// Delete a meal from the meal plan
app.delete('/api/meal-plans/:plan_id', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { plan_id } = req.params;

        if (!plan_id) {
            return res.status(400).json({ success: false, error: 'Plan ID is required.' });
        }

        connection = await pool.getConnection();

        const [result] = await connection.execute(
            'DELETE FROM Meal_Plans WHERE plan_id = ? AND user_id = ?',
            [plan_id, userId]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({ success: false, error: 'Meal plan item not found or you do not have permission to delete it.' });
        }

        res.json({ success: true, message: 'Meal removed from plan successfully!' });

    } catch (error) {
        console.error('❌ Error deleting meal from plan:', error);
        res.status(500).json({ success: false, error: 'Failed to delete meal from plan.' });
    } finally {
        if (connection) connection.release();
    }
});


// Get a user's favorited recipes
app.get('/api/favorites', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        connection = await pool.getConnection();

        // Fetch favorited recipes with details
        const [favorites] = await connection.execute(
            `SELECT r.*, u.username
             FROM Favorites f
             JOIN Recipes r ON f.recipe_id = r.recipe_id
             JOIN Users u ON r.user_id = u.user_id
             WHERE f.user_id = ?`,
            [userId]
        );

        res.json({
            success: true,
            favorites: favorites
        });

    } catch (error) {
        console.error('❌ Error fetching favorite recipes:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to fetch favorite recipes'
        });
    } finally {
        if (connection) connection.release();
    }
});


// ========== COMMENTS/REVIEWS ENDPOINTS - NEW ==========


// ========== FAVORITES ENDPOINTS - NEW ==========





// ========== FAVORITES ENDPOINTS - NEW ==========

// Toggle a recipe's favorite status
app.post('/api/favorites/toggle', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { recipe_id } = req.body;

        if (!recipe_id) {
            return res.status(400).json({ success: false, error: 'Recipe ID is required.' });
        }

        connection = await pool.getConnection();

        // Check if the favorite already exists
        const [existing] = await connection.execute(
            'SELECT * FROM Favorites WHERE user_id = ? AND recipe_id = ?',
            [userId, recipe_id]
        );

        if (existing.length > 0) {
            // It exists, so remove it
            await connection.execute(
                'DELETE FROM Favorites WHERE user_id = ? AND recipe_id = ?',
                [userId, recipe_id]
            );
            res.json({ success: true, status: 'removed' });
        } else {
            // It doesn't exist, so add it
            await connection.execute(
                'INSERT INTO Favorites (user_id, recipe_id) VALUES (?, ?)',
                [userId, recipe_id]
            );
            res.status(201).json({ success: true, status: 'added' });
        }

    } catch (error) {
        console.error('❌ Error toggling favorite:', error);
        res.status(500).json({ success: false, error: 'Failed to update favorites.' });
    } finally {
        if (connection) connection.release();
    }
});

// Check favorite status for a recipe
app.get('/api/favorites/status/:recipe_id', authenticateToken, async (req, res) => {
    let connection;
    try {
        const userId = req.user.userId;
        const { recipe_id } = req.params;

        if (!recipe_id) {
            return res.status(400).json({ success: false, error: 'Recipe ID is required.' });
        }

        connection = await pool.getConnection();

        const [existing] = await connection.execute(
            'SELECT * FROM Favorites WHERE user_id = ? AND recipe_id = ?',
            [userId, recipe_id]
        );

        res.json({
            success: true,
            isFavorited: existing.length > 0
        });

    } catch (error) {
        console.error('❌ Error checking favorite status:', error);
        res.status(500).json({ success: false, error: 'Failed to check favorite status.' });
    } finally {
        if (connection) connection.release();
    }
});

// ========== AUTHOR PROFILE ENDPOINT - NEW ==========
app.get('/api/author/:id', async (req, res) => {
    let connection;
    try {
        const authorId = parseInt(req.params.id, 10);

        if (isNaN(authorId)) {
            return res.status(400).json({ success: false, error: 'Invalid author ID.' });
        }

        connection = await pool.getConnection();

        // 1. Fetch author's public profile data
        const [authorData] = await connection.execute(
            'SELECT user_id, username, bio, profile_picture_url, created_at FROM Users WHERE user_id = ?',
            [authorId]
        );

        if (authorData.length === 0) {
            return res.status(404).json({ success: false, error: 'Author not found.' });
        }

        const author = authorData[0];

        // 2. Fetch author's stats in a single query
        const [[stats]] = await connection.execute(
            `SELECT
                (SELECT COUNT(*) FROM Recipes WHERE user_id = ?) as recipe_count,
                (SELECT COUNT(*) FROM Post_Comments WHERE user_id = ?) as review_count,
                (SELECT COUNT(*) FROM Followers WHERE following_id = ?) as follower_count,
                (SELECT COUNT(*) FROM Followers WHERE follower_id = ?) as following_count
            `,
            [authorId, authorId, authorId, authorId]
        );

        // 3. Fetch author's public recipes
        const [recipes] = await connection.execute(
            `SELECT recipe_id, title, description, image_url, cook_time, difficulty 
             FROM Recipes 
             WHERE user_id = ? AND is_public = TRUE 
             ORDER BY created_at DESC`,
            [authorId]
        );

        res.json({
            success: true,
            author: { ...author, stats: { ...stats }, recipes: recipes }
        });

    } catch (error) {
        console.error('❌ Error fetching author profile:', error);
        res.status(500).json({ success: false, error: 'Failed to fetch author profile.' });
    } finally {
        if (connection) connection.release();
    }
});

// ========== FOLLOW ENDPOINTS - NEW ==========

// Check if the current user is following an author
app.get('/api/follow/status/:authorId', authenticateToken, async (req, res) => {
    let connection;
    try {
        const followerId = req.user.userId;
        const followingId = parseInt(req.params.authorId, 10);

        if (isNaN(followingId)) {
            return res.status(400).json({ success: false, error: 'Invalid author ID.' });
        }

        connection = await pool.getConnection();
        const [rows] = await connection.execute(
            'SELECT * FROM Followers WHERE follower_id = ? AND following_id = ?',
            [followerId, followingId]
        );

        res.json({ success: true, isFollowing: rows.length > 0 });

    } catch (error) {
        console.error('❌ Error checking follow status:', error);
        res.status(500).json({ success: false, error: 'Failed to check follow status.' });
    } finally {
        if (connection) connection.release();
    }
});

// Toggle follow/unfollow for an author
app.post('/api/follow/toggle', authenticateToken, async (req, res) => {
    let connection;
    try {
        const followerId = req.user.userId;
        const { authorId } = req.body;
        const followingId = parseInt(authorId, 10);

        if (isNaN(followingId)) {
            return res.status(400).json({ success: false, error: 'Invalid author ID.' });
        }

        if (followerId === followingId) {
            return res.status(400).json({ success: false, error: 'You cannot follow yourself.' });
        }

        connection = await pool.getConnection();

        // Check if already following
        const [existing] = await connection.execute(
            'SELECT * FROM Followers WHERE follower_id = ? AND following_id = ?',
            [followerId, followingId]
        );

        let status;
        if (existing.length > 0) {
            // Unfollow
            await connection.execute(
                'DELETE FROM Followers WHERE follower_id = ? AND following_id = ?',
                [followerId, followingId]
            );
            status = 'unfollowed';
        } else {
            // Follow
            await connection.execute(
                'INSERT INTO Followers (follower_id, following_id) VALUES (?, ?)',
                [followerId, followingId]
            );
            status = 'followed';
        }

        // Get the new follower count
        const [[{ newFollowerCount }]] = await connection.execute('SELECT COUNT(*) as newFollowerCount FROM Followers WHERE following_id = ?', [followingId]);

        res.json({ success: true, status, newFollowerCount });

    } catch (error) {
        console.error('❌ Error toggling follow:', error);
        res.status(500).json({ success: false, error: 'Failed to update follow status.' });
    } finally {
        if (connection) connection.release();
    }
});

// ========== SEARCH ENDPOINT - NEW ==========
app.get('/api/search', async (req, res) => {
    let connection;
    try {
        const query = req.query.q;
        const ingredientsQuery = req.query.ingredients;
        const difficulty = req.query.difficulty;
        const category = req.query.category;
        const page = parseInt(req.query.page, 10) || 1;
        const sort = req.query.sort || 'newest';
        const limit = parseInt(req.query.limit, 10) || 9; // 9 results per page
        const offset = (page - 1) * limit;

        if ((!query || query.trim().length === 0) && (!ingredientsQuery || ingredientsQuery.trim().length === 0) && !category) {
            return res.status(400).json({ success: false, error: 'A search query or ingredients are required.' });
        }

        connection = await pool.getConnection();

        let whereClauses = ['r.is_public = TRUE'];
        let params = [];
        let havingClause = '';
        let joins = 'JOIN Users u ON r.user_id = u.user_id';
        let orderBySql = 'ORDER BY r.created_at DESC'; // Default sort

        // Whitelist for safe sorting
        const sortOptions = {
            'newest': 'ORDER BY r.created_at DESC',
            'cook_time_asc': 'ORDER BY r.cook_time ASC, r.title ASC',
            'cook_time_desc': 'ORDER BY r.cook_time DESC, r.title ASC',
            'title_asc': 'ORDER BY r.title ASC'
        };
        if (sortOptions[sort]) { orderBySql = sortOptions[sort]; }

        // Handle keyword search
        if (query && query.trim().length > 0) {
            whereClauses.push(`(r.title LIKE ? OR r.description LIKE ? OR r.tags LIKE ?)`);
            const searchTerm = `%${query}%`;
            params.push(searchTerm, searchTerm, searchTerm);
        }

        // Handle ingredient search
        if (ingredientsQuery && ingredientsQuery.trim().length > 0) {
            const ingredients = ingredientsQuery.split(',').map(ing => ing.trim()).filter(ing => ing);
            if (ingredients.length > 0) {
                joins += `
                    JOIN Recipe_Ingredients ri ON r.recipe_id = ri.recipe_id
                    JOIN Ingredients i ON ri.ingredient_id = i.ingredient_id
                `;
                // Create placeholders for the IN clause: (?, ?, ?)
                const ingredientPlaceholders = ingredients.map(() => '?').join(',');
                whereClauses.push(`i.name IN (${ingredientPlaceholders})`);
                params.push(...ingredients);

                // This HAVING clause ensures recipes contain ALL specified ingredients
                havingClause = `HAVING COUNT(DISTINCT i.name) = ${ingredients.length}`;
            }
        }

        // Handle difficulty filter
        if (difficulty && difficulty !== 'all') {
            whereClauses.push('r.difficulty = ?');
            params.push(difficulty);
        }

        // Handle category filter
        if (category && category !== 'all') {
            // Add JOINs only if they haven't been added by ingredient search
            if (!joins.includes('Recipe_Categories')) {
                joins += ` JOIN Recipe_Categories rc ON r.recipe_id = rc.recipe_id JOIN Categories c ON rc.category_id = c.category_id`;
            }
            whereClauses.push('c.name = ?');
            params.push(category);
        }

        const whereSql = `WHERE ${whereClauses.join(' AND ')}`;
        const groupBySql = (ingredientsQuery && ingredientsQuery.trim().length > 0) ? 'GROUP BY r.recipe_id' : '';

        // We need to wrap the main query to correctly count the results of the GROUP BY/HAVING
        const baseQuery = `
            SELECT r.recipe_id
            FROM Recipes r
            ${joins}
            ${whereSql}
            ${groupBySql}
            ${havingClause}
        `;

        // Query 1: Get total count of matching recipes
        const dataQuery = `
            SELECT 
                r.recipe_id, r.title, r.description, r.image_url, 
                r.cook_time, r.difficulty, u.username
            FROM Recipes r
            JOIN Users u ON r.user_id = u.user_id
            WHERE r.recipe_id IN (
                SELECT recipe_id FROM (${baseQuery} ${orderBySql} LIMIT ? OFFSET ?) as paged_ids
            )
            ${orderBySql}
        `;

        const [[countResult], [results]] = await Promise.all([
            connection.execute(
                `SELECT COUNT(*) as total FROM (${baseQuery}) as subquery`,
                params
            ),
            connection.execute(
                dataQuery,
                [...params, limit, offset]
            )
        ]);

        res.json({
            success: true,
            query: query,
            ingredients: ingredientsQuery,
            difficulty: difficulty,
            category: category,
            sort: sort,
            pagination: {
                totalResults: countResult[0].total,
                totalPages: Math.ceil(countResult[0].total / limit),
                currentPage: page,
                limit
            },
            results: results
        });

    } catch (error) {
        console.error('❌ Error during search:', error);
        res.status(500).json({
            success: false,
            error: 'Failed to perform search.',
            details: error.message
        });
    } finally {
        if (connection) connection.release();
    }
});

// ========== BROWSE RECIPES ENDPOINT - NEW ==========
app.get('/api/recipes/browse', async (req, res) => {
    let connection;
    try {
        const {
            category,
            difficulty,
            max_time,
            tag,
            sort = 'newest'
        } = req.query;
        const page = parseInt(req.query.page, 10) || 1;
        const limit = parseInt(req.query.limit, 10) || 9;
        const offset = (page - 1) * limit;

        connection = await pool.getConnection();

        let whereClauses = ['r.is_public = TRUE'];
        let params = [];
        let joins = 'JOIN Users u ON r.user_id = u.user_id';
        let orderBySql = 'ORDER BY r.created_at DESC'; // Default sort

        // Whitelist for safe sorting
        const sortOptions = {
            'newest': 'ORDER BY r.created_at DESC',
            'cook_time_asc': 'ORDER BY r.cook_time ASC, r.title ASC',
            'cook_time_desc': 'ORDER BY r.cook_time DESC, r.title ASC',
            'title_asc': 'ORDER BY r.title ASC'
        };
        if (sortOptions[sort]) {
            orderBySql = sortOptions[sort];
        }

        // Handle category filter
        if (category && category !== 'all') {
            if (!joins.includes('Recipe_Categories')) {
                joins += ` JOIN Recipe_Categories rc ON r.recipe_id = rc.recipe_id JOIN Categories c ON rc.category_id = c.category_id`;
            }
            whereClauses.push('c.name = ?');
            params.push(category);
        }

        // Handle difficulty filter
        if (difficulty && difficulty !== 'all') {
            whereClauses.push('r.difficulty = ?');
            params.push(difficulty);
        }

        // Handle max cooking time filter
        if (max_time && max_time !== 'all' && !isNaN(parseInt(max_time))) {
            whereClauses.push('r.cook_time <= ?');
            params.push(parseInt(max_time));
        }

        // Handle tag filter
        if (tag && tag !== 'all') {
            whereClauses.push('JSON_CONTAINS(r.tags, JSON_QUOTE(?))');
            params.push(tag);
        }

        const whereSql = `WHERE ${whereClauses.join(' AND ')}`;

        const baseQuery = `SELECT r.recipe_id FROM Recipes r ${joins} ${whereSql}`;

        // Query 1: Get total count
        const countQuery = `SELECT COUNT(DISTINCT r.recipe_id) as total FROM Recipes r ${joins} ${whereSql}`;
        const [countResult] = await connection.execute(countQuery, params);
        const totalResults = countResult[0].total;
        const totalPages = Math.ceil(totalResults / limit);

        // Query 2: Get paged results
        const dataQuery = `
            SELECT r.recipe_id, r.title, r.description, r.image_url, r.cook_time, r.difficulty, u.username,
                   (SELECT AVG(rating) FROM Comments WHERE recipe_id = r.recipe_id) as avg_rating,
                   (SELECT COUNT(*) FROM Comments WHERE recipe_id = r.recipe_id) as review_count
            FROM Recipes r
            ${joins}
            ${whereSql}
            GROUP BY r.recipe_id
            ${orderBySql}
            LIMIT ? OFFSET ?
        `;

        const [recipes] = await connection.execute(dataQuery, [...params, limit, offset]);

        res.json({
            success: true,
            pagination: { totalResults, totalPages, currentPage: page, limit },
            results: recipes
        });

    } catch (error) {
        console.error('❌ Error browsing recipes:', error);
        res.status(500).json({ success: false, error: 'Failed to browse recipes.' });
    } finally {
        if (connection) connection.release();
    }
});

// Update a content report (resolve, dismiss, etc.)
app.put('/api/admin/reports/:reportId', authenticateToken, isAdmin, async (req, res) => {
    let connection;
    try {
        const { reportId } = req.params;
        const { status, action, content_type, content_id, admin_notes } = req.body;

        if (!status) {
            return res.status(400).json({ success: false, error: 'A new status is required.' });
        }

        connection = await pool.getConnection();
        await connection.beginTransaction();

        // Step 1: Update the report status
        await connection.execute(
            'UPDATE Content_Reports SET status = ?, admin_notes = ? WHERE report_id = ?',
            [status, admin_notes || null, reportId]
        );

        // Step 2: If action is to delete, delete the content
        if (action === 'delete_content') {
            if (content_type === 'post') {
                await connection.execute('DELETE FROM Community_Posts WHERE post_id = ?', [content_id]);
            } else if (content_type === 'comment') {
                await connection.execute('DELETE FROM Post_Comments WHERE comment_id = ?', [content_id]);
            }
        }

        await connection.commit();

        res.json({
            success: true,
            message: `Report ${reportId} has been successfully ${status}.`
        });

    } catch (error) {
        if (connection) await connection.rollback();
        console.error('❌ Error updating report:', error);
        res.status(500).json({ success: false, error: 'Failed to update report.' });
    } finally {
        if (connection) connection.release();
    }
});

// Create a new event (Admin only)
app.post('/api/admin/events', authenticateToken, isAdmin, uploadEvent.single('image'), async (req, res) => {
    let connection;
    try {
        const createdByUserId = req.user.userId;
        const { title, description, start_time, end_time, location } = req.body;

        if (!title || !start_time) {
            return res.status(400).json({ success: false, error: 'Event title and start time are required.' });
        }

        let imageUrl = null;
        if (req.file) {
            imageUrl = `/uploads/events/${req.file.filename}`;
        }

        connection = await pool.getConnection();
        const [result] = await connection.execute(
            'INSERT INTO Events (title, description, start_time, end_time, location, image_url, created_by_user_id) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [title, description || null, start_time, end_time || null, location || null, imageUrl, createdByUserId]
        );

        res.status(201).json({
            success: true,
            message: 'Event created successfully!',
            event_id: result.insertId
        });

    } catch (error) {
        console.error('❌ Error creating event:', error);
        res.status(500).json({ success: false, error: 'Failed to create event.' });
    } finally {
        if (connection) connection.release();
    }
});


// ========== ADMIN USER MANAGEMENT ENDPOINTS - NEW ==========

// Fetch all users for admin
app.get('/api/admin/users', authenticateToken, isAdmin, async (req, res) => {
    let connection;
    try {
        connection = await pool.getConnection();
        const [users] = await connection.execute(
            `SELECT user_id, username, email, role, created_at 
             FROM Users 
             ORDER BY created_at DESC`
        );
        res.json({ success: true, users });
    } catch (error) {
        console.error('❌ Error fetching users for admin:', error);
        res.status(500).json({ success: false, error: 'Failed to fetch users.' });
    } finally {
        if (connection) connection.release();
    }
});

// Update a user's role
app.put('/api/admin/users/:userId/role', authenticateToken, isAdmin, async (req, res) => {
    let connection;
    try {
        const { userId } = req.params;
        const { role } = req.body;

        if (!role || !['user', 'admin'].includes(role)) {
            return res.status(400).json({ success: false, error: 'Invalid role specified.' });
        }

        connection = await pool.getConnection();
        await connection.execute(
            'UPDATE Users SET role = ? WHERE user_id = ?',
            [role, userId]
        );

        res.json({ success: true, message: 'User role updated successfully.' });

    } catch (error) {
        console.error('❌ Error updating user role:', error);
        res.status(500).json({ success: false, error: 'Failed to update user role.' });
    } finally {
        if (connection) connection.release();
    }
});


// ========== ROOT ENDPOINT - UPDATED ==========
app.get('/', (req, res) => {
    res.json({
        message: '🚀 CookFlix Meal Planner API is running!',
        version: '4.9.0',
        timestamp: new Date().toISOString(),
        database: 'CookFlix Schema',
        features: {
            authentication: ['JWT tokens', 'Secure login/signup'],
            recipe_management: ['Create recipes', 'Ingredients & steps', 'Categories'],
            meal_planning: ['Weekly planning', 'Meal types', 'Custom servings'],
            shopping_lists: ['Auto-generated', 'Custom items', 'Categorized'],
            social_features: ['Favorites', 'Comments', 'Following']
        },
        endpoints: {
            auth: ['POST /api/signup', 'POST /api/login'],
            recipes: ['GET /api/recipes', 'POST /api/recipes'], // This should be /api/recipes/browse
            meal_plans: ['GET /api/meal-plans', 'POST /api/meal-plans'],
            shopping: ['GET /api/shopping-list'],
            profile: ['PUT /api/profile', 'POST /api/profile/avatar'],
            reviews: ['POST /api/reviews'],
            favorites: ['POST /api/favorites/toggle', 'GET /api/favorites/status/:recipe_id'],
            get_favorites:['GET /api/favorites'],
            author: ['GET /api/author/:id'],
            follow: ['POST /api/follow/toggle', 'GET /api/follow/status/:authorId'], // This should be /api/follow/toggle
            search: ['GET /api/search?q=<query>&ingredients=<list>&sort=<option>&difficulty=<level>&category=<name>'],
            browse: ['GET /api/recipes/browse'],
            selectable_recipes: ['GET /api/recipes/selectable']
        }
    });
});

// Start the server
app.listen(port, () => {
    console.log(`🚀 CookFlix Meal Planner Server running on http://localhost:${port}`);
    console.log(`📊 Using CookFlix database schema`);
    console.log(`🔐 JWT Authentication enabled`);
    console.log(`📱 Mobile-ready API endpoints configured`);
    console.log(`✅ Perfectly synchronized with your database!`);
});