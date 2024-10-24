<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Registro de Usuario</h2>
            </div>
            <div class="card-body">
                <form action="insertar.php" method="POST">
                    <!-- Campo para la cédula -->
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingresa tu cédula" required>
                    </div>
                    
                    <!-- Campo para el nombre completo -->
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Ingresa tu nombre completo" required>
                    </div>
                    
                    <!-- Campo para la dirección -->
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresa tu dirección" required>
                    </div>

                    <!-- Campo para la observación -->
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Agrega una observación" required></textarea>
                    </div>

                    <!-- Botones para enviar el formulario o cancelar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <!-- Botón cancelar que redirige a index.php -->
                        <a href="tabla.php" class="btn btn-secondary">Ver registros</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
