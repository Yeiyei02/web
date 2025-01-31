const mysql = require('mysql2');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Por defecto, el usuario es 'root'
    password: '', // Por defecto, la contraseña está vacía
    database: 'mi_base_de_datos'
});

// Conectar a la base de datos
connection.connect(err => {
    if (err) {
        console.error('Error al conectar a la base de datos:', err);
        return;
    }
    console.log('Conectado a la base de datos MySQL');
});

module.exports = connection;