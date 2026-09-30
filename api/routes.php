<?php

$router->get('/estado', 'EstadoController@ver');

// 1, 2 y 3: clientes
$router->get('/clientes', 'ClientesController@reporte');
$router->get('/clientes/:id', 'ClientesController@ver');
$router->get('/clientes/:id/autos', 'ClientesController@autos');

// 4 y 5: vendedores
$router->get('/vendedores', 'VendedoresController@listar');
$router->get('/vendedores/:id', 'VendedoresController@ver');
$router->get('/vendedores/:id/ventas', 'VendedoresController@ventas');

// 7: vehiculos
$router->get('/vehiculos', 'VehiculosController@listar');
