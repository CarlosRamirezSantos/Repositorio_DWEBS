<?php
class Usuario {
    private static $instancia = null;
    private $usuarios = [];
    private static $id = 0; // atributo estático para el id

    private function __construct() {
        $this->usuarios = [
            [ "id" => 1, "nombre" => "Ana", "edad" => 23, "password" => "fdfdf2" ],
            [ "id" => 2, "nombre" => "Luis", "edad" => 31, "password" => "ghfhgmh2" ]
        ];
        self::$id = 2; // inicializa el último id según los datos existentes
    }

    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Usuario();
        }
        return self::$instancia;
    }

    public function getAllUsuarios() {
        return $this->usuarios;
    }

    public function getUserById($id) {
        foreach ($this->usuarios as $usuario) {
            if ($usuario["id"] == $id) {
                return $usuario;
            }
        }
        return null;
    }

    public function agregarUsuario($nombre, $edad, $password) {
        self::$id++; // incrementa el id estático
        $nuevo = [
            "id" => self::$id,
            "nombre" => $nombre,
            "edad" => $edad,
            "password" => $password
        ];
        $this->usuarios[] = $nuevo;
        return $nuevo;
    }
}
?>