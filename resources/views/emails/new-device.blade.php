<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>Hola, {{ $device->user->name }}:</p>
    <p>Se detectó un inicio de sesión desde un nuevo dispositivo:</p>
    <ul>
        <li><strong>Nombre del dispositivo:</strong> {{ $device->device_name }}</li>
        <li><strong>Sistema operativo:</strong> {{ $device->device_os }}</li>
        <li><strong>Navegador:</strong> {{ $device->browser }}</li>
        <li><strong>IP:</strong> {{ $device->device_ip }}</li>
    </ul>
    <p>Si reconoces este acceso, verifica el dispositivo haciendo clic en el siguiente enlace:</p>
    <a href="{{ $verificationLink }}">Verificar Dispositivo</a>

</body>

</html>
