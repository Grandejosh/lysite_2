<!DOCTYPE html>
<html>
<head>
    <title>Formulario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Resultado de consulta DNI</h1>

            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="{{ $dni['nombres'] }}" readonly required>
            </div>

            <div class="form-group">
                <label for="apellidoP">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellidoP" name="apellidoP" value="{{ $dni['apellidoPaterno'] }}" readonly required>
            </div>

            <div class="form-group">
                <label for="apellidoM">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellidoM" name="apellidoM" value="{{ $dni['apellidoMaterno'] }}" readonly required>
            </div>

            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" class="form-control" id="dni" name="dni" value="{{ $dni['numeroDocumento'] }}" readonly required>
            </div>

    </div>
    <h4>
        {{ dd($dni) }}
    </h4>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
