<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados desde el formulario
    $cedula = $_POST['cedula'];
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $observacion = $_POST['observacion'];

    // Verificar que todos los campos estén completos y que la cédula no esté duplicada
    if (!empty($cedula) && !empty($nombre_completo) && !empty($direccion) && !empty($observacion)) {
        // Verificar si la cédula ya está registrada
        $sql_check = "SELECT * FROM usuarios WHERE cedula = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $cedula);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            echo "<script>alert('La cédula ya está registrada.');</script>";
        } else {
            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO usuarios (cedula, nombre_completo, direccion, observacion) VALUES (?, ?, ?, ?)";

            // Preparar la sentencia para evitar inyecciones SQL
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Vincular los parámetros a la consulta
                mysqli_stmt_bind_param($stmt, "ssss", $cedula, $nombre_completo, $direccion, $observacion);

                // Ejecutar la consulta
                if (mysqli_stmt_execute($stmt)) {
                    // Mostrar mensaje de éxito
                    echo "<script>
                        alert('Usuario registrado correctamente.');
                        window.location.href = 'index.php';
                    </script>";
                } else {
                    echo "Error al insertar los datos: " . mysqli_error($conn);
                }

                // Cerrar la sentencia preparada
                mysqli_stmt_close($stmt);
            }
        }

        // Cerrar la consulta de verificación
        mysqli_stmt_close($stmt_check);
    } else {
        // Si algún campo está vacío, mostrar un mensaje de advertencia
        echo "<script>alert('Por favor, completa todos los campos.');</script>";
    }
}

// Cerrar la conexión con la base de datos
mysqli_close($conn);
?>
