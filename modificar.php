<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['dni'])) {
    $dni = $_GET['dni'];
    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE DNI = :dni");
    $consulta->bindParam(':dni', $dni);
    $consulta->execute();
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Mostrar formulario precargado para modificar
        echo '<form action="modificar.php" method="post">
            <input type="hidden" name="dni" value="'.$usuario['DNI'].'">
            <label>Nombre: </label><input type="text" name="nombre" value="'.$usuario['Nombre'].'"><br>
            <label>Apellido: </label><input type="text" name="apellido" value="'.$usuario['Apellido'].'"><br>
            <label>Teléfono: </label><input type="text" name="telefono" value="'.$usuario['Telefono'].'"><br>
            <label>Correo: </label><input type="text" name="correo" value="'.$usuario['Correo'].'"><br>
            <label>Fecha: </label><input type="datetime-local" name="fecha" value="'.$usuario['Fecha'].'"><br>
            <input type="submit" value="Actualizar">
        </form>';
    } else {
        echo 'Usuario no encontrado.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];

    $actualizar = $conexion->prepare("UPDATE usuarios SET Nombre = :nombre, Apellido = :apellido, Telefono = :telefono, Correo = :correo, Fecha = :fecha WHERE DNI = :dni");
    $actualizar->bindParam(':nombre', $nombre);
    $actualizar->bindParam(':apellido', $apellido);
    $actualizar->bindParam(':telefono', $telefono);
    $actualizar->bindParam(':correo', $correo);
    $actualizar->bindParam(':fecha', $fecha);
    $actualizar->bindParam(':dni', $dni);

    if ($actualizar->execute()) {
        header('Location: listado.php');
    } else {
        echo 'Error al actualizar el usuario.';
    }
}
?>