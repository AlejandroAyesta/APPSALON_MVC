<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    // Verificar el password
                    if($usuario->comprobarCampos($auth->password)) {
                        // Autenticar el usuario
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('location: /admin');
                        } else {
                            header('location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }
    public static function logout() { 
        
        $_SESSION = [];
        header('location: /');
    }
    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmial();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1") {
                    // Generar Token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarIntrucciones();

                    // Alerta de éxito
                    Usuario::setAlerta('exito', 'Revisa tu correo para reestablecer tu contraseña');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no está verificado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router) {
        
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        
        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = '';

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('location: /password-reestablecido');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function reestablecido(Router $router) {
        $router->render('auth/password-reestablecido', []);
    }
    public static function crear(Router $router) {
        
        $usuario = new Usuario;

        // Alertas vacías
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas esté vacío
            if(empty($alertas)) {
                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un token único
                    $usuario->crearToken();

                    // Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token,);

                    $email->enviarConfirmacion();
                    
                   // Crear el usuario
                   $resultado = $usuario->guardar();
                    if($resultado) {
                        header('location: /mensaje');
                    }
                    
                }
            }
        }

        $router->render('auth/crear', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {

        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Modificar confirmación
            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada exitosamente');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // Renderizar la vista
        $router->render('auth/confirmar', [
            'alertas' => $alertas
        ]);
    }
}