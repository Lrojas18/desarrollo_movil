<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado una cédula por GET, esto sucede cuando el usuario hace clic en editar un registro
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula']; // Almacenar el valor de la cédula en una variable

    // Preparar la consulta SQL para obtener los datos del registro seleccionado
    $sql = "SELECT * FROM usuarios WHERE cedula = ?";
    
    // Preparar la sentencia para evitar inyecciones SQL
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Vincular el parámetro de la cédula a la consulta preparada
        mysqli_stmt_bind_param($stmt, "s", $cedula);
        
        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);
        
        // Obtener los resultados de la consulta
        $result = mysqli_stmt_get_result($stmt);
        
        // Almacenar los datos del registro en un array asociativo
        $row = mysqli_fetch_assoc($result);

        // Verificar si el registro fue encontrado, de lo contrario mostrar un mensaje de error
        if (!$row) {
            echo "Registro no encontrado.";
            exit();
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt);
    }
}

// Verificar si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados desde el formulario
    $cedula = $_POST['cedula'];
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $observacion = $_POST['observacion'];

    // Verificar que todos los campos estén completos antes de proceder
    if (!empty($nombre_completo) && !empty($direccion) && !empty($observacion)) {
        // Preparar la consulta SQL para actualizar los datos del registro
        $sql = "UPDATE usuarios SET nombre_completo = ?, direccion = ?, observacion = ? WHERE cedula = ?";
        
        // Preparar la sentencia para actualizar el registro
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Vincular los parámetros a la consulta (nombre, dirección, observación, cedula)
            mysqli_stmt_bind_param($stmt, "ssss", $nombre_completo, $direccion, $observacion, $cedula);
            
            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                // Mostrar el mensaje de alerta y redirigir
                echo "<script>
                    alert('Datos actualizados correctamente.');
                    window.location.href = 'tabla.php';
                    </script>";
                exit(); // Terminar el script para evitar la ejecución de código innecesario
            } else {
                // Mostrar un mensaje de error si la actualización falla
                echo "Error al actualizar los datos: " . mysqli_error($conn);
            }

            // Cerrar la sentencia preparada
            mysqli_stmt_close($stmt);
        }
    } else {
        // Si algún campo está vacío, mostrar un mensaje de advertencia
        echo "Por favor, completa todos los campos.";
    }
}

// Cerrar la conexión con la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>

    <!-- Incluir la hoja de estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Tarjeta que contiene el formulario -->
        <div class="card">
            <!-- Encabezado de la tarjeta con el título centrado -->
            <div class="card-header text-center">
                <h2>Editar Registro</h2>
            </div>
            <!-- Cuerpo de la tarjeta que contiene el formulario -->
            <div class="card-body">
                <!-- Formulario que envía datos a 'editar.php' usando el método POST -->
                <form action="editar.php" method="POST">
                    <!-- Campo oculto que contiene la cédula del registro -->
                    <input type="hidden" name="cedula" value="<?php echo $row['cedula']; ?>">
                    
                    <!-- Campo para el nombre completo -->
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $row['nombre_completo']; ?>" required>
                    </div>
                    
                    <!-- Campo para la dirección -->
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>" required>
                    </div>

                    <!-- Campo para la observación -->
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3" required><?php echo $row['observacion']; ?></textarea>
                    </div>

                    <!-- Botones para enviar el formulario o cancelar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir el script de Bootstrap para manejar interacciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>