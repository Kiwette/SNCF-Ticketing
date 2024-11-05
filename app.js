// Importation des modules nécessaires
const express = require('express');
const { Sequelize, DataTypes } = require('sequelize');
const bodyParser = require('body-parser');
const path = require('path'); // Pour gérer les chemins de fichiers
require('dotenv').config(); // Pour charger les variables d'environnement

// Création de l'application Express
const app = express();
const port = 3001;

// Middleware pour analyser les requêtes JSON
app.use(bodyParser.json());

// Middleware pour servir les fichiers statiques (HTML, CSS, JS, etc.)
app.use(express.static(path.join(__dirname, 'public')));

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

// Importation des routes
const userRoutes = require('./routes/userRoutes');
const authRoutes = require('./routes/authRoutes');

// Utilisation des routes API
app.use('/api/users', userRoutes);
app.use('/api/auth', authRoutes);

// Routes pour les pages HTML
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.get('/cgu', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'cgu.html'));
});

app.get('/connexion', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'connexion.html'));
});

app.get('/gestion_utilisateur', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'gestion_utilisateur.html'));
});

app.get('/mentions', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'mentions.html'));
});

app.get('/page_accueil', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'page_accueil.html'));
});

app.get('/page_contacts', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'page_contacts.html'));
});

app.get('/page_creation_profil', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'page_creation_profil.html'));
});

app.get('/page_oubli_mdp', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'page_oubli_mdp.html'));
});

app.get('/page_tickets', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'page_tickets.html'));
});

// Démarrer le serveur
app.listen(port, () => {
    console.log(`API REST disponible sur http://localhost:${port}`);
});
