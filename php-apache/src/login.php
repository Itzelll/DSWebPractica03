
    <?php
    session_start();
    
    // Inicializa las variables para almacenar mensajes de error
    $usuarioError = $contrasenaError = "";
    
    // Variables para almacenar las credenciales de usuario
    $usuario = $contrasena = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validación del formulario
        if (empty($_POST["usuario"])) {
            $usuarioError = "El campo Usuario es obligatorio.";
        } else {
            $usuario = $_POST["usuario"];
        }
        
        if (empty($_POST["contrasena"])) {
            $contrasenaError = "El campo Contraseña es obligatorio.";
        } else {
            $contrasena = $_POST["contrasena"];
        }

        function usuarioExiste($pdo, $usuario) {
            $sql = "SELECT usuario FROM usuarios WHERE usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$clave]);
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        }

        function usuarioExistente($pdo, $usuario, $contrasena) {
            $sql = "SELECT clave FROM empleado WHERE clave = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$clave]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Si existe el dato, regresa true
            return $row['clave'] == $clave;
        }

        $dsn = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
        $username = "postgres";
        $password = "postgres";
        $pdo = new PDO($dsn, $username, $password);

        // Preparar la consulta SQL para obtener el usuario por nombre de usuario
        $sql = "SELECT id, contrasena FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($contrasena, $row['contrasena'])) {
            // Las credenciales son válidas, inicia sesión y redirige a la página principal
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            // Credenciales incorrectas, mostrar mensaje de error
            echo "<p>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
        }
    }
    ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>" required>
        <span class="error"><?php echo $usuarioError; ?></span><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" value="<?php echo $contrasena; ?>" required>
        <span class="error"><?php echo $contrasenaError; ?></span><br><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
