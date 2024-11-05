// middlewares/authMiddleware.js
const jwt = require('jsonwebtoken');
const User = require('../models/User');

// Middleware pour vérifier le token JWT
exports.verifyToken = (req, res, next) => {
    const token = req.header('Authorization');
    if (!token) return res.status(401).json({ message: 'Accès refusé. Aucun token fourni.' });

    try {
        const verified = jwt.verify(token, process.env.JWT_SECRET); // Utilisation du secret pour vérifier
        req.user = verified; // Stocker l'utilisateur authentifié dans req
        next(); // Passer au middleware suivant
    } catch (error) {
        res.status(400).json({ message: 'Token invalide.' });
    }
};

// Middleware pour vérifier le rôle administrateur
exports.verifyAdmin = async (req, res, next) => {
    try {
        const user = await User.findByPk(req.user.user_id); // Récupérer l'utilisateur authentifié
        if (user && user.role_id === 'Administrateur') {
            next(); // Passer au middleware suivant si l'utilisateur est admin
        } else {
            res.status(403).json({ message: 'Accès refusé. Réservé aux administrateurs.' });
        }
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
};

// Middleware pour vérifier le rôle support technique
exports.verifySupport = async (req, res, next) => {
    try {
        const user = await User.findByPk(req.user.user_id);
        if (user && (user.role_id === 'Support technique' || user.role_id === 'Administrateur')) {
            next(); // Passer si admin ou support technique
        } else {
            res.status(403).json({ message: 'Accès refusé. Réservé au support technique.' });
        }
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
};


// Permet de vérifier les rôles et s'assurer que seules les personnes autorisées accèdent aux routes    