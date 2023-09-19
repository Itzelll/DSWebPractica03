<?php
session_start(); // Inicia la sesión

function conectarBaseDatos(){
    // Conexión a PostgreSQL
    $ip = "pgsql:host=172.17.0.2;port=5432;dbname=mydb;";
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

$conexion = conectarBaseDatos();

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$username = $_POST["username"];
$password = $_POST["password"];

$consulta = "SELECT id, username, password FROM usuarios WHERE username = ?";
$stmt = $conexion->prepare($consulta);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//imprimir datos
echo $row['id'];
echo "<br>",$row['username'];
echo "<br>",$row['password'], "<br>";

if ($row && password_verify($password, trim($row['password']))) {
    // Inicio de sesión exitoso
    $_SESSION['id_usuario'] = $row['id_usuario'];
    header("Location: index.php"); 
    exit; 
} else {
    // Inicio de sesión fallido
    echo "Nombre de usuario o contraseña incorrectos.";
}
?>
