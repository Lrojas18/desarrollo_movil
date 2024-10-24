<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Registrados</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
</head>
<body>
    <div class="container mt-5">

        <h3 class="text-center">Datos Registrados</h3>
        <!-- Botón que siempre permanece visible -->
        <div class="mb-3">
            <a href="index.php" class="btn btn-primary btn-sm">Regresar al Formulario</a>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover" id="data-table">
                <thead class="table-light">
                    <tr>
                        <th>Cédula</th> <!-- Modificado de ID a Cédula -->
                        <th>Nombre Completo</th>
                        <th>Dirección</th>
                        <th>Observación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Incluir el archivo de conexión a la base de datos
                include 'conexion.php';

                // Definir la consulta SQL para seleccionar los datos de la tabla
                $sql = "SELECT * FROM usuarios ORDER BY cedula DESC"; // Mostrar el último registro insertado primero

                // Ejecutar la consulta en la base de datos y almacenar el resultado en la variable $result
                $result = $conn->query($sql);

                // Verificar si el número de filas del resultado es mayor a 0
                if ($result->num_rows > 0) {
                    // Recorrer cada fila del resultado usando un bucle while
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["cedula"] . "</td> <!-- Cambiado de id a cedula -->
                                <td>" . $row["nombre_completo"] . "</td>
                                <td>" . $row["direccion"] . "</td>
                                <td>" . $row["observacion"] . "</td>
                                <td>
                                    <a href='editar.php?cedula=" . $row['cedula'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                    <a href='eliminar.php?cedula=" . $row['cedula'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este registro?');\">Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay datos registrados</td></tr>";
                }

                // Cerrar la conexión con la base de datos
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap y JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
                },
                "pagingType": "full_numbers",
                "order": [[0, "desc"]], // Ordenar por la primera columna (Cédula) en orden descendente
                "dom": '<<"d-flex justify-content-between"lf>t<"d-flex justify-content-center"p>>'
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
