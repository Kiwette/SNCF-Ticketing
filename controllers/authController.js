const jwt = require('jsonwebtoken');
const bcrypt = require('bcrypt');
const User = require('../models/User');

exports.login = async (req, res) => {
    try {
        const { email, mot_de_passe } = req.body;
        const user = await User.findOne({ where: { email } });

        if (!user) {
            return res.status(400).json({ message: 'Utilisateur non trouvé.' });
        }

        const validPassword = await bcrypt.compare(mot_de_passe, user.mot_de_passe);
        if (!validPassword) {
            return res.status(400).json({ message: 'Mot de passe incorrect.' });
        }

        // Générer un token JWT
        const token = jwt.sign({ user_id: user.user_id, role_id: user.role_id }, process.env.JWT_SECRET, {
            expiresIn: '1h'
        });
        res.header('Authorization', token).json({ message: 'Connexion réussie', token });
    } catch (error) {
        res.status(500).json({ message: error.message });
    }
};
