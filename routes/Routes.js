const express = require('express');
const jwt = require('jsonwebtoken');
const User = require('../models/User'); 
const router = express.Router();

const SECRET_KEY = 'votre_clé_secrète'; 

// Route d'inscription
router.post('/signup', async (req, res) => {
    try {
        const { nom, prenom, email, mot_de_passe, role_id, numéro_CP } = req.body;
        const newUser = await User.create({ nom, prenom, email, mot_de_passe, role_id, numéro_CP, statut_compte: 'actif' });
        res.status(201).json({ message: 'Utilisateur créé', user: newUser });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

// Route de connexion
router.post('/login', async (req, res) => {
    try {
        const { email, mot_de_passe } = req.body;
        const user = await User.findOne({ where: { email } });

        if (!user || !(await user.verifyPassword(mot_de_passe))) {
            return res.status(401).json({ error: 'Email ou mot de passe incorrect' });
        }

        // Générer un token
        const token = jwt.sign({ id: user.user_id, role: user.role_id }, SECRET_KEY, { expiresIn: '1h' });
        res.json({ message: 'Connexion réussie', token });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
