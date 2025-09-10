<?php

namespace Controllers;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login',[
            'titulo'=>'Iniciar Sesión'
        ]);
    }
    public static function logout() {
        echo 'Desde logout';
    }
    public static function olvide() {
        echo 'Desde olvide';
    }
    public static function recuperar() {
        echo 'Desde recuperar';
    }
    public static function crear() {
        echo 'Desde crear cuenta';
    }
}