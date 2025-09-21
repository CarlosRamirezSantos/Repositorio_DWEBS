<?php
header('Content-Type: application/json');
require_once 'usuario.php';

// Obtener la instancia Singleton
$usuariosSingleton = Usuario::getInstancia();

$method = $_SERVER['REQUEST_METHOD'];
$parametros = explode("/", $_SERVER['REQUEST_URI']);
unset($parametros[0]);

if ($method == "GET") {
    if (($parametros[1] ?? '') == "usuarioConcreto") {
        $user = $usuariosSingleton->getUserById(intval($parametros[2] ?? 0));
        echo json_encode($user);
    } elseif (($parametros[1] ?? '') == "usuarios") {
        echo json_encode($usuariosSingleton->getAllUsuarios());
    }
} elseif ($method == "POST") {
    if (($parametros[1] ?? '') === "agregarUsuario") {
        $datosRecibidos = file_get_contents("php://input");
        $usuarioNuevo = json_decode($datosRecibidos,true);

        // Mostrar datos recibidos para debug (opcional)
        echo $usuarioNuevo['nombre'];
        echo $usuarioNuevo['edad'];
        echo $usuarioNuevo['password'];

        // Llamar a agregarUsuario con parámetros individuales
        $usuariosSingleton->agregarUsuario($usuarioNuevo['nombre'], $usuarioNuevo['edad'], $usuarioNuevo['password']);
        header("HTTP/1.1 200 OK");
    } elseif (($parametros[1] ?? '') === "login") {
        $datosRecibidos = file_get_contents("php://input");
        $datosLoginUsuario = json_decode($datosRecibidos,true);

        $usuariosExistentes = $usuariosSingleton->getAllUsuarios();
        
        foreach ($usuariosExistentes as $user) {
            if ($user['nombre'] === $datosLoginUsuario['nombre'] && $user['password'] === $datosLoginUsuario['password']) {
                header("HTTP/1.1 200 ok");
            }
        }

        if ($loginValido) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }
}
?>
