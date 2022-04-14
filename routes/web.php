<?php

declare(strict_types=1);

/** @var Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () {
    return App\Services\Response\ResponseFactory::success([
        'name' => config('app.name'),
    ]);
});

$router->post('reset', 'SumMachineController@reset');

$router->group(['middleware' => 'token'], function () use ($router) {
    $router->post('number', 'SumMachineController@addNumber');
    $router->delete('number', 'SumMachineController@removeLastNumber');
    $router->get('sum', 'SumMachineController@getSum');
});
