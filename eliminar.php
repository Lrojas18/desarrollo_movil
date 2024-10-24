<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado una cédula por GET
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula']; // Almacenar el valor de la cédula en una variable

    // Preparar la consulta SQL para eliminar el registro
    $sql = "DELETE FROM usuarios WHERE cedula = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Vincular la cédula a la consulta
        mysqli_stmt_bind_param($stmt, "s", $cedula);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Mostrar el mensaje de alerta y redirigir a la tabla
            echo "<script>
                    alert('Registro eliminado correctamente.');
                    window.location.href = 'tabla.php';
                  </script>";
            exit();
        } else {
            // Mostrar mensaje de error si no se pudo eliminar
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
