const User = require('../models/User');

// Récupérer tous les utilisateurs
exports.getAllUsers = async (req, res) => {
    try {
        const users = await User.findAll();
        res.json(users);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Créer un nouvel utilisateur
exports.createUser = async (req, res) => {
    try {
        const newUser = await User.create(req.body);
        res.status(201).json({ message: 'Utilisateur créé', user: newUser });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};

// Récupérer un utilisateur par ID
exports.getUserById = async (req, res) => {
    try {
        const user = await User.findByPk(req.params.id);
        if (user) {
            res.json(user);
        } else {
            res.status(404).json({ message: 'Utilisateur non trouvé' });
        }
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Modifier un utilisateur
exports.updateUser = async (req, res) => {
    try {
        const user = await User.findByPk(req.params.id);
        if (user) {
            await user.update(req.body);
            res.json({ message: 'Utilisateur mis à jour', user });
        } else {
            res.status(404).json({ message: 'Utilisateur non trouvé' });
        }
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};

// Supprimer un utilisateur
exports.deleteUser = async (req, res) => {
    try {
        const user = await User.findByPk(req.params.id);
        if (user) {
            await user.destroy();
            res.json({ message: 'Utilisateur supprimé', id: req.params.id });
        } else {
            res.status(404).json({ message: 'Utilisateur non trouvé' });
        }
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
