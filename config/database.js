-- Active: 1727861747808@@127.0.0.1@3306@sncf_ticketing
require('dotenv').config(); // Charge les variables d'environnement

const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('sncf_ticketing', 'root', '', {
    host: 'localhost',
    dialect: 'mysql', // ou 'sqlite', 'postgres', etc.
});

module.exports = sequelize;
