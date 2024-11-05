// routes/userRoutes.js
const express = require('express');
const userController = require('../controllers/userController');
const router = express.Router();
const { verifyAdmin, verifyToken } = require('../middlewares/authMiddleware');

// Routes réservées aux administrateurs
router.get('/users', verifyToken, verifyAdmin, userController.getAllUsers); // Admin seulement
router.post('/users', verifyToken, verifyAdmin, userController.createUser); // Admin seulement
router.put('/users/:id', verifyToken, verifyAdmin, userController.updateUser); // Admin seulement
router.delete('/users/:id', verifyToken, verifyAdmin, userController.deleteUser); // Admin seulement

module.exports = router;



//ROUTES POUR LES UTILISATEURS
//verifyToken : middleware pour vérifier si l'utilisateur est authentifié (token JWT valide).
//verifyAdmin : middleware pour vérifier si l'utilisateur a le rôle administrateur.