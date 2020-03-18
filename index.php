<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';

require_once './BACKEND/clases/AccesoDatos.php';
require_once './BACKEND/clases/Anteojo.php';
require_once './BACKEND/clases/Login.php';
require_once './BACKEND/clases/Usuario.php';
require_once './BACKEND/clases/Ventas.php';
require_once './BACKEND/clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);

#ANTEOJOS

$app->post('[/]', \Anteojo::class . '::Alta');
$app->get('/anteojos',\Anteojo::class . '::TraerTodos');
$app->delete('[/]',\Anteojo::class . '::Borrar')->add(\MW::class . '::MWVerificarPropietario')->add(\MW::class . ':VerificarToken');
$app->put('[/]',\Anteojo::class . '::Modificar')->add(\MW::class . '::MWVerificarEncargado')->add(\MW::class . '::MWVerificarPropietario')->add(\MW::class . ':VerificarToken');

#USUARIOS

$app->post('/usuarios', \Usuario::class . '::Alta');//->add(\MW::class . ':VerificarBDCorreoYClave')->add(\MW::class . '::VerificarVacioCorreoYClave')->add(\MW::class . ':VerificarSetCorreoYClave');
//$app->post('/usuarios', \Usuario::class . '::Alta');
$app->get('[/]',\Usuario::class . '::TraerTodos');


#Login
$app->post('/login', \Login::class . '::LoginIngreso')->add(\MW::class .'::VerificarSetCorreoYClave')->add(\MW::class . '::VerificarVacioCorreoYClave')->add(\MW::class . ':VerificarBDCorreoYClave');//cambiar orden
//->add(\MW::class . ':VerificarBDCorreoYClave')->add(\MW::class . '::VerificarVacioCorreoYClave')->add(\MW::class . ':VerificarSetCorreoYClave');
$app->get('/login', \Login::class . '::VerificarJWTLogin');

#Ventas
$app->group('/ventas', function () {
  $this->get('[/]',\Venta::class . '::TraerTodos');
  $this->post('[/]',\Venta::class . '::Alta');
});


$app->run();