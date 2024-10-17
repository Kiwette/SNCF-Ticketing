const express = require('express');
const PHPExpress = require('php-express')({
    bin: 'C:\\Program Files\\PHP\\php.exe'  // Chemin vers votre exécutable PHP
});

const app = express();

// Configurer le moteur de vue pour PHP
app.set('views', './views');
app.engine('php', PHPExpress.engine);
app.set('view engine', 'php');

// Utiliser php-express pour gérer les fichiers PHP
app.use(PHPExpress.router);

// Route pour la page d'accueil
app.get('/', (req, res) => {
    res.render('index.php');  // Votre fichier PHP dans le dossier 'views'
});

// Lancer le serveur sur un nouveau port (par exemple, 4000)
const port = process.env.PORT || 4000;
app.listen(port, () => {
    console.log(`Serveur Express exécutant des fichiers PHP sur http://localhost:${port}`);
});
