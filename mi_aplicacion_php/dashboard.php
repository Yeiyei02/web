<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
include 'conexion.php';

// Manejo de apuntes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_apunte'])) {
    $apunte = $_POST['apunte'];
    $usuario_id = $_SESSION['usuario_id'];

    // Guardar el apunte en la base de datos
    $sql = "INSERT INTO apuntes (usuario_id, contenido) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $usuario_id, $apunte);
    $stmt->execute();
}

// Obtener apuntes del usuario
$sql = "SELECT * FROM apuntes WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
$apuntes = $result->fetch_all(MYSQLI_ASSOC);

// Manejo de borrado de apuntes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar_apunte'])) {
    $apunte_id = $_POST['apunte_id'];

    // Borrar el apunte de la base de datos
    $sql = "DELETE FROM apuntes WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $apunte_id, $_SESSION['usuario_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS personalizado -->
    <style>
        /* Estilos para la barra de navegación */
        .nav-link {
            transition: color 0.3s;
        }
        .nav-link:hover {
            color:rgb(117, 103, 179);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#">Mi Página</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="html/programar.html">Programar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="html/beneficios.html">Beneficios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="html/recursos.html">Recursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="html/testimonios.html">Testimonios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="html/proyectos.html">Proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></h1>
        <p class="text-center">Esta es tu área de usuario. Aquí puedes ver tu información y acceder a otras funcionalidades.</p>

        <!-- Sección de Apuntes -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Apuntes</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="dashboard.php">
                    <textarea class="form-control" name="apunte" rows="4" placeholder="Escribe tu apunte aquí..." required></textarea>
                    <button type="submit" name="guardar_apunte" class="btn btn-primary mt-2">Guardar Apunte</button>
                </form>
                <h5 class="mt-4">Tus Apuntes:</h5>
                <ul class="list-group">
                    <?php foreach ($apuntes as $apunte): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($apunte['contenido']); ?>
                            <form method="POST" action="dashboard.php" class="ml-2">
                                <input type="hidden" name="apunte_id" value="<?php echo $apunte['id']; ?>">
                                <button type="submit" name="borrar_apunte" class="btn btn-danger btn-sm">Borrar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Imagen sobre Programación -->
        <div class="text-center">
            <h4>Aprende a Programar</h4>
            <img src="https://www.educaciontrespuntocero.com/wp-content/uploads/2021/02/Apps-y-juegos-para-aprender-a-programar-978x652.jpg" alt="Programación" class="img-fluid" style="max-width: 50%; height: auto;">
            <p>La programación es una habilidad valiosa en el mundo actual. ¡Sigue aprendiendo!</p>
        </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 La Importancia de Saber Programar. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>