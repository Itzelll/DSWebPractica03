<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php
    session_start();

    function conectarBaseDatos(){
        //conection to postgresql
        $ip = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
        $username = "postgres";
        $password = "postgres";
        try {
            $pdo = new PDO($ip, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Error en la conexión a la base de datos: ' . $e->getMessage());
        }
    }
    
    if (isset($_SESSION['usuario'])) {
        header("Location: dashboard.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdo = conectarBaseDatos();
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        if ($usuario === "usuario" && $contrasena === "contrasena") {
            $_SESSION['usuario'] = $usuario;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required><br><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
