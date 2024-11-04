const { Sequelize, DataTypes } = require('sequelize');
const sequelize = require('../config'); // Assurez-vous d'importer votre configuration Sequelize

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

// Hachage du mot de passe avant de sauvegarder
User.beforeCreate(async (user) => {
    user.mot_de_passe = await bcrypt.hash(user.mot_de_passe, 10);
});

// Méthode pour vérifier le mot de passe
User.prototype.verifyPassword = async function(password) {
    return await bcrypt.compare(password, this.mot_de_passe);
};

// Exporter le modèle User
module.exports = User;
