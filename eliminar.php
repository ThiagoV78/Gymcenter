<?php
require 'conexion.php';

if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];
    $eliminar = $conexion->prepare("DELETE FROM usuarios WHERE DNI = :dni");
    $eliminar->bindParam(':dni', $dni);

    if ($eliminar->execute()) {
        header('Location: listado.php');
    } else {
        echo 'Error al eliminar el usuario.';
    }
} else {
    echo 'No se especificó un DNI para eliminar.';
}
?>