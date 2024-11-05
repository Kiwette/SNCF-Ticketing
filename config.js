const { Sequelize } = require('sequelize');


const sequelize = new Sequelize('sncf-ticketing', 'root', '', {
    host: 'localhost',
    dialect: 'mysql',
});

// Test de la connexion à la base de données
sequelize.authenticate()
    .then(() => {
        console.log('Connexion à la base de données réussie.');
    })
    .catch(err => {
        console.error('Impossible de se connecter à la base de données:', err);
    });

module.exports = sequelize; 
