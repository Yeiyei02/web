<?php 
session_start(); 
include 'conexion.php'; // Incluir archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['email']; 
    $contraseña = $_POST['contraseña'];

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Almacenar información del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: dashboard.php"); // Redirigir al dashboard
            exit();
        } else {
            $error = "Credenciales incorrectas."; // Mensaje de error
        }
    } else {
        $error = "Credenciales incorrectas."; // Mensaje de error
    }
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS personalizado -->
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <form method="POST" action="login.php">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña:</label>
                                <input type="password" class="form-control" name="contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </form>
                        <p class="text-center mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const emailInput = document.querySelector("input[name='email']");
        const passwordInput = document.querySelector("input[name='contraseña']");

        form.addEventListener("submit", function(event) {
            let valid = true;

            // Validar email
            if (!emailInput.value) {
                valid = false;
                alert("Por favor, ingresa tu email.");
            }

            // Validar contraseña
            if (!passwordInput.value) {
                valid = false;
                alert("Por favor, ingresa tu contraseña.");
            }

            if (!valid) {
                event.preventDefault(); // Evitar el envío del formulario si hay errores
            }
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>