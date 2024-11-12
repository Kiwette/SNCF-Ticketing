const { DataTypes } = require('sequelize');
const sequelize = require('../config/database'); // Importation de la connexion

const Ticket = sequelize.define('Ticket', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true,
  },
  titre_ticket: {
    type: DataTypes.STRING(255),
    allowNull: false,
  },
  description_ticket: {
    type: DataTypes.TEXT,
    allowNull: false,
  },
  date_creation_ticket: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW,
  },
  date_modif_ticket: {
    type: DataTypes.DATE,
    allowNull: false,
    defaultValue: DataTypes.NOW,
  },
  utilisateur_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  categorie_id: {
    type: DataTypes.ENUM('Power Apps', 'Power Bi', 'Power automate'),
    allowNull: false,
  },
  statut_id: {
    type: DataTypes.ENUM('ouvert', 'en cours', 'résolu', 'fermé'),
    allowNull: false,
  },
  priorite_id: {
    type: DataTypes.ENUM('faible', 'moyenne', 'élevée', 'haute'),
    allowNull: false,
  },
  date_cloture: {
    type: DataTypes.DATE,
    allowNull: true,
  },
  cree_par: {
    type: DataTypes.STRING(255),
    allowNull: false,
  },
  commentaire_resolution: {
    type: DataTypes.TEXT,
    allowNull: true,
  },
  Action_ticket: {
    type: DataTypes.STRING(255),
    allowNull: true,
  },
}, {
  tableName: 'table_ticket', // Nom de la table modifié
  timestamps: false, // Pas besoin de gestion automatique des timestamps
});

module.exports = Ticket;
