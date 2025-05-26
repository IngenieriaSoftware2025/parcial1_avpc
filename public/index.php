<?php 
require_once __DIR__ . '/../includes/app.php';

use Controllers\LibroController;
use Controllers\PrestamoController;
use Controllers\PersonaController;
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

// RUTAS PARA LIBROS
//RUTAS PARA LIBROS
$router->get('/libros', [LibroController::class, 'renderizarPagina']);
$router->post('/libros/guardarAPI', [LibroController::class, 'guardarAPI']);
$router->get('/libros/buscarAPI', [LibroController::class, 'buscarAPI']);
$router->post('/libros/modificarAPI', [LibroController::class, 'modificarAPI']);
$router->get('/libros/eliminar', [LibroController::class, 'EliminarAPI']);

// RUTAS PARA PRESTAMOS
//RUTAS PARA PRÉSTAMOS
$router->get('/prestamos', [PrestamoController::class, 'renderizarPagina']);
$router->post('/prestamos/guardarAPI', [PrestamoController::class, 'guardarAPI']);
$router->get('/prestamos/buscarAPI', [PrestamoController::class, 'buscarAPI']);
$router->post('/prestamos/marcarDevueltoAPI', [PrestamoController::class, 'marcarDevueltoAPI']);
$router->get('/prestamos/obtenerLibrosAPI', [PrestamoController::class, 'obtenerLibrosAPI']);
$router->get('/prestamos/obtenerPersonasAPI', [PrestamoController::class, 'obtenerPersonasAPI']);
$router->get('/prestamos/eliminar', [PrestamoController::class, 'EliminarAPI']);

// RUTAS PARA PEROSNAS
//RUTAS PARA PERSONAS
$router->get('/personas', [PersonaController::class, 'renderizarPagina']);
$router->post('/personas/guardarAPI', [PersonaController::class, 'guardarAPI']);
$router->get('/personas/buscarAPI', [PersonaController::class, 'buscarAPI']);
$router->get('/personas/eliminar', [PersonaController::class, 'EliminarAPI']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();