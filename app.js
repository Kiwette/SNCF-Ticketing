// Importation des modules nécessaires
const express = require('express');
const { Sequelize, DataTypes } = require('sequelize');
const bodyParser = require('body-parser');

// Création de l'application Express
const app = express();
const port = 3001;

// Middleware pour analyser les requêtes JSON
app.use(bodyParser.json());

// Configuration de la base de données
const sequelize = new Sequelize('sncf_ticketing', 'root', '', {
    host: 'localhost',
    dialect: 'mysql',
});

// Modèle d'utilisateur
const User = sequelize.define('User', {
    user_id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true,
    },
    nom: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    prenom: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true,
    },
    mot_de_passe: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    role_id: {
        type: DataTypes.ENUM('Utilisateur', 'Administrateur', 'Support technique'),
        allowNull: false,
    },
    numéro_CP: {
        type: DataTypes.STRING(8),
        allowNull: false,
    },
    date_creation: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
    statut_compte: {
        type: DataTypes.ENUM('actif', 'inactif', 'suspendu'),
        allowNull: false,
    },
    dernière_co: {
        type: DataTypes.DATE,
    },
});

// Synchronisation du modèle avec la base de données
sequelize.sync().then(() => {
    console.log('Base de données synchronisée');
}).catch((error) => {
    console.error('Erreur lors de la synchronisation de la base de données :', error);
});

// Routes pour les utilisateurs

// Route GET pour récupérer tous les utilisateurs
app.get('/users', async (req, res) => {
    try {
        const users = await User.findAll();
        res.json(users);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Route POST pour créer un nouvel utilisateur
app.post('/users', async (req, res) => {
    try {
        const newUser = await User.create(req.body);
        res.status(201).json({ message: 'Utilisateur créé', user: newUser });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

// Route GET pour récupérer un utilisateur par ID
app.get('/users/:id', async (req, res) => {
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
});

// Route PUT pour modifier un utilisateur
app.put('/users/:id', async (req, res) => {
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
});

// Route DELETE pour supprimer un utilisateur
app.delete('/users/:id', async (req, res) => {
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
});

const publicRoutes = require('./routes/publicRoutes');

// Utilisation des routes publiques
app.use('/api', publicRoutes);

// Démarrer le serveur
app.listen(port, () => {
    console.log(`API REST disponible sur http://localhost:${3003}`);
});
