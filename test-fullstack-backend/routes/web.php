<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});


$router->group(['prefix'=>'v1'], function() use ($router){
    $router->post('/login', '\App\Http\Controllers\UserController@login');
    $router->post('/register', '\App\Http\Controllers\UserController@register');
    $router->get('/verify', '\App\Http\Controllers\UserController@verify');

    $router->group(['prefix'=>'product','middleware'=>'auth'], function() use ($router){
        $router->get('/list','ProductController@index');
        $router->post('/create','ProductController@create');
    });
});


