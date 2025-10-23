<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            
            $alertas = $auth ->validarLogin();
            if(empty($alertas)){
                //comprobar que exista el usuario
                $usuario = Usuario::where('email',$auth->email);
                if($usuario){
                    //verificar el password
                    if( $usuario->comprobarPasswordAndVerificado($auth->password)){
                        //autenticar el usuario
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('location: /admin');
                        } else{
                            header('location: /cita');
                        }
                        
                    }
                } else{
                    Usuario::setAlerta('error','El usuario no existe');
                    
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas'=>$alertas
        ]);
    }
    public static function logout() {
        echo 'Desde logout';
    }
    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth-> validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email',$auth->email);
                if($usuario && $usuario-> confirmado === "1"){
                    debuguear('si existe y esta confirmado');
                }else{
                    debuguear('no existe o no esta confirmado');
                }
            }
        }
        $router->render('auth/olvide-password',[
            'alertas'=> $alertas
        ]);
    }
    public static function recuperar() {
        echo 'Desde recuperar';
    }
    public static function crear( Router $router) {
        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario -> sincronizar($_POST);
            $alertas = $usuario -> validarNuevaCuenta();
            // Revisar que alertas este vacio
            if(empty($alertas)){
                //verificar que el usuario no este registrado
                $resultado = $usuario -> existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    // Hashear el password
                    $usuario -> hashPassword();
                    // Generar un token unico
                    $usuario -> crearToken();
                    
                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre,
                    $usuario->token);
                    
                    $email -> enviarConfirmacion();
                    //crear el usuario
                    $resultado = $usuario -> guardar();
                    if($resultado){
                        header('Location: /mensaje?mensaje=Cuenta creada correctamente, revisa tu email para confirmar tu cuenta');
                    }
                }
            }
        }
        $router->render('auth/crear-cuenta',[
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje',[
            'titulo'=>'Cuenta creada correctamente'
        ]);
    }
    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token',$token);
        
        if(empty($usuario)){
            //mostrar mensaje de error
            Usuario::setAlerta('error','Token no válido');
        } else{
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta comprobada correctamente');
        }
        
        //Obtener alertas
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta',[
            'alertas'=>$alertas
        ]);
    }
}