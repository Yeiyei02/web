const express = require('express');
const connection = require('./db'); // Importar la conexión a la base de datos
const cors = require('cors');

const app = express();
const port = 3000;

app.use(cors()); // Habilitar CORS
app.use(express.json());

// Ruta para obtener usuarios (ejemplo)
app.get('/usuarios', (req, res) => {
    connection.query('SELECT * FROM usuarios', (err, results) => {
        if (err) {
            return res.status(500).send(err);
        }
        res.json(results);
    });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
});