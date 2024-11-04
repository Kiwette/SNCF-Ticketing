const express = require('express');
const router = express.Router();
const User = require('../models/User');  
const nodemailer = require('nodemailer'); // Pour envoyer des e-mails
const jwt = require('jsonwebtoken'); // Pour créer des jetons
const bcrypt = require('bcrypt'); 

// Secret pour signer le jeton
const JWT_SECRET = 'test_appli221291'; 

// Route POST pour la connexion
router.post('/login', async (req, res) => {
    const { email, mot_de_passe } = req.body;
    try {
        const user = await User.findOne({ where: { email } });
        if (user && await bcrypt.compare(mot_de_passe, user.mot_de_passe)) {
            // Création du jeton
            const token = jwt.sign({ id: user.user_id, role: user.role_id }, JWT_SECRET, { expiresIn: '1h' });
            res.status(200).json({ message: 'Connexion réussie', token });
        } else {
            res.status(401).json({ message: 'Identifiants invalides' });
        }
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Middleware pour vérifier le jeton
const authenticateToken = (req, res, next) => {
    const token = req.headers['authorization']?.split(' ')[1]; 
    if (!token) return res.sendStatus(401); 

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) return res.sendStatus(403); 
        req.user = user; 
        next(); 
    });
};


router.get('/secure-data', authenticateToken, (req, res) => {
   
    res.status(200).json({ message: 'Données sécurisées', user: req.user });
});

// Route POST pour l'inscription
router.post('/register', async (req, res) => {
    try {
        // Hachage du mot de passe avant de le stocker
        const hashedPassword = await bcrypt.hash(req.body.mot_de_passe, 10);
        const newUser = await User.create({ ...req.body, mot_de_passe: hashedPassword });
        res.status(201).json({ message: 'Utilisateur créé', user: newUser });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

// Route POST pour envoyer un message via le formulaire de contact
router.post('/contact', async (req, res) => {
    const { nom, email, message } = req.body;

    // Configuration du transporteur pour l'envoi d'e-mails
    const transporter = nodemailer.createTransport({
        service: 'gmail', 
        auth: {
            user: 'helene.dhervillez@gmail.com', 
            pass: '' 
        }
    });

    const mailOptions = {
        from: gmail,
        to: 'hdhervillez@gmail.com', 
        subject: `Message de contact de ${nom}`,
        text: message
    };

    try {
        await transporter.sendMail(mailOptions);
        res.status(200).json({ message: 'Message envoyé avec succès' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
