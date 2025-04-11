<?php
include_once __DIR__ . '/../modelo/conexion.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : NULL;
    $tipo_operacion = isset($_POST['tipo_operacion']) ? trim($_POST['tipo_operacion']) : '';
    $presupuesto = isset($_POST['presupuesto']) ? floatval($_POST['presupuesto']) : NULL;
    $metodo_contacto = isset($_POST['metodo_contacto']) ? trim($_POST['metodo_contacto']) : '';
    $fecha_contacto = isset($_POST['fecha_contacto']) ? trim($_POST['fecha_contacto']) : NULL;
    $hora_contacto = isset($_POST['hora_contacto']) ? trim($_POST['hora_contacto']) : NULL;


    if (empty($nombre) || empty($email) || empty($telefono) || empty($tipo_operacion) || empty($metodo_contacto)) {
        echo "<script>alert('❌ Todos los campos obligatorios deben llenarse.'); window.history.back();</script>";
        exit();
    }

    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $email = mysqli_real_escape_string($conexion, $email);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    $mensaje = !empty($mensaje) ? mysqli_real_escape_string($conexion, $mensaje) : NULL;
    $tipo_operacion = mysqli_real_escape_string($conexion, $tipo_operacion);
    $metodo_contacto = mysqli_real_escape_string($conexion, $metodo_contacto);
    $fecha_contacto = !empty($fecha_contacto) ? mysqli_real_escape_string($conexion, $fecha_contacto) : NULL;
    $hora_contacto = !empty($hora_contacto) ? mysqli_real_escape_string($conexion, $hora_contacto) : NULL;


    $sql = "INSERT INTO contactos (nombre, email, telefono, mensaje, tipo_operacion, presupuesto, metodo_contacto, fecha_contacto, hora_contacto) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {

        $stmt->bind_param("sssssdsss", $nombre, $email, $telefono, $mensaje, $tipo_operacion, $presupuesto, $metodo_contacto, $fecha_contacto, $hora_contacto);


        if ($stmt->execute()) {
            echo "<script>alert('✅ Formulario enviado con éxito.'); window.location.href='../contacto.php';</script>";
        } else {
            echo "<script>alert('❌ Error al guardar los datos: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('❌ Error preparando la consulta: " . $conexion->error . "'); window.history.back();</script>";
    }

}
?>