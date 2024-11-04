const jwt = require('jsonwebtoken');

const SECRET_KEY = 'test_appli221291'; 

const verifyToken = (req, res, next) => {
    const token = req.headers['authorization'];

    if (!token) {
        return res.status(403).json({ error: 'Aucun token fourni' });
    }

    jwt.verify(token, SECRET_KEY, (err, decoded) => {
        if (err) {
            return res.status(401).json({ error: 'Token invalide' });
        }
        req.userId = decoded.id;
        next();
    });
};

module.exports = verifyToken;
