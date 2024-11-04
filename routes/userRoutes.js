const express = require('express');
const User = require('../models/User');
const verifyToken = require('../middleware/authMiddleware'); 

const router = express.Router();

// Route GET pour récupérer les informations de l'utilisateur connecté
router.get('/me', verifyToken, async (req, res) => {
    try {
        const user = await User.findByPk(req.userId);
        if (!user) {
            return res.status(404).json({ message: 'Utilisateur non trouvé' });
        }
        res.json(user);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
