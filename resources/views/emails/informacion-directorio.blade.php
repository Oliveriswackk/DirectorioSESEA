<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nueva información para el Directorio</title>
</head>

<body>

    <h2>Nueva información para el Directorio</h2>

    <p>
        Se recibió un archivo mediante el Directorio de Contactos.
    </p>

    <p>
        <strong>Usuario:</strong>
        {{ $usuario }}
    </p>

    <p>
        <strong>Fecha y hora:</strong>
        {{ $fecha }}
    </p>

    <p>
        <strong>Archivo:</strong>
        {{ $archivo->getClientOriginalName() }}
    </p>

    <p>
        El archivo se encuentra adjunto a este correo.
    </p>

</body>

</html>