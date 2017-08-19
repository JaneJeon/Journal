<?php

class Routes {
    # routes that automatically redirect
    private static $autoRoute = ['login' => 'add',
                                 'register' => 'add',
                                 'add' => 'view',
                                 'test' => 'test'];
    
    public static function redirect($url) {
        header('Location: '.Routes::$autoRoute[$url].'.php');
        exit;
    }

//    public static function next($url) {
//        return 'Location: '.Routes::$autoRoute[$url].'.php';
//    }
}